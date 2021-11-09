<?php

namespace BristolSU\Mail\Http\Controllers\Web;

use BristolSU\Mail\Capture\SentMailModel;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SentEmailController
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('view-management');

        return view('portal-mail::sent');
    }

}
