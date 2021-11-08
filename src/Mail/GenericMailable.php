<?php

namespace BristolSU\Mail\Mail;

use BristolSU\Mail\Capture\Contracts\IsRecorded;
use BristolSU\Mail\Mail\EmailPayload;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GenericMailable extends Mailable implements IsRecorded
{
    use Queueable, SerializesModels;

    public EmailPayload $emailPayload;

    /**
     * Create a new message instance.
     *
     * @param EmailPayload $emailPayload
     */
    public function __construct(EmailPayload $emailPayload)
    {
        $this->emailPayload = $emailPayload;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->emailPayload->hasSubject()) {
            $this->subject($this->emailPayload->getSubject());
        }
        if($this->emailPayload->hasCc()) {
            $this->cc($this->emailPayload->getCc());
        }
        if($this->emailPayload->hasBcc()) {
            $this->bcc($this->emailPayload->getBcc());
        }

        if($this->emailPayload->hasAttachments()) {
            foreach($this->emailPayload->getAttachments() as $attachment) {
                $this->attach($attachment->getRealPath(),
                    [
                        'as' => $attachment->getClientOriginalName(),
                        'mime' => $attachment->getClientMimeType(),
                    ]);
            }
            $this->subject($this->emailPayload->getSubject());
        }

        $this->from($this->emailPayload->getFrom()->email);

        $this->to($this->emailPayload->getTo());

        return $this->view('portal-mail::emails.email');

    }

    public static function forPayload(EmailPayload $emailPayload): static
    {
        return new static($emailPayload);
    }

    public function payload(): EmailPayload
    {
        return $this->emailPayload;
    }
}
