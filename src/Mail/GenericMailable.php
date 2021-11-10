<?php

namespace BristolSU\Mail\Mail;

use BristolSU\Mail\Capture\Contracts\IsRecorded;
use BristolSU\Mail\Mail\EmailPayload;
use BristolSU\Mail\Models\EmailAddress;
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
                $this->attachFromStorage($attachment->path, $attachment->filename, [
                    'mime' => $attachment->mime
                ]);
            }
        }

        if($this->emailPayload->hasPriority()) {
            $this->priority($this->emailPayload->getPriority());
        }

        if($this->emailPayload->hasReplyTo()) {
            $email = EmailAddress::where('email', $this->emailPayload->getReplyTo())->first();
            $this->replyTo($this->emailPayload->getReplyTo(), $email?->name);
        }

        $this->from($this->emailPayload->getFrom()->email, $this->emailPayload->getFrom()->name);

        $this->to($this->emailPayload->getTo());

        if($this->emailPayload->isBuilderContent()) {
            return $this->markdown('notifications::email')->with([
                'level' => data_get($this->emailPayload->getContent(), 'action.type', null),
                'greeting' => data_get($this->emailPayload->getContent(), 'greeting', null),
                'salutation' => data_get($this->emailPayload->getContent(), 'salutation', null),
                'introLines' => data_get($this->emailPayload->getContent(), 'before_lines', []),
                'outroLines' => data_get($this->emailPayload->getContent(), 'after_lines', []),
                'actionText' => data_get($this->emailPayload->getContent(), 'action.text', null),
                'actionUrl' => data_get($this->emailPayload->getContent(), 'action.url', null),
                'displayableActionUrl' => str_replace(['mailto:', 'tel:'], '', data_get($this->emailPayload->getContent(), 'action.url', ''))
            ]);
        } else {
            return $this->view('portal-mail::emails.email')
                ->text('portal-mail::emails.email_plain');
        }

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
