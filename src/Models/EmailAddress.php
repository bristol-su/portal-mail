<?php

namespace BristolSU\Mail\Models;

use BristolSU\ControlDB\Contracts\Models\User;
use BristolSU\Database\Mail\Factories\EmailAddressFactory;
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
        static::deleted(function(EmailAddress $model) {
            if(Ses::isAwsEnabled()) {
                Ses::deleteEmail($model->email);
            }
        });

        static::created(function(EmailAddress $model) {
            if(Ses::isAwsEnabled()) {
                Ses::addEmail($model->email);
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
