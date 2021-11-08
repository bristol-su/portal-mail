<?php

namespace BristolSU\Mail\Http\Controllers\Api;

use BristolSU\Mail\Models\Domain;
use Illuminate\Routing\Controller;

class DomainController extends Controller
{

    public function index()
    {
        return Domain::all();
    }

}
