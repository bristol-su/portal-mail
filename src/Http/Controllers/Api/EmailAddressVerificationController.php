<?php

namespace BristolSU\Mail\Http\Controllers\Api;

use Aws\Sdk;
use BristolSU\Mail\Models\EmailAddress;
use Illuminate\Routing\Controller;

class EmailAddressVerificationController extends Controller
{

    public function sendVerificationLink(EmailAddress $emailAddress, Sdk $sdk)
    {
        $ses = $sdk->createClient('ses');
        $ses->deleteIdentity(['Identity' => $emailAddress->email]);
        $ses->verifyEmailIdentity(['EmailAddress' => $emailAddress->email]);

        return response()->json();
    }

}
