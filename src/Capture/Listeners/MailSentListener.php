<?php

namespace BristolSU\Mail\Capture\Listeners;

use BristolSU\Mail\Models\SentMail;
use Carbon\Carbon;
use Illuminate\Mail\Events\MessageSent;
use Illuminate\Support\Facades\Log;

class MailSentListener
{

    public function handle(MessageSent $event)
    {
        if (isset($event->data['__bristol_su_mail_uuid'])) {
            $sentMail = SentMail::where('uuid', $event->data['__bristol_su_mail_uuid'])->first();
            if($sentMail) {
                $sentMail->fill([
                    'is_sent' => true,
                    'is_error' => false,
                    'error_message' => null,
                    'sent_at' => Carbon::now()
                ])->save();
                if(($parent = $sentMail->parentEmail) !== null && $parent->sent_at === null) {
                    $parent->sent_id = Carbon::now();
                    $parent->save();
                }
            } else {
                Log::info('Mail sent without recording the information. ' . json_encode($event->data));
            }
        } else {
            Log::info('Mail sent without recording the information dur to missing uuid. ' . json_encode($event->data));
        }
    }

}
