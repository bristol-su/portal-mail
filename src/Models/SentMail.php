<?php

namespace BristolSU\Mail\Models;

use BristolSU\Mail\Mail\EmailPayload;
use BristolSU\Mail\Mail\GenericMailable;
use BristolSU\Mail\Models\EmailAddress;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class SentMail extends Model
{

    protected $table = 'portal_mail_sent_emails';

    protected $casts = [
        'cc' => 'array',
        'to' => 'array',
        'bcc' => 'array',
        'is_sent' => 'boolean',
        'is_error' => 'boolean',
        'sent_at' => 'datetime',
        'priority' => 'integer'
    ];

    protected $with = [
        'from', 'attachments', 'retries'
    ];

    protected $appends = [
        'status'
    ];

    protected $fillable = [
        'subject',
        'content',
        'from_id',
        'to',
        'cc',
        'bcc',
        'is_sent',
        'uuid',
        'user_id',
        'notes',
        'is_error',
        'error_message',
        'sent_via',
        'sent_at',
        'priority',
        'reply_to',
        'resend_id'
    ];

    public function getStatusAttribute(): string
    {
        // If has a successful resend, it's been sent.
        if($this->resend_id === null && $this->retries()->where(['is_error' => false, 'is_sent' => true])->count() > 0) {
            return 'Sent';
        }
        if($this->is_error) {
            return 'Failed';
        }
        if($this->is_sent) {
            return 'Sent';
        }
        return 'Pending';

    }

    public function getSentAtAttribute($value)
    {
        $retry = $this->retries()->where(['is_error' => false, 'is_sent' => true])->first();
        if($this->resend_id === null && $retry !== null) {
            return $retry->sent_at;
        }
        return $value;
    }

    public function retries()
    {
        return $this->hasMany(SentMail::class, 'resend_id');
    }

    public function parentEmail()
    {
        return $this->belongsTo(SentMail::class, 'resend_id');
    }

    protected static function booted()
    {
        static::deleted(fn (SentMail $model) => Attachment::where('sent_mail_id', $model->id)->get()
            ->map(fn(Attachment $attachment) => $attachment->delete())
        );
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class, 'sent_mail_id');
    }

    public function from()
    {
        return $this->belongsTo(EmailAddress::class, 'from_id');
    }

    public function asPayload(): EmailPayload
    {
        return (new EmailPayload($this->content = '', $this->to ?? [], $this->from))
            ->setSubject($this->subject)
            ->setCc($this->cc ?? [])
            ->setBcc($this->bcc ?? [])
            ->setNotes($this->notes)
            ->setSentVia($this->sent_via)
            ->setPriority($this->priority)
            ->setReplyTo($this->reply_to)
            ->setResendId($this->resend_id)
            ->setAttachments($this->attachments()->get()->all());
    }

    public function asMailable(): GenericMailable
    {
        return GenericMailable::forPayload($this->asPayload());
    }

}
