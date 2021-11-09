<?php

namespace BristolSU\Mail\Capture\Listeners;

use BristolSU\Mail\Models\SentMail;
use Carbon\Carbon;
use Illuminate\Mail\Events\MessageSent;

class MailSentListener
{

    public function handle(MessageSent $event)
    {
        $data = [
            'is_sent' => true,
            'is_error' => false,
            'error_message' => null,
            'sent_at' => Carbon::now()
        ];

        if( isset($event->data['__bristol_su_mail_id']) ) {
            SentMail::whereId($event->data['__bristol_su_mail_id'])->update($data);
        } elseif(isset($event->data['__bristol_su_mail_uuid'])) {
            SentMail::where('uuid', $event->data['__bristol_su_mail_uuid'])->update($data);
        }
    }

}
