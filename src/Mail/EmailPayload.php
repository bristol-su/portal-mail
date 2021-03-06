<?php

namespace BristolSU\Mail\Mail;

use BristolSU\Mail\Models\Attachment;
use BristolSU\Mail\Models\EmailAddress;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

class EmailPayload implements Jsonable, Arrayable
{

    private string|array $content;

    private array $to;

    private EmailAddress $from;

    private ?string $subject = null;

    private array $cc = [];

    private array $bcc = [];

    private array $attachments = [];

    private ?string $notes = null;

    private string $sentVia = 'system';

    private ?int $priority = null;

    private ?string $replyTo = null;

    private ?int $resendId = null;

    public function __construct(
        string|array $content, array $to, EmailAddress $from
    )
    {
        $this->content = $content;
        $this->to = $to;
        $this->from = $from;
    }

    /**
     * @return int|null
     */
    public function getResendId(): ?int
    {
        return $this->resendId;
    }

    /**
     * @param int|null $resendId
     * @return EmailPayload
     */
    public function setResendId(?int $resendId): EmailPayload
    {
        $this->resendId = $resendId;
        return $this;
    }

    public function isResend(): bool
    {
        return $this->resendId !== null;
    }

    /**
     * @return int|null
     */
    public function getPriority(): ?int
    {
        return $this->priority;
    }

    /**
     * @param int|null $priority
     * @return EmailPayload
     */
    public function setPriority(?int $priority): EmailPayload
    {
        $this->priority = $priority;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getReplyTo(): ?string
    {
        return $this->replyTo;
    }

    /**
     * @param string|null $replyTo
     * @return EmailPayload
     */
    public function setReplyTo(?string $replyTo): EmailPayload
    {
        $this->replyTo = $replyTo;
        return $this;
    }

    public function hasReplyTo(): bool
    {
        return $this->replyTo !== null;
    }

    public function hasPriority(): bool
    {
        return $this->priority !== null;
    }

    /**
     * @return string|null
     */
    public function getNotes(): ?string
    {
        return $this->notes;
    }

    /**
     * @param string|null $notes
     * @return EmailPayload
     */
    public function setNotes(?string $notes): EmailPayload
    {
        $this->notes = $notes;
        return $this;
    }

    /**
     * @return string
     */
    public function getSentVia(): string
    {
        return $this->sentVia;
    }

    /**
     * @param string $sentVia
     * @return EmailPayload
     */
    public function setSentVia(string $sentVia): EmailPayload
    {
        $this->sentVia = $sentVia;
        return $this;
    }

    /**
     * @return array|Attachment[]
     */
    public function getAttachments(): array
    {
        return $this->attachments;
    }

    /**
     * @param Attachment[] $attachments
     * @return EmailPayload
     */
    public function setAttachments(array $attachments): EmailPayload
    {
        $this->attachments = $attachments;
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

    public function __toString(): string
    {
        return $this->toJson();
    }

    public function toJson($options = 0): string
    {
        return json_encode($this->toArray(), $options);
    }

    public function toArray(): array
    {
        return [
            'to' => $this->getTo(),
            'cc' => $this->getCc(),
            'bcc' => $this->getBcc(),
            'subject' => $this->getSubject(),
            'content' => $this->getContent(),
            'from' => $this->getFrom()->id,
            'attachments' => collect($this->attachments)->toArray(),
        ];
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
     * @return string|array
     */
    public function getContent(): string|array
    {
        return $this->content;
    }

    /**
     * @param string|array $content
     * @return EmailPayload
     */
    public function setContent(string|array $content): EmailPayload
    {
        $this->content = $content;
        return $this;
    }

    public function isBuilderContent(): bool
    {
        return is_array($this->content);
    }

    public function isHtmlContent(): bool
    {
        return is_string($this->content);
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
}
