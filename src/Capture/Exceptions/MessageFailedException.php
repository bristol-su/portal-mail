<?php

namespace BristolSU\Mail\Capture\Exceptions;

use Throwable;

class MessageFailedException extends \Exception
{

    public function __construct($message = "The email could not be sent", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    

}
