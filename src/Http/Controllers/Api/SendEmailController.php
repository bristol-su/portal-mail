<?php

namespace BristolSU\Mail\Http\Controllers\Api;

use BristolSU\Mail\Http\Request\SendEmailRequest;
use BristolSU\Mail\Mail\SendEmailJob;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller;

class SendEmailController extends Controller
{
    use AuthorizesRequests;

    public function send(SendEmailRequest $sendEmailRequest)
    {
        $this->authorize('view-management');

        SendEmailJob::dispatch(
            $sendEmailRequest->toEmailPayload()
        );
    }


}
