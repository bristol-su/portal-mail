<?php

namespace BristolSU\Mail\Http\Controllers\Api;

use BristolSU\Mail\Capture\SentMailModel;
use BristolSU\Mail\Mail\GenericMailable;
use BristolSU\Mail\Mail\SendEmailJob;
use Illuminate\Routing\Controller;

class ResendSentEmailController extends Controller
{

    public function resend(SentMailModel $sentMail)
    {
        SendEmailJob::dispatch($sentMail->asPayload(), $sentMail);
    }

}
