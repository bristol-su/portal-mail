<?php

namespace BristolSU\Mail\Http\Controllers\Web;

use Aws\Ses\SesClient;
use BristolSU\Mail\Models\Domain;
use BristolSU\Mail\Models\EmailAddress;

class EmailAddressController
{

    public function index()
    {
        /** @var SesClient $ses */
        $ses = app('portal-mail-ses');
        dd($ses->getIdentityDkimAttributes(['Identities' => ['hotmail.co.uk']]));
        return view('portal-mail::address', [
            'emails' => EmailAddress::all(),
            'domains' => Domain::all()
        ]);
    }

}
