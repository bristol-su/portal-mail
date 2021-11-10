<?php

namespace BristolSU\Mail\Capture\Listeners;

use BristolSU\Mail\Mail\EmailPayload;
use BristolSU\Mail\Models\Attachment;
use BristolSU\Mail\Models\SentMail;
use Illuminate\Mail\Events\MessageSending;

class MailSendingListener
{

    public function handle(MessageSending $event)
    {
        if (array_key_exists('__bristol_su_mail_payload', $event->data)) {

            /** @var EmailPayload $payload */
            $payload = $event->data['__bristol_su_mail_payload'];

            $sentMail = SentMail::create([
                'to' => $payload->getTo(),
                'cc' => $payload->getCc(),
                'bcc' => $payload->getBcc(),
                'content' => $payload->getContent(),
                'subject' => $payload->getSubject(),
                'from_id' => $payload->getFrom()->id,
                'is_sent' => false,
                'uuid' => data_get($event->data, '__bristol_su_mail_uuid'),
                'user_id' => data_get($event->data, '__bristol_su_mail_user_id'),
                'notes' => $payload->getNotes(),
                'sent_via' => $payload->getSentVia(),
                'priority' => $payload->getPriority(),
                'reply_to' => $payload->getReplyTo(),
                'resend_id' => $payload->isResend() ? $payload->getResendId() : null
            ]);


            foreach(collect($payload->getAttachments())->pluck('id')->toArray() as $attachmentId) {
                Attachment::where('id', $attachmentId)->update(['sent_mail_id' => $sentMail->id]);
            }
        }
    }

}
