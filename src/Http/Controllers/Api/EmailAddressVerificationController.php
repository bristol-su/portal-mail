<?php

namespace BristolSU\Mail\Http\Controllers\Api;

use BristolSU\Mail\Models\EmailAddress;
use BristolSU\Mail\Ses\SesClient;
use Illuminate\Routing\Controller;

class EmailAddressVerificationController extends Controller
{

    public function sendVerificationLink(EmailAddress $emailAddress, SesClient $ses)
    {
        $ses->resendVerificationEmail($emailAddress->email);

        return response()->json();
    }

}
