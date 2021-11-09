<?php

namespace BristolSU\Mail\Http\Request;

use BristolSU\Mail\Mail\EmailPayload;
use BristolSU\Mail\Mail\Upload\UploadAttachments;
use BristolSU\Mail\Models\EmailAddress;
use Illuminate\Foundation\Http\FormRequest;

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
            'attachments.*' => [
                function ($attribute, $value, $fail) {
                    if(!UploadAttachments::validateFiles([$value])) {
                        $fail('The attachment ' . $attribute . ' is not of a supported type.');
                    }
                }
            ],
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
            ->setSentVia($this->input('via', 'api'));
        return $this->uploadFiles($payload);
    }

    private function uploadFiles(EmailPayload $payload): EmailPayload
    {
        $inputAttachments = $this->input('attachments', []);
        $fileAttachments = $this->file('attachments', []);

        $uploadAttachments = new UploadAttachments(array_merge($inputAttachments, $fileAttachments));
        $uploadAttachments->upload();
        return $uploadAttachments->getPayload($payload);
    }

}
