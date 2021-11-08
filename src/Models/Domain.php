<?php

namespace BristolSU\Mail\Models;

use BristolSU\Database\Mail\Factories\EmailAddressFactory;
use BristolSU\Mail\Ses\Ses;
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
        if($this->exists && Ses::isAwsEnabled()) {
            return Ses::getCnameRecordsForDomain($this->domain);
        }

        return [];
    }

    public function getStatusAttribute()
    {
        if($this->exists === false) {
            return 'N/A';
        }
        if(!Ses::isAwsEnabled()) {
            return 'AWS connection off';
        }

        if(Ses::isDomainVerified($this->domain)) {
            return 'Verified';
        }

        return 'Waiting for Verification';
    }

    protected static function newFactory()
    {
        return new EmailAddressFactory();
    }

}
