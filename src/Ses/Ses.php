<?php

namespace BristolSU\Mail\Ses;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void resendVerificationEmail(string $email) Resend the verification email to the given email address
 * @method static void deleteEmail(string $email) Delete the email address from AWS
 * @method static void addEmail(string $email) Add the email address to AWS
 * @method static bool isEmailVerified(string $email) Check if the given email is verified
 * @method static bool isAwsEnabled() Check if AWS is enabled
 * @method static array getVerifiedEmails() Get an array of all verified emails
 * @method static bool isDomainVerified(string $domain) Check if the given domain is verified
 * @method static array getCnameRecordsForDomain(string $domain) Get the CNAME DNS records for the given domain
 * @method static array getDkimTokens(string $domain) Get the DKIM tokens for the given domain
 * @method static array getDomainAttributes(string $domain) Get the domain attributes for the given domain
 *
 * @see SesClient
 */
class Ses extends Facade
{

    protected static function getFacadeAccessor()
    {
        return SesClient::class;
    }
}
