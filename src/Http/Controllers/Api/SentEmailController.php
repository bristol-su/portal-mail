<?php

namespace BristolSU\Mail\Http\Controllers\Api;

use BristolSU\Mail\Capture\SentMailModel;
use BristolSU\Mail\Mail\GenericMailable;
use BristolSU\Mail\Models\EmailAddress;
use BristolSU\Support\Authentication\Contracts\Authentication;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller;

class SentEmailController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('view-management');

        $accessibleEmailIds = EmailAddress::forUser(app(Authentication::class)->getUser())->get()->pluck('id');

        return SentMailModel::whereIn('from_id', $accessibleEmailIds)->all()->map(function(SentMailModel $sentMailModel) {
            $array = $sentMailModel->toArray();
            $array['preview'] = GenericMailable::forPayload($sentMailModel->asPayload())->render();
            return $array;
        });
    }

}
