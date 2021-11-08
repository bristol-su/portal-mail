<?php

namespace BristolSU\Mail\Http\Controllers\Api;

use BristolSU\Mail\Http\Request\SendEmailRequest;
use BristolSU\Mail\Mail\SendEmailJob;
use BristolSU\Mail\Mail\UploadAttachments;
use Illuminate\Routing\Controller;

class EmailController extends Controller
{

    public function send(SendEmailRequest $sendEmailRequest)
    {
        $payload = $sendEmailRequest->toEmailPayload();

        $attachments = UploadAttachments::upload($payload);

        $payload->setAttachments($attachments);

        SendEmailJob::dispatch($payload);
    }
}
