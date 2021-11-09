<?php

namespace BristolSU\Mail\Capture\Listeners;

use Aws\Ses\Exception\SesException;
use BristolSU\Mail\Capture\Events\MessageFailed;
use BristolSU\Mail\Capture\SentMailModel;

class MailFailedListener
{

    public function handle(MessageFailed $event)
    {
        $sentMailModel = null;
        if( isset($event->data['__bristol_su_mail_id']) ) {
            $sentMailModel = SentMailModel::whereId($event->data['__bristol_su_mail_id'])->firstOrFail();
        } elseif(isset($event->data['__bristol_su_mail_uuid'])) {
            $sentMailModel = SentMailModel::where('uuid', $event->data['__bristol_su_mail_uuid'])->firstOrFail();
        }

        if($sentMailModel !== null) {
            $sentMailModel->update([
                'is_sent' => false,
                'is_error' => true,
                'error_message' => $this->getMessageFromException($event->exception)
            ]);
        }
    }

    private function getMessageFromException(\Exception $exception)
    {
        if($exception instanceof SesException) {
            return $exception->getAwsErrorMessage();
        }
        return $exception->getMessage();
    }

}
