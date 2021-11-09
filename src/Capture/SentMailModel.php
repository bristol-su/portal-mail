<?php

namespace BristolSU\Mail\Capture;

use BristolSU\Mail\Mail\EmailPayload;
use BristolSU\Mail\Mail\GenericMailable;
use BristolSU\Mail\Models\EmailAddress;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class SentMailModel extends Model
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
        'from'
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
            ->setSentVia($this->sent_via);
    }

    public function asMailable(): GenericMailable
    {
        return GenericMailable::forPayload($this->asPayload());
    }

}
