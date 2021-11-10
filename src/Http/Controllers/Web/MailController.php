<?php

namespace BristolSU\Mail\Http\Controllers\Web;

use BristolSU\Mail\Models\EmailAddress;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class MailController
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('view-management');

        return view('portal-mail::mail');
    }

}
