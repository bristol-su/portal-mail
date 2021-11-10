<?php

\Illuminate\Support\Facades\Route::get('attachment/{attachment}/download', [\BristolSU\Mail\Http\Controllers\Web\AttachmentController::class, 'download']);
\Illuminate\Support\Facades\Route::get('/', [\BristolSU\Mail\Http\Controllers\Web\MailController::class, 'index']);
\Illuminate\Support\Facades\Route::get('/settings', [\BristolSU\Mail\Http\Controllers\Web\SettingsController::class, 'index']);
