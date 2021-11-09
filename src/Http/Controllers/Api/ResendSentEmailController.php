<?php

namespace BristolSU\Mail\Http\Controllers\Api;

use BristolSU\Mail\Models\SentMail;
use BristolSU\Mail\Mail\GenericMailable;
use BristolSU\Mail\Mail\SendEmailJob;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller;

class ResendSentEmailController extends Controller
{
    use AuthorizesRequests;

    public function resend(SentMail $sentMail)
    {
        $this->authorize('view-management');

        SendEmailJob::dispatch($sentMail->asPayload(), $sentMail);
    }

}
