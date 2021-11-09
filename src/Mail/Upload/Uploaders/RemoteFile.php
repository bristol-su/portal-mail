<?php

namespace BristolSU\Mail\Mail\Upload\Uploaders;

use BristolSU\Mail\Mail\Upload\Uploader;
use Illuminate\Http\UploadedFile;

class RemoteFile extends Uploader
{

    protected function canHandle(mixed $file): bool
    {
        return filter_var($file, FILTER_VALIDATE_URL);
    }

    protected function upload(mixed $file): UploadedFile
    {
        $path = tempnam(sys_get_temp_dir(), 'portal-mail');
        file_put_contents($path, file_get_contents($file));
        return new UploadedFile($path, basename($file), mime_content_type($path));
    }
}
