<?php

namespace BristolSU\Mail\Http\Controllers\Api;

use BristolSU\Mail\Models\SentMail;
use BristolSU\Mail\Models\EmailAddress;
use BristolSU\Support\Authentication\Contracts\Authentication;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller;

class SentEmailController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('view-management');

        $accessibleEmailIds = EmailAddress::forUser(app(Authentication::class)->getUser())->get()->pluck('id');

        return SentMail::whereNull('resend_id')
            ->whereIn('from_id', $accessibleEmailIds)
            ->get()
            ->map(function(SentMail $sentMail) {
                $array = $sentMail->toArray();
                $array['preview'] = $sentMail->asMailable()->render();
                return $array;
            });
    }

    public function show(SentMail $sentMail)
    {
        $this->authorize('view-management');

        abort_unless($sentMail->from->currentUserCanAccess(), 403, 'You do not have permission to see this mail');

        $array = $sentMail->toArray();
        $array['preview'] = $sentMail->asMailable()->render();

        return response()->json($array, 200);
    }

}
