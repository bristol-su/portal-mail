<?php

namespace BristolSU\Mail\Http\Controllers\Web;

use BristolSU\Mail\Models\EmailAddress;
use BristolSU\Support\Authentication\Contracts\Authentication;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SendController
{
    use AuthorizesRequests;

    public function index(Authentication $authentication)
    {
        $this->authorize('view-management');

        $user = $authentication->getUser();
        $availableEmails = EmailAddress::forUser($user)->get()->filter(fn(EmailAddress $emailAddress) => $emailAddress->status !== 'Waiting for Verification')->values();

        abort_if(count($availableEmails) === 0, 403, 'Please get permissions to send from external email addresses and verify the emails before accessing this page.');

        return view('portal-mail::send', [
            'from' => $availableEmails
        ]);
    }

}
