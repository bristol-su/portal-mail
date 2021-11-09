<?php

namespace BristolSU\Mail\Capture\Listeners;

use BristolSU\Mail\Capture\SentMailModel;
use Illuminate\Mail\Events\MessageSending;

class MailSendingListener
{

    public function handle(MessageSending $event)
    {
        /*
         * If __bristol_su_sent_mail_id is set, the mail has already been sent, so we
         * can use the previous model.
         */
        if (array_key_exists('__bristol_su_mail_id', $event->data)) {
            $sentMail = SentMailModel::findOrFail(data_get($event->data, '__bristol_su_mail_id'));
            $sentMail->update([
                'is_sent' => false,
                'is_error' => false,
                'error_message' => null,
                'tries' => $sentMail->tries + 1
            ]);
        } else {
            SentMailModel::create([
                'to' => data_get($event->data, '__bristol_su_mail_to', []),
                'cc' => data_get($event->data, '__bristol_su_mail_cc', []),
                'bcc' => data_get($event->data, '__bristol_su_mail_bcc', []),
                'content' => data_get($event->data, '__bristol_su_mail_content'),
                'subject' => data_get($event->data, '__bristol_su_mail_subject'),
                'from_id' => data_get($event->data, '__bristol_su_mail_from_id'),
                'is_sent' => false,
                'uuid' => data_get($event->data, '__bristol_su_mail_uuid'),
                'user_id' => data_get($event->data, '__bristol_su_mail_user_id'),
                'notes' => data_get($event->data, '__bristol_su_mail_notes'),
                'sent_via' => data_get($event->data, '__bristol_su_mail_sent_via'),
                'tries' => 1
            ]);
        }
    }

}
