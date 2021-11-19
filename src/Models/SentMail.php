<?php

namespace BristolSU\Mail\Models;

use BristolSU\Mail\Mail\EmailPayload;
use BristolSU\Mail\Mail\GenericMailable;
use BristolSU\Mail\Models\EmailAddress;
use BristolSU\Support\Authentication\Contracts\Authentication;
use Illuminate\Database\Eloquent\Builder;
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
        'priority' => 'integer',
        'failed_at' => 'datetime'
    ];

    protected $with = [
        'from', 'attachments', 'retries'
    ];

    protected $appends = [
        'status', 'preview'
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
        'resend_id',
        'failed_at'
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

    public function scopeWithFromId(Builder $query, array $fromIds = [])
    {
        $query->whereIn('from_id', $fromIds);
    }

    public function scopeAccessibleByCurrentUser(Builder $query)
    {
        $ids = EmailAddress::forUser(app(Authentication::class)->getUser())->get()->pluck('id')->toArray();
        $query->whereIn('from_id', $ids);
    }

    /**
     * A message is true if it either has is_sent as true, or a successful retry
     *
     * @param Builder $query
     */
    public function scopeSent(Builder $query)
    {
        $query->where('is_sent', true)
            ->orWhereHas('successfulRetries');
    }

    /**
     * A message has failed if is_error is true and, if resend_id is null it can't have any successful retries
     *
     * @param Builder $query
     */
    public function scopeFailed(Builder $query)
    {
        $query->where('is_error', true)
            ->whereDoesntHave('successfulRetries');
    }

    /**
     * A message is pending if is_error is false and is_sent is false
     *
     * @param Builder $query
     */
    public function scopePending(Builder $query)
    {
        $query->where('is_error', false)->where('is_sent', false);
    }

    public function successfulRetries()
    {
        return $this->retries()->where('is_sent', true);
    }

    public function getContentAttribute($value)
    {
        $json = json_decode($value, true);
        if(json_last_error() === JSON_ERROR_NONE) {
            return $json;
        }
        return $value;
    }

    public function setContentAttribute($value)
    {
        if(is_array($value)) {
            $value = json_encode($value);
        }
        $this->attributes['content'] = $value;
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

    public function getPreviewAttribute()
    {
        return $this->asMailable()->render();
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
        return (new EmailPayload(($this->content === null ? [] : $this->content), $this->to ?? [], $this->from))
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
