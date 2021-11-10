<?php

namespace BristolSU\Mail\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class Attachment extends Model
{

    protected $table = 'portal_mail_attachments';

    protected $fillable = [
        'filename',
        'mime',
        'path',
        'size',
        'sent_mail_id'
    ];

    protected static function booted()
    {
        static::deleting(function (Attachment $model) {
            if(Attachment::where('path', $model->path)->count() === 1) {
                Storage::delete($model->path);
            }
        });
    }

    public function sentMail()
    {
        return $this->belongsTo(SentMail::class, 'sent_mail_id');
    }

}
