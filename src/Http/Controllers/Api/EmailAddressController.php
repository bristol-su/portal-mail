<?php

namespace BristolSU\Mail\Http\Controllers\Api;

use BristolSU\Mail\Models\EmailAddress;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class EmailAddressController extends Controller
{
    use AuthorizesRequests;

    public function store(Request $request)
    {
        $this->authorize('manage-mail');

        $request->validate([
            'email' => 'required|email:rfc,dns|unique:portal_mail_email_addresses,email',
            'name' => 'required|string|min:1|max:254'
        ]);

        return EmailAddress::create([
            'email' => $request->input('email'),
            'name' => $request->input('name')
        ]);
    }

    public function destroy(EmailAddress $emailAddress)
    {
        $this->authorize('manage-mail');

        $emailAddress->delete();

        return response()->json($emailAddress);
    }
}
