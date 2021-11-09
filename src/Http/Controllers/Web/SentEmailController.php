<?php

namespace BristolSU\Mail\Http\Controllers\Web;

use BristolSU\Mail\Capture\SentMailModel;

class SentEmailController
{

    public function index()
    {
        return view('portal-mail::sent');
    }

}
