<?php

namespace BristolSU\Mail\Http\Controllers\Web;

use Aws\Ses\SesClient;
use BristolSU\Mail\Models\Domain;
use BristolSU\Mail\Models\EmailAddress;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EmailAddressController
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('manage-mail');

        return view('portal-mail::address', [
            'emails' => EmailAddress::all()
        ]);
    }

}
