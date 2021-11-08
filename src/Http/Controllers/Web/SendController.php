<?php

namespace BristolSU\Mail\Http\Controllers\Web;

use BristolSU\Mail\Models\EmailAddress;
use BristolSU\Support\Authentication\Contracts\Authentication;

class SendController
{

    public function index(Authentication $authentication)
    {
        $user = $authentication->getUser();
        $availableEmails = EmailAddress::forUser($user)->get()->filter(fn(EmailAddress $emailAddress) => $emailAddress->status !== 'Waiting for Verification')->values();

        abort_if(count($availableEmails) === 0, 403, 'Please get permissions to send from external email addresses before accessing this page.');

        return view('portal-mail::send', [
            'from' => $availableEmails
        ]);
    }

}
