<?php

namespace BristolSU\Mail\Capture\Listeners;

use BristolSU\Mail\Models\SentMail;
use Carbon\Carbon;
use Illuminate\Mail\Events\MessageSent;

class MailSentListener
{

    public function handle(MessageSent $event)
    {
        if (isset($event->data['__bristol_su_mail_uuid'])) {
            SentMail::where('uuid', $event->data['__bristol_su_mail_uuid'])->update([
                'is_sent' => true,
                'is_error' => false,
                'error_message' => null,
                'sent_at' => Carbon::now()
            ]);
        }
    }

}
