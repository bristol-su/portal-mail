<?php

namespace BristolSU\Mail\Mail\Upload;

use Illuminate\Http\UploadedFile;

abstract class Uploader
{

    /**
     * Holds the next tester in the chain.
     *
     * @var Uploader|null Null if no more testers found
     */
    private $successor = null;

    /**
     * Set the next tester in the chain.
     *
     * @param Uploader|null $tester Next tester
     */
    public function setNext(?Uploader $tester = null)
    {
        $this->successor = $tester;
    }

    /**
     * Check if the tester has a result for the permission, or call the tester successor if not.
     *
     * @param mixed $file
     * @return UploadedFile Own result, or the result of the successor if own result is null
     */
    public function handle(mixed $file): UploadedFile
    {
        if (!$this->canHandle($file)) {
            if($this->successor !== null) {
                return $this->successor->handle($file); // Make me handle successor is null and finish uploiad attachments
            }
            throw new \Exception('Could not upload the file');
        }
        return $this->upload($file);
    }

    public function isValid(mixed $file): bool
    {
        if ($this->canHandle($file)) {
            return true;
        }
        return $this->successor !== null && $this->successor->isValid($file);
    }

    /**
     * Can the uploader upload the given file?
     *
     * @param mixed $file
     * @return bool
     */
    abstract protected function canHandle(mixed $file): bool;

    /**
     * Do the given models have the ability?
     *
     * @param mixed $file The file to upload
     * @return UploadedFile The uploaded file
     */
    abstract protected function upload($file): UploadedFile;

}
