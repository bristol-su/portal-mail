<?php

namespace BristolSU\Mail\Capture;

use Illuminate\Contracts\Mail\Factory;
use Illuminate\Contracts\Mail\Mailer as MailerContract;
use Illuminate\Support\Traits\ForwardsCalls;

class MailManager implements Factory
{
    use ForwardsCalls;

    private Factory $mailer;

    public function __construct(Factory $mailer)
    {
        $this->mailer = $mailer;
    }

    public function __call(string $name, array $arguments)
    {
        return $this->forwardCallTo($this->mailer, $name, $arguments);
    }

    public function mailer($name = null)
    {
        return new Mailer($this->mailer->mailer($name), $name);
    }
}
