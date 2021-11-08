<?php

\Illuminate\Support\Facades\Route::get('address', [\BristolSU\Mail\Http\Controllers\Web\EmailAddressController::class, 'index'])->name('portal_mail.address');
\Illuminate\Support\Facades\Route::get('user', [\BristolSU\Mail\Http\Controllers\Web\UserController::class, 'index'])->name('portal_mail.user');
\Illuminate\Support\Facades\Route::get('send', [\BristolSU\Mail\Http\Controllers\Web\SendController::class, 'index'])->name('portal_mail.send');
