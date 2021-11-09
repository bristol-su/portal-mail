<?php

namespace BristolSU\Mail\Models;

use BristolSU\ControlDB\Contracts\Models\User;
use BristolSU\Database\Mail\Factories\EmailAddressFactory;
use BristolSU\Mail\Models\SentMail;
use BristolSU\Mail\Ses\Ses;
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

    public function scopeWhereDomain(Builder $query, string $domain)
    {
        $query->where('email', 'LIKE', '%@' . $domain . '%');
    }

    public function emailAddressUser()
    {
        return $this->hasMany(EmailAddressUser::class);
    }

    public function getStatusAttribute()
    {
        if(!$this->id) {
            return 'N/A';
        }

        if(!Ses::isAwsEnabled()) {
            return 'AWS connection off';
        }

        if(Ses::isEmailVerified($this->email)) {
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
        static::deleted(function (EmailAddress $model) {
            $model->emailAddressUser()->delete();
        });

        static::deleted(function(EmailAddress $model) {
            if(Ses::isAwsEnabled()) {
                Ses::deleteEmail($model->email);
            }
        });


        static::created(function(EmailAddress $model) {
            if(Ses::isAwsEnabled() && !Ses::isEmailVerified($model->email)) {
                Ses::addEmail($model->email);
            }
        });

        static::deleted(function(EmailAddress $model) {
            if(Domain::where('domain', $model->domain)->exists() && EmailAddress::whereDomain($model->domain)->count() === 0) {
                Domain::where('domain', $model->domain)->delete();
            }
        });

        static::created(function(EmailAddress $model) {
            if(!Domain::where('domain', $model->domain)->exists()) {
                Domain::create(['domain' => $model->domain]);
            }
        });
    }

    public function sentMails()
    {
        return $this->hasMany(SentMail::class, 'from_id');
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
