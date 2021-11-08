<?php

namespace BristolSU\Mail\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailJob
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
    public function handle()
    {
        $mailable = GenericMailable::forPayload($this->payload);

        Mail::send($mailable);
    }

}
