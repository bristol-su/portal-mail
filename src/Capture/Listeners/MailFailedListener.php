<?php

namespace BristolSU\Mail\Capture\Listeners;

use Aws\Ses\Exception\SesException;
use BristolSU\Mail\Capture\Events\MessageFailed;
use BristolSU\Mail\Models\SentMail;
use Exception;

class MailFailedListener
{

    public function handle(MessageFailed $event)
    {
        if (isset($event->data['__bristol_su_mail_uuid'])) {
            SentMail::where('uuid', $event->data['__bristol_su_mail_uuid'])->update([
                'is_sent' => false,
                'is_error' => true,
                'error_message' => $this->getMessageFromException($event->exception)
            ]);
        }
    }

    private function getMessageFromException(Exception $exception)
    {
        if ($exception instanceof SesException) {
            return $exception->getAwsErrorMessage();
        }
        return $exception->getMessage();
    }

}
