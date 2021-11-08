<?php

namespace BristolSU\Mail\Models;

use BristolSU\ControlDB\Contracts\Models\User;
use BristolSU\Database\Mail\Factories\EmailAddressFactory;
use BristolSU\Support\Authentication\Contracts\Authentication;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailAddress extends Model
{
    use HasFactory;

    protected $table = 'portal_mail_email_addresses';

    protected $appends = ['status', 'domain'];

    protected $fillable = [
        'email'
    ];

    public function emailAddressUser()
    {
        return $this->hasMany(EmailAddressUser::class);
    }

    public function getStatusAttribute()
    {
        if(!$this->id) {
            return 'N/A';
        }
        if(config('portal_mail.enable_aws', true) === false) {
            return 'AWS connection off';
        }

        $verified = cache()->remember('portal_mail.verified_emails', 10, function() {
            $sdk = app('portal-mail-ses');
            $verifiedResult = $sdk->listVerifiedEmailAddresses();
            return $verifiedResult->hasKey('VerifiedEmailAddresses') ? $verifiedResult->get('VerifiedEmailAddresses') : [];
        });

        if(in_array($this->email, $verified)) {
            return 'Verified';
        }

        return 'Waiting for Verification';
    }

    public function getDomainAttribute()
    {
        return explode('@', $this->email)[1];
    }

    protected static function booted()
    {
        static::deleted(function(EmailAddress $model) {
            if(config('portal_mail.enable_aws', true)) {
                app('portal-mail-ses')->deleteIdentity(['Identity' => $model->email]);
            }
        });

        static::created(function(EmailAddress $model) {
            if(config('portal_mail.enable_aws', false)) {
                app('portal-mail-ses')->verifyEmailIdentity(['EmailAddress' => $model->email]);
            }
        });

        static::deleted(function(EmailAddress $model) {
            $domain = $model->domain;
            if(!Domain::where('domain', $domain)->exists() && EmailAddress::where('domain', 'LIKE', '%@' . $domain . '%')->count() > 0) {
                Domain::where(['domain' => $domain])->delete();
            }
        });

        static::created(function(EmailAddress $model) {
            $domain = $model->domain;
            if(!Domain::where('domain', $domain)->exists()) {
                Domain::create(['domain' => $domain]);
            }
        });
    }

    public function currentUserCanAccess(): bool
    {
        return $this->emailAddressUser()->where('user_id', app(Authentication::class)->getUser()->id())->exists();
    }

    public function scopeForUser(Builder $query, User $user)
    {
        return $query->whereHas('emailAddressUser', fn(Builder $query) => $query->where('user_id', $user->id()));
    }

    protected static function newFactory()
    {
        return new EmailAddressFactory();
    }

}
