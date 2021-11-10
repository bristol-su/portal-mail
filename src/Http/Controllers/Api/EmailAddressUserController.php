<?php

namespace BristolSU\Mail\Http\Controllers\Api;

use BristolSU\ControlDB\Contracts\Repositories\User as UserRepository;
use BristolSU\Mail\Models\EmailAddress;
use BristolSU\Mail\Models\EmailAddressUser;
use BristolSU\Support\Authentication\Contracts\Authentication;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class EmailAddressUserController extends Controller
{
    use AuthorizesRequests;

    public function index(Authentication $authentication)
    {
        $this->authorize('view-management');

        $user = $authentication->getUser();

        $availableEmails = EmailAddress::forUser($user)->get()->filter(fn(EmailAddress $emailAddress) => $emailAddress->status !== 'Waiting for Verification');

        abort_if($availableEmails->count() === 0, 403, 'Please get permissions to send from external email addresses and verify the emails before accessing this page.');

        return $availableEmails;
    }

    public function update(Request $request, int $userId)
    {
        $this->authorize('manage-mail');

        $user = app(UserRepository::class)->getById($userId);
        $request->validate([
            'email_ids' => 'array',
            'email_ids.*' => 'exists:portal_mail_email_addresses,id'
        ]);

        EmailAddressUser::where('user_id', $user->id())->delete();
        foreach($request->input('email_ids') as $emailId) {
            EmailAddressUser::create([
                'user_id' => $user->id(),
                'email_address_id' => $emailId
            ]);
        }

        $userArray = $user->toArray();
        $userArray['email_addresses'] = EmailAddress::forUser($user)->get()->toArray();
        return $userArray;
    }
}
