<?php

namespace BristolSU\Mail\Capture\Listeners;

use BristolSU\Mail\Capture\SentMailModel;
use Illuminate\Mail\Events\MessageSent;

class MailSentListener
{

    public function handle(MessageSent $event)
    {
        $data = [
            'is_sent' => true,
            'is_error' => false,
            'error_message' => null,
        ];

        if( isset($event->data['__bristol_su_mail_id']) ) {
            SentMailModel::whereId($event->data['__bristol_su_mail_id'])->update($data);
        } elseif(isset($event->data['__bristol_su_mail_uuid'])) {
            SentMailModel::where('uuid', $event->data['__bristol_su_mail_uuid'])->update($data);
        }
    }

}
