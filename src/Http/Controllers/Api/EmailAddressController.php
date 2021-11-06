<?php

namespace BristolSU\Mail\Http\Controllers\Api;

use BristolSU\Mail\Models\EmailAddress;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class EmailAddressController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'email:rfc,dns|unique:portal_mail_email_addresses,email'
        ]);

        return EmailAddress::create([
            'email' => $request->input('email')
        ]);
    }

    public function destroy(EmailAddress $emailAddress)
    {
        $emailAddress->delete();

        return response()->json($emailAddress);
    }
}
