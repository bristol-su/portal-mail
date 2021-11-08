<?php

namespace BristolSU\Mail\Capture\Listeners;

use Aws\Ses\Exception\SesException;
use BristolSU\Mail\Capture\Events\MessageFailed;
use BristolSU\Mail\Capture\SentMailModel;

class MailFailedListener
{

    public function handle(MessageFailed $event)
    {
        $data = [
            'is_sent' => false,
            'is_error' => true,
            'error_message' => $this->getMessageFromException($event->exception)
        ];

        if( isset($event->data['__bristol_su_mail_id']) ) {
            SentMailModel::whereId($event->data['__bristol_su_mail_id'])->update($data);
        } elseif(isset($event->data['__bristol_su_mail_uuid'])) {
            SentMailModel::where('uuid', $event->data['__bristol_su_mail_uuid'])->update($data);
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
