<?php

namespace BristolSU\Mail\Mail;

use Illuminate\Http\UploadedFile;

class UploadAttachments
{

    public static function upload(EmailPayload $emailPayload): array
    {
        return match ($emailPayload->getType()) {
            'url' => static::uploadUrls($emailPayload->getAttachments()),
            'base64' => static::uploadBase64($emailPayload->getAttachments()),
            'file' => static::uploadFile($emailPayload->getAttachments()),
        };
    }

    public static function uploadUrls(array $attachments): array
    {
        $uploadedAttachments = [];
        foreach ($attachments as $attachment) {
            $path = tempnam(sys_get_temp_dir(), 'EmailSender');
            file_put_contents($path, file_get_contents($attachment));
            $uploadedAttachments[] = new UploadedFile($path, basename($attachment), mime_content_type($path));
        }
        return $uploadedAttachments;
    }

    public static function uploadBase64(array $attachments): array
    {
        $uploadedAttachments = [];
        foreach ($attachments as $attachment) {
            $path = tempnam(sys_get_temp_dir(), 'EmailSender');
            $file = fopen($path, "wb");
            fwrite($file, base64_decode($attachment));
            fclose($file);
            $uploadedAttachments[] = new UploadedFile($path, basename($path), mime_content_type($path));
        }
        return $uploadedAttachments;
    }

    public static function uploadFile(array $attachments): array
    {
        return $attachments;
    }

}
