<?php

namespace BristolSU\Mail\Http\Controllers\Web;

use BristolSU\Mail\Models\Attachment;
use BristolSU\Mail\Models\SentMail;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AttachmentController
{
    use AuthorizesRequests;

    public function download(Attachment $attachment)
    {
        $this->authorize('view-management');

        if(Storage::exists($attachment->path)) {
            return Storage::download($attachment->path, $attachment->filename, [
                'X-Vapor-Base64-Encode' => 'True'
            ]);
        }

        throw new HttpException(404, 'File not found');
    }

}
