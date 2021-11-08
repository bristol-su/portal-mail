<?php

namespace BristolSU\Mail\Http\Controllers\Web;

use Aws\Ses\SesClient;
use BristolSU\Mail\Models\Domain;
use BristolSU\Mail\Models\EmailAddress;

class EmailAddressController
{

    public function index()
    {
        return view('portal-mail::address', [
            'emails' => EmailAddress::all()
        ]);
    }

}
