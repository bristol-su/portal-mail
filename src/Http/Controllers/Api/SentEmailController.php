<?php

namespace BristolSU\Mail\Http\Controllers\Api;

use BristolSU\Mail\Capture\SentMailModel;
use BristolSU\Mail\Mail\GenericMailable;
use Illuminate\Routing\Controller;

class SentEmailController extends Controller
{

    public function index()
    {
        return SentMailModel::all()->map(function(SentMailModel $sentMailModel) {
            $array = $sentMailModel->toArray();
            $array['preview'] = GenericMailable::forPayload($sentMailModel->asPayload())->render();
            return $array;
        });
    }

}
