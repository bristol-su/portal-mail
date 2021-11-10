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
use Illuminate\Support\Facades\Storage;
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
            'content' => 'required|string|max:9000000',
            'to' => 'required|array|min:1',
            'to.*' => 'string|email:rfc,dns',
            'from' => ['required', 'integer', 'exists:portal_mail_email_addresses,id',
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

    public function toEmailPayload(): EmailPayload
    {
        $email = EmailAddress::findOrFail($this->input('from'));
        $payload = (new EmailPayload($this->input('content'), $this->input('to'), $email))
            ->setSubject($this->input('subject', null))
            ->setCc($this->input('cc') ?? [])
            ->setBcc($this->input('bcc') ?? [])
            ->setNotes($this->input('notes', null))
            ->setPriority($this->input('priority', null))
            ->setReplyTo($this->input('reply_to', null))
            ->setNotes($this->input('notes', null))
            ->setResendId($this->input('resend_id', null))
            ->setSentVia($this->input('via', 'api'));

        $existingAttachments = [];
        foreach($this->input('existing_attachments', []) as $attachmentId) {
            $existingAttachments[] = Attachment::findOrFail($attachmentId);
        }

        return $this->uploadFiles($payload, $existingAttachments);
    }

    private function uploadFiles(EmailPayload $payload, array $existingAttachments): EmailPayload
    {
        $inputAttachments = $this->input('attachments', []);
        $fileAttachments = $this->file('attachments', []);

        $uploadAttachments = new UploadAttachments(array_merge($inputAttachments, $fileAttachments));
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
            ->only(['content', 'to', 'from', 'subject', 'cc', 'bcc', 'priority', 'reply_to', 'resend_id', 'notes', 'via'])
            ->except(array_map(fn(string $key) => Str::before($key, '.'), $validator->errors()->keys()));

        if($data['from']) {
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
                'sent_via' => $data->get('via', null),
                'from_id' => $data->get('from')
            ])->toArray());
        }

        parent::failedValidation($validator);
    }

}
