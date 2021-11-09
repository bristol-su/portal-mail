<?php

namespace BristolSU\Mail\Http\Controllers\Api;

use BristolSU\Mail\Models\EmailAddress;
use BristolSU\Mail\Ses\SesClient;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller;

class EmailAddressVerificationController extends Controller
{
    use AuthorizesRequests;

    public function sendVerificationLink(EmailAddress $emailAddress, SesClient $ses)
    {
        $this->authorize('manage-mail');

        $ses->resendVerificationEmail($emailAddress->email);

        return response()->json();
    }

}
