<?php

namespace BristolSU\Mail\Models;

use BristolSU\Database\Mail\Factories\EmailAddressUserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailAddressUser extends Model
{
    use HasFactory;

    protected $table = 'portal_mail_email_addresses_users';

    protected $fillable = [
        'email_address_id',
        'user_id'
    ];

    public function emailAddress()
    {
        return $this->belongsTo(EmailAddress::class);
    }

    protected static function newFactory()
    {
        return new EmailAddressUserFactory();
    }

}
