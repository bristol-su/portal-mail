<?php

namespace BristolSU\Mail\Http\Controllers\Api;

use BristolSU\Mail\Models\Domain;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller;

class DomainController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('manage-mail');

        return Domain::all();
    }

}
