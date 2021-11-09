<?php

namespace BristolSU\Mail\Http\Controllers\Api;

use BristolSU\Mail\Http\Request\SendEmailRequest;
use BristolSU\Mail\Mail\SendEmailJob;
use BristolSU\Mail\Mail\UploadAttachments;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller;

class EmailController extends Controller
{
    use AuthorizesRequests;

    public function send(SendEmailRequest $sendEmailRequest)
    {
        $this->authorize('view-management');

        $payload = $sendEmailRequest->toEmailPayload();

        $attachments = UploadAttachments::upload($payload);

        $payload->setAttachments($attachments);

        SendEmailJob::dispatch($payload);
    }
}
