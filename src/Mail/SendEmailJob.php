<?php

namespace BristolSU\Mail\Mail;

use BristolSU\Mail\Capture\SentMailModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

class SendEmailJob
{
    use Dispatchable, InteractsWithQueue;

    public EmailPayload $payload;

    private ?SentMailModel $sentMailModel;

    /**
     * Create a new job instance.
     *
     * @param EmailPayload $payload
     */
    public function __construct(EmailPayload $payload, ?SentMailModel $sentMailModel = null)
    {
        $this->payload = $payload;
        $this->sentMailModel = $sentMailModel;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Mailer $mailer)
    {
        $mailable = GenericMailable::forPayload($this->payload);

        if($this->sentMailModel !== null) {
            $mailable->with('__bristol_su_mail_id', $this->sentMailModel->id);
        }

        $mailer->send($mailable);
    }

}
