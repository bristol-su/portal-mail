<?php

namespace BristolSU\Mail\Capture\Events;

use Illuminate\Foundation\Events\Dispatchable;

class MessageFailed
{
    use Dispatchable;

    public \Exception $exception;

    public array $data;

    public array $failedRecipients;

    public function __construct(\Exception $exception, array $data)
    {
        $this->exception = $exception;
        $this->data = $data;
    }

}
