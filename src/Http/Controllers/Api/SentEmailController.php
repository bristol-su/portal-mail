<?php

namespace BristolSU\Mail\Http\Controllers\Api;

use BristolSU\Mail\Models\SentMail;
use BristolSU\Mail\Models\EmailAddress;
use BristolSU\Support\Authentication\Contracts\Authentication;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SentEmailController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $this->authorize('view-management');

        $request->validate([
            'status' => 'sometimes|in:failed,sent,pending'
        ]);

        return SentMail::whereNull('resend_id')
            ->accessibleByCurrentUser()
            ->when($request->input('status', 'sent') === 'sent', fn(Builder $query) => $query->sent()->orderBy('sent_at', 'DESC'))
            ->when($request->input('status', 'sent') === 'pending', fn(Builder $query) => $query->pending()->orderBy('created_at', 'DESC'))
            ->when($request->input('status', 'sent') === 'failed', fn(Builder $query) => $query->failed()->orderBy('failed_at', 'DESC'))
            ->orderBy('sent_at', 'DESC')
            ->paginate(8);
    }

    public function show(SentMail $sentMail)
    {
        $this->authorize('view-management');

        abort_unless($sentMail->from->currentUserCanAccess(), 403, 'You do not have permission to see this mail');

        $retries = $sentMail->retries->map(function(SentMail $sentMail) {
            $array = $sentMail->toArray();
            $array['preview'] = $sentMail->asMailable()->render();
            return $array;
        });
        $array = $sentMail->toArray();
        $array['retries'] = $retries;
        $array['preview'] = $sentMail->asMailable()->render();

        return response()->json($array, 200);
    }

}
