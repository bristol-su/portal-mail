<?php

namespace BristolSU\Mail\Mail;

use BristolSU\Mail\Models\SentMail;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue;

    public EmailPayload $payload;

    /**
     * Create a new job instance.
     *
     * @param EmailPayload $payload
     */
    public function __construct(EmailPayload $payload)
    {
        $this->payload = $payload;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Mailer $mailer)
    {
        $mailer->send(
            GenericMailable::forPayload($this->payload)
        );
    }

}
