<?php

namespace BristolSU\Mail\Http\Controllers\Web;

use BristolSU\ControlDB\Contracts\Repositories\User;
use BristolSU\Mail\Models\EmailAddress;
use BristolSU\Mail\Models\EmailAddressUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserController
{
    use AuthorizesRequests;

    public function index(User $userRepository)
    {
        $this->authorize('manage-mail');

        $users = collect();
        $userIds = EmailAddressUser::select('user_id')->distinct()->get('user_id')->pluck('user_id');
        foreach($userIds as $userId) {
            $user = $userRepository->getById($userId)->toArray();
            $user['email_addresses'] = EmailAddress::whereHas('emailAddressUser', fn(Builder $query) => $query->where('user_id', $userId))->get()->toArray();
            $users->push($user);
        }

        return view('portal-mail::users', [
            'users' => $users
        ]);
    }

}
