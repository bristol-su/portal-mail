<?php

\Illuminate\Support\Facades\Route::get('address', [\BristolSU\Mail\Http\Controllers\Web\EmailAddressController::class, 'index'])->name('portal_mail.address');
\Illuminate\Support\Facades\Route::get('user', [\BristolSU\Mail\Http\Controllers\Web\UserController::class, 'index'])->name('portal_mail.user');
\Illuminate\Support\Facades\Route::get('send', [\BristolSU\Mail\Http\Controllers\Web\SendController::class, 'index'])->name('portal_mail.send');
\Illuminate\Support\Facades\Route::get('sent', [\BristolSU\Mail\Http\Controllers\Web\SentEmailController::class, 'index'])->name('portal_mail.sent');
\Illuminate\Support\Facades\Route::get('attachment/{attachment}/download', [\BristolSU\Mail\Http\Controllers\Web\AttachmentController::class, 'download']);
