<?php

use Illuminate\Support\Facades\Route;

Route::apiResource('address', \BristolSU\Mail\Http\Controllers\Api\EmailAddressController::class)->parameters(['address' => 'emailAddress']);
Route::post('address/{emailAddress}/verification', [\BristolSU\Mail\Http\Controllers\Api\EmailAddressVerificationController::class, 'sendVerificationLink']);
