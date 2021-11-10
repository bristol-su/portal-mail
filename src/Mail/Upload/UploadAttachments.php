<?php

namespace BristolSU\Mail\Mail\Upload;

use BristolSU\Mail\Mail\EmailPayload;
use BristolSU\Mail\Models\Attachment;
use Illuminate\Http\File;
use Illuminate\Http\FileHelpers;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UploadAttachments
{
    use FileHelpers;

    /**
     * @var array|UploadedFile[]
     */
    private array $uploadedFiles = [];

    private array $files;

    public static array $uploaders = [];

    public function __construct(array $files)
    {
        $this->files = $files;
    }

    public static function useUploader(string $uploader)
    {
        if(class_exists($uploader) && is_subclass_of($uploader, Uploader::class)) {
            static::$uploaders[] = $uploader;
        }
    }

    /**
     * Gets the tester chain.
     *
     * This returns the first registered tester. This tester will have a successor of the first tester, which in turn
     * will have a successor of the second tester etc.
     *
     * @throws \Exception If no testers are registered
     * @return Uploader First registered tester, with the successor chain set
     */
    private static function getChain(): Uploader
    {
        if (count(static::$uploaders) === 0) {
            throw new Exception('No uploaders registered');
        }

        $uploaders = array_map(fn(string $uploader) => app($uploader), static::$uploaders);

        for ($i = 0; $i < (count($uploaders) - 1); $i++) {
            $uploaders[$i]->setNext($uploaders[$i + 1]);
        }

        return $uploaders[0];
    }

    public function upload()
    {
        foreach($this->files as $file) {

            $uploadedFile = static::getChain()->handle($file);

            $path = $uploadedFile->store('portal-mail/attachments');

            $this->uploadedFiles[] = Attachment::create([
                'filename' => $uploadedFile->getClientOriginalName(),
                'mime' => $uploadedFile->getClientMimeType(),
                'path' => $path,
                'size' => $uploadedFile->getSize()
            ]);
        }
    }

    /**
     * Add the following from existing attachments
     *
     * @param array|Attachment[] $existing
     */
    public function appendExisting(array $existing)
    {
        foreach($existing as $attachment) {
            $this->uploadedFiles[] = Attachment::create([
                'filename' => $attachment->filename,
                'mime' => $attachment->mime,
                'path' => $attachment->path,
                'size' => $attachment->size
            ]);
        }
    }

    public function getPayload(EmailPayload $payload): EmailPayload
    {
        return $payload->setAttachments($this->uploadedFiles);
    }

    protected function areFilesValid(): bool
    {
        foreach($this->files as $file) {
            if(static::getChain()->isValid($file) === false) {
                return false;
            }
        }
        return true;
    }

    public static function validateFiles(array $files)
    {
        $instance = new static($files);
        return $instance->areFilesValid();
    }

}
