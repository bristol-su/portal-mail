<?php

namespace BristolSU\Mail\Http\Controllers\Web;

use Aws\Sdk;
use Aws\Ses\SesClient;
use BristolSU\Mail\Models\EmailAddress;

class EmailAddressController
{

    public function index(Sdk $sdk)
    {
        /** @var SesClient $ses */
        $ses = $sdk->createClient('ses');

//        dd($ses->listIdentities());
        return view('portal-mail::address', [
            'emails' => EmailAddress::all()
        ]);
    }

    public function store()
    {

    }

}
