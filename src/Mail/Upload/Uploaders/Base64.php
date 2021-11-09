<?php

namespace BristolSU\Mail\Mail\Upload\Uploaders;

use BristolSU\Mail\Mail\Upload\Uploader;
use Illuminate\Http\UploadedFile;

class Base64 extends Uploader
{

    protected function canHandle(mixed $file): bool
    {
        if(!$file || !is_string($file)) {
            return false;
        }
        return base64_encode(base64_decode($file, true)) === $file;
    }

    protected function upload(mixed $file): UploadedFile
    {
        $path = tempnam(sys_get_temp_dir(), 'portal-mail');
        $tempFile = fopen($path, "wb");
        fwrite($tempFile, base64_decode($file));
        fclose($tempFile);
        return new UploadedFile($path, basename($path), mime_content_type($path));
    }
}
