<?php

use Illuminate\Support\Facades\Route;

Route::apiResource('address', \BristolSU\Mail\Http\Controllers\Api\EmailAddressController::class)->parameters(['address' => 'emailAddress']);
Route::apiResource('user', \BristolSU\Mail\Http\Controllers\Api\EmailAddressUserController::class)->only('update');
Route::post('address/{emailAddress}/verification', [\BristolSU\Mail\Http\Controllers\Api\EmailAddressVerificationController::class, 'sendVerificationLink']);
Route::post('send', [\BristolSU\Mail\Http\Controllers\Api\EmailController::class, 'send']);
