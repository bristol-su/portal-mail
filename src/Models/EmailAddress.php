<?php

namespace BristolSU\Mail\Models;

use Aws\Result;
use BristolSU\Database\Mail\Factories\EmailAddressFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailAddress extends Model
{
    use HasFactory;

    protected $table = 'portal_mail_email_addresses';

    protected $appends = ['status'];

    protected $fillable = [
        'email'
    ];

    public function getStatusAttribute()
    {
        if(!$this->id) {
            return 'N/A';
        }
        if(config('portal_mail.enable_aws', true) === false) {
            return 'AWS connection off';
        }

        $verified = cache()->remember('portal_mail.verified_emails', 10, function() {
            $sdk = app('aws')->createClient('ses');
            $verifiedResult = $sdk->listVerifiedEmailAddresses();
            return $verifiedResult->hasKey('VerifiedEmailAddresses') ? $verifiedResult->get('VerifiedEmailAddresses') : [];
        });

        if(in_array($this->email, $verified)) {
            return 'Verified';
        }

        return 'Waiting for Verification';
    }

    protected static function booted()
    {
        static::deleted(function(EmailAddress $model) {
            if(config('portal_mail.enable_aws', true)) {
                $sdk = app('aws')->createClient('ses');
                $sdk->deleteIdentity(['Identity' => $model->email]);
            }
        });

        static::created(function(EmailAddress $model) {
            if(config('portal_mail.enable_aws', false)) {
                $sdk = app('aws')->createClient('ses');
                $sdk->verifyEmailIdentity(['EmailAddress' => $model->email]);
            }
        });
    }

    protected static function newFactory()
    {
        return new EmailAddressFactory();
    }

}
