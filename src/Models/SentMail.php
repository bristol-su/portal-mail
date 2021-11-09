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
        'tries' => 'integer',
        'is_error' => 'boolean',
        'sent_at' => 'datetime'
    ];

    protected $with = [
        'from', 'attachments'
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
        'tries',
        'sent_at'
    ];

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
        return (new EmailPayload($this->content, $this->to, $this->from))
            ->setSubject($this->subject)
            ->setCc($this->cc)
            ->setBcc($this->bcc)
            ->setNotes($this->notes)
            ->setSentVia($this->sent_via)
            ->setAttachments($this->attachments()->get()->all());
    }

    public function asMailable(): GenericMailable
    {
        return GenericMailable::forPayload($this->asPayload());
    }

}
