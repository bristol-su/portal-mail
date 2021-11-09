<?php

use Illuminate\Support\Facades\Route;

Route::apiResource('address', \BristolSU\Mail\Http\Controllers\Api\EmailAddressController::class)->parameters(['address' => 'emailAddress']);
Route::apiResource('user', \BristolSU\Mail\Http\Controllers\Api\EmailAddressUserController::class)->only('update');
Route::post('address/{emailAddress}/verification', [\BristolSU\Mail\Http\Controllers\Api\EmailAddressVerificationController::class, 'sendVerificationLink']);
Route::post('send', [\BristolSU\Mail\Http\Controllers\Api\SendEmailController::class, 'send'])->name('portal_mail.send');
Route::get('domains', [\BristolSU\Mail\Http\Controllers\Api\DomainController::class, 'index']);
Route::apiResource('sent', \BristolSU\Mail\Http\Controllers\Api\SentEmailController::class)->only('index');
Route::post('sent/{sentMail}/resend/', [\BristolSU\Mail\Http\Controllers\Api\ResendSentEmailController::class, 'resend']);
