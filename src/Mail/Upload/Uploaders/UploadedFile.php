<?php

namespace BristolSU\Mail\Mail\Upload\Uploaders;

use BristolSU\Mail\Mail\Upload\Uploader;

class UploadedFile extends Uploader
{

    protected function canHandle(mixed $file): bool
    {
        return $file instanceof \Illuminate\Http\UploadedFile;
    }

    protected function upload($file): \Illuminate\Http\UploadedFile
    {
        return $file;
    }
}
