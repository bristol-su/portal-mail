<?php

namespace BristolSU\Mail\Capture;

use BristolSU\Mail\Capture\Events\MessageFailed;
use Illuminate\Contracts\Mail\Mailable as MailableContract;
use Illuminate\Contracts\Mail\Mailer as MailerContract;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Traits\ForwardsCalls;

class Mailer implements \Illuminate\Contracts\Mail\Mailer
{
    use ForwardsCalls;

    private MailerContract $mailer;

    private ?string $name;

    public function __construct(MailerContract $mailer, ?string $name = null)
    {
        $this->mailer = $mailer;
        $this->name = $name;
    }

    public function send($view, array $data = [], $callback = null)
    {
        try {
            if ($view instanceof MailableContract && ! ($view instanceof ShouldQueue)) {
                if($this->name !== null) {
                    $view->mailer($this->name);
                }
                $view->send($this);
            } else {
                $this->mailer->send($view, $data, $callback);
            }
        } catch (\Exception $e) {
            MessageFailed::dispatch($e, $data);
            throw $e;
        }
    }

    public function to($users)
    {
        return $this->mailer->to($users);
    }

    public function bcc($users)
    {
        return $this->mailer->bcc($users);
    }

    public function raw($text, $callback)
    {
        $this->mailer->raw($text, $callback);
    }

    public function failures()
    {
        return $this->mailer->failures();
    }

    public function __call(string $name, array $arguments)
    {
        return $this->forwardCallTo($this->mailer, $name, $arguments);
    }

}
