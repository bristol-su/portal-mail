<?php

namespace BristolSU\Mail\Models;

use Aws\Ses\SesClient;
use BristolSU\ControlDB\Contracts\Models\User;
use BristolSU\Database\Mail\Factories\EmailAddressFactory;
use BristolSU\Support\Authentication\Contracts\Authentication;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    use HasFactory;

    protected $table = 'portal_mail_domains';

    protected $appends = ['status', 'dns_records'];

    protected $fillable = [
        'domain'
    ];

    public function getDnsRecordsAttribute()
    {
        if(!$this->id || config('portal_mail.enable_aws', true) === false) {
            return [];
        }

        /** @var SesClient $ses */
        $ses = app('portal-mail-ses');
        $identities = $ses->getIdentityDkimAttributes(['Identities' => [$this->domain]])->get('DkimAttributes');
        if(array_key_exists($this->domain, $identities)) {
            $tokens = $identities[$this->domain]['DkimTokens'];
        } else {
            $tokens = $ses->verifyDomainDkim(['Domain' => $this->domain])->get('DkimTokens');
        }
        $records = [];
        foreach($tokens as $token) {
            $records[sprintf('%s._domainkey.%s', $token, $this->domain)] = sprintf('%s.dkim.amazonses.com', $token);
        }

        return $records;
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
            $verifiedResult = $sdk->getIdentityDkimAttributes(['Identities' => [$this->domain]]);
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
            // ToDO trigger to delete identity
            if(config('portal_mail.enable_aws', true)) {
                app('portal-mail-ses')->deleteIdentity(['Identity' => $model->email]);
            }
        });

        static::created(function(EmailAddress $model) {
            // TODO trigger aws to get cname details
            if(config('portal_mail.enable_aws', false)) {
                app('portal-mail-ses')->verifyEmailIdentity(['EmailAddress' => $model->email]);
            }
        });
    }

    protected static function newFactory()
    {
        return new EmailAddressFactory();
    }

}
