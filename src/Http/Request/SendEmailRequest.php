<?php

namespace BristolSU\Mail\Http\Request;

use BristolSU\Mail\Mail\EmailPayload;
use BristolSU\Mail\Mail\Upload\UploadAttachments;
use BristolSU\Mail\Models\Attachment;
use BristolSU\Mail\Models\EmailAddress;
use BristolSU\Mail\Models\SentMail;
use BristolSU\Mail\Ses\Ses;
use BristolSU\Support\Authentication\Contracts\Authentication;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Fluent;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class SendEmailRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'content' => 'required',
            'to' => 'required|array|min:1',
            'to.*' => 'string|email:rfc,dns',
            'from_id' => ['required', 'integer', 'exists:portal_mail_email_addresses,id',
                function ($attribute, $value, $fail) {
                    $email = EmailAddress::find($value);
                    if($email === null) {
                        $fail('The from address has not been registered on the portal');
                    } else {
                        if($email->currentUserCanAccess() === false) {
                            $fail('You do not have access to send from the given email address');
                        }
                        if(Ses::isAwsEnabled() && !Ses::isEmailVerified($email->email)) {
                            $fail('The from email address has not been verified.');
                        }
                    }
                }
            ],
            'subject' => 'sometimes|nullable|string|min:1|max:300',
            'cc' => 'sometimes|nullable|array',
            'cc.*' => 'string|email:rfc,dns',
            'bcc' => 'sometimes|nullable|array',
            'bcc.*' => 'string|email:rfc,dns',
            'priority' => 'sometimes|nullable|integer|min:1|max:5',
            'reply_to' => 'sometimes|nullable|email:rfc,dns',
            'attachments' => 'sometimes|nullable|array',
            'attachments.*' => [
                function ($attribute, $value, $fail) {
                    if(!UploadAttachments::validateFiles([$value])) {
                        $fail('The attachment ' . $attribute . ' is not of a supported type.');
                    }
                }
            ],
            'existing_attachments' => 'sometimes|array',
            'existing_attachments.*' => ['integer', 'min:1', function ($attribute, $value, $fail) {
                $attachment = Attachment::find($value);
                if($attachment === null) {
                    $fail('The attachment id could not be found');
                } elseif($attachment->resend_id !== null) {
                    $fail('You cannot resend a retry of an email. Please retry the original email.');
                }
            }],
            'resend_id' => ['sometimes', 'integer', function ($attribute, $value, $fail) {
                $sentMail = SentMail::find($value);
                if($sentMail === null) {
                    $fail('The resend id could not be found');
                } else if($sentMail->resend_id !== null) {
                    $fail('You cannot resend a retry of an email. Please retry the original email.');
                }
            }],
            'notes' => 'sometimes|string|max:5000',
            'via' => 'sometimes|string'
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $contentIsArray = fn(Fluent $input) => is_array($input->get('content'));
        $actionIsGiven = fn(Fluent $input) => array_key_exists('action', $input->get('content', [])) && is_array($input->get('content', [])['action']);
        $beforeIsArray = fn(Fluent $input) => array_key_exists('before_lines', $input->get('content', [])) && is_array($input->get('content', [])['before_lines']);
        $afterIsArray = fn(Fluent $input) => array_key_exists('after_lines', $input->get('content', [])) && is_array($input->get('content', [])['after_lines']);

        $validator->sometimes('content', 'string|max:9000000', fn(Fluent $input) => is_string($input->get('content')));

        $validator->sometimes('content', 'array', $contentIsArray);
        $validator->sometimes('content.greeting', 'sometimes|string|max:255', $contentIsArray);
        $validator->sometimes('content.salutation', 'sometimes|string|max:255', $contentIsArray);
        $validator->sometimes('content.before_lines', ['sometimes', function($attribute, $value, $fail) {
            if(!is_string($value) && !is_array($value)) {
                $fail('The ' . $attribute . ' value must be an array or a string.');
            }
        }], $contentIsArray);
        $validator->sometimes('content.before_lines.*', 'string', fn(Fluent $input) => $contentIsArray && $beforeIsArray);
        $validator->sometimes('content.after_lines', ['sometimes', function($attribute, $value, $fail) {
            if(!is_string($value) && !is_array($value)) {
                $fail('The ' . $attribute . ' value must be an array or a string.');
            }
        }], $contentIsArray);
        $validator->sometimes('content.after_lines.*', 'string', fn(Fluent $input) => $contentIsArray && $afterIsArray);
        $validator->sometimes('content.action', 'sometimes|array', $contentIsArray);
        $validator->sometimes('content.action.text', 'required|string', fn(Fluent $input) => $contentIsArray($input) && $actionIsGiven($input));
        $validator->sometimes('content.action.url', 'required|url', fn(Fluent $input) => $contentIsArray($input) && $actionIsGiven($input));
        $validator->sometimes('content.action.type', 'required|string|in:error,success,action', fn(Fluent $input) => $contentIsArray($input) && $actionIsGiven($input));
    }

    public function toEmailPayload(): EmailPayload
    {
        $data = $this->validated();

        $email = EmailAddress::findOrFail(data_get($data, 'from_id'));
        $payload = (new EmailPayload(
            $this->prepareContentForPayload(data_get($data, 'content')),
            data_get($data, 'to'),
            $email
        ))
            ->setSubject(data_get($data, 'subject'))
            ->setCc(data_get($data, 'cc') ?? [])
            ->setBcc(data_get($data, 'bcc') ?? [])
            ->setNotes(data_get($data, 'notes'))
            ->setPriority(data_get($data, 'priority'))
            ->setReplyTo(data_get($data, 'reply_to'))
            ->setNotes(data_get($data, 'notes'))
            ->setResendId(data_get($data, 'resend_id'))
            ->setSentVia(data_get($data, 'via', 'api'));

        $existingAttachments = [];
        foreach(data_get($data, 'existing_attachments', []) as $attachmentId) {
            $existingAttachments[] = Attachment::findOrFail($attachmentId);
        }

        return $this->uploadFiles($payload, $existingAttachments);
    }

    private function prepareContentForPayload($content)
    {
        if(is_string($content)) {
            return $content;
        }

        if(array_key_exists('before_lines', $content) && is_string($content['before_lines'])) {
            $content['before_lines'] = Arr::wrap($content['before_lines']);
        }
        if(array_key_exists('after_lines', $content) && is_string($content['after_lines'])) {
            $content['after_lines'] = Arr::wrap($content['after_lines']);
        }
        return $content;
    }

    private function uploadFiles(EmailPayload $payload, array $existingAttachments): EmailPayload
    {
        if(!array_key_exists('attachments', $this->validated()) || empty($this->validated()['attachments'])) {
            return $payload;
        }
        $uploadAttachments = new UploadAttachments(data_get($this->validated(), 'attachments', []));
        if($payload->isResend()) {
            $uploadAttachments->appendExisting($existingAttachments);
        }

        $uploadAttachments->upload();
        return $uploadAttachments->getPayload($payload);
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $data = collect($this->all())
            ->only(['content', 'to', 'from_id', 'subject', 'cc', 'bcc', 'priority', 'reply_to', 'resend_id', 'notes', 'via'])
            ->except(array_map(fn(string $key) => Str::before($key, '.'), $validator->errors()->keys()));

        if($data->has('from_id') && $data->get('from_id')) {
            SentMail::create($data->merge([
                'is_error' => true,
                'is_sent' => false,
                'uuid' => Str::uuid(),
                'user_id' => app(Authentication::class)->hasUser() ? app(Authentication::class)->getUser()->id() : null,
                'error_message' => json_encode([
                    'validation' => true,
                    'data' => collect($this->all())->only(array_map(fn(string $key) => Str::before($key, '.'), $validator->errors()->keys()))->toArray(),
                    'errors' => $validator->errors()->toArray(),
                ]),
                'sent_via' => $data->get('via'),
                'from_id' => $data->get('from_id')
            ])->toArray());
        }

        parent::failedValidation($validator);
    }

}
