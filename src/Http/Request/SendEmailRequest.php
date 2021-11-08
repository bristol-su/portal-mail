<?php

namespace BristolSU\Mail\Http\Request;

use BristolSU\Mail\Mail\EmailPayload;
use BristolSU\Mail\Models\EmailAddress;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Fluent;

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
            'to.*' => 'string',//|email:rfc,dns',
            'from' => ['required', 'integer', 'exists:portal_mail_email_addresses,id',
                function ($attribute, $value, $fail) {
                    if(!EmailAddress::findOrFail($value)->currentUserCanAccess()) {
                        $fail('You do not have access to send from the given email address');
                    }
                }
            ],
            'subject' => 'sometimes|nullable|string|min:1|max:300',
            'cc' => 'sometimes|nullable|array',
            'cc.*' => 'string|email:rfc,dns',
            'bcc' => 'sometimes|nullable|array',
            'bcc.*' => 'string|email:rfc,dns',
            'attachments' => 'sometimes|nullable|array',
            'type' => 'string|in:url,base64,file',
            'notes' => 'sometimes|string|max:5000',
            'via' => 'sometimes|string|in:inbox,integromat'
        ];
    }

    public function withValidator(Validator $validator): Validator
    {
        $validator->sometimes('attachments.*', 'string', fn(Fluent $attributes) => in_array($attributes->get('type', 'file'), ['url, base64']));
        $validator->sometimes('type', 'required', fn(Fluent $attributes) => $attributes->get('attachments', null) !== null && count($attributes->get('attachments', [])) > 0);
        return $validator;
    }

    public function toEmailPayload(): EmailPayload
    {
        $email = EmailAddress::findOrFail($this->input('from'));
        return (new EmailPayload($this->input('content'), $this->input('to'), $email))
            ->setSubject($this->input('subject', null))
            ->setCc($this->input('cc') ?? [])
            ->setBcc($this->input('bcc') ?? [])
            ->setAttachments($this->input('attachments') ?? Arr::wrap($this->file('attachments') ?? []))
            ->setType($this->input('type', 'file'))
            ->setNotes($this->input('notes', null))
            ->setSentVia($this->input('via', 'api'));
    }

}
