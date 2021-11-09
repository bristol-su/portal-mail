<?php

namespace BristolSU\Mail\Http\Controllers\Api;

use BristolSU\Mail\Capture\SentMailModel;
use BristolSU\Mail\Mail\GenericMailable;
use BristolSU\Mail\Mail\SendEmailJob;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller;

class ResendSentEmailController extends Controller
{
    use AuthorizesRequests;

    public function resend(SentMailModel $sentMail)
    {
        $this->authorize('view-management');

        SendEmailJob::dispatch($sentMail->asPayload(), $sentMail);
    }

}
