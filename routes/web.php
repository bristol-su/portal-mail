<?php

\Illuminate\Support\Facades\Route::get('address', [\BristolSU\Mail\Http\Controllers\Web\EmailAddressController::class, 'index'])->name('portal_mail.address');
