<?php

namespace BristolSU\Mail\Mail;

use BristolSU\Mail\Models\EmailAddress;

class EmailPayload
{

    private string $content;

    private array $to;

    private EmailAddress $from;

    private ?string $subject = null;

    private array $cc = [];

    private array $bcc = [];

    private array $attachments = [];

    private string $type = 'file';

    public function __construct(
        string $content, array $to, EmailAddress $from
    )
    {
        $this->content = $content;
        $this->to = $to;
        $this->from = $from;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return EmailPayload
     */
    public function setContent(string $content): EmailPayload
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return array
     */
    public function getTo(): array
    {
        return $this->to;
    }

    /**
     * @param array $to
     * @return EmailPayload
     */
    public function setTo(array $to): EmailPayload
    {
        $this->to = $to;
        return $this;
    }

    /**
     * @return EmailAddress
     */
    public function getFrom(): EmailAddress
    {
        return $this->from;
    }

    /**
     * @param EmailAddress $from
     * @return EmailPayload
     */
    public function setFrom(EmailAddress $from): EmailPayload
    {
        $this->from = $from;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSubject(): ?string
    {
        return $this->subject;
    }

    /**
     * @param string|null $subject
     * @return EmailPayload
     */
    public function setSubject(?string $subject): EmailPayload
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * @return array
     */
    public function getCc(): array
    {
        return $this->cc;
    }

    /**
     * @param array $cc
     * @return EmailPayload
     */
    public function setCc(array $cc): EmailPayload
    {
        $this->cc = $cc;
        return $this;
    }

    /**
     * @return array
     */
    public function getBcc(): array
    {
        return $this->bcc;
    }

    /**
     * @param array $bcc
     * @return EmailPayload
     */
    public function setBcc(array $bcc): EmailPayload
    {
        $this->bcc = $bcc;
        return $this;
    }

    /**
     * @return array
     */
    public function getAttachments(): array
    {
        return $this->attachments;
    }

    /**
     * @param array $attachments
     * @return EmailPayload
     */
    public function setAttachments(array $attachments): EmailPayload
    {
        $this->attachments = $attachments;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return EmailPayload
     */
    public function setType(string $type): EmailPayload
    {
        $this->type = $type;
        return $this;
    }

    public function hasSubject(): bool
    {
        return $this->subject !== null;
    }

    public function hasCc(): bool
    {
        return !empty($this->cc);
    }

    public function hasBcc(): bool
    {
        return !empty($this->bcc);
    }

    public function hasAttachments(): bool
    {
        return !empty($this->attachments);
    }

}
