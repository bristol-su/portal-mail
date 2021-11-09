<?php

namespace BristolSU\Mail\Mail;

use BristolSU\Mail\Models\SentMail;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

class SendEmailJob
{
    use Dispatchable, InteractsWithQueue;

    public EmailPayload $payload;

    private ?SentMail $sentMail;

    /**
     * Create a new job instance.
     *
     * @param EmailPayload $payload
     */
    public function __construct(EmailPayload $payload, ?SentMail $sentMail = null)
    {
        $this->payload = $payload;
        $this->sentMail = $sentMail;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Mailer $mailer)
    {
        $mailable = GenericMailable::forPayload($this->payload);

        if($this->sentMail !== null) {
            $mailable->with('__bristol_su_mail_id', $this->sentMail->id);
        }

        $mailer->send($mailable);
    }

}
