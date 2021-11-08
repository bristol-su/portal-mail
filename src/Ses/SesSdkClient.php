<?php

namespace BristolSU\Mail\Ses;

use Illuminate\Contracts\Cache\Repository;

class SesSdkClient implements SesClient
{

    const TTL = 20;

    public function resendVerificationEmail(string $email)
    {
        if ($this->isEmailVerified($email)) {
            return;
        }
        $this->deleteEmail($email);
        $this->addEmail($email);
    }

    public function isEmailVerified(string $email): bool
    {
        return in_array($email, $this->getVerifiedEmails());
    }

    public function getVerifiedEmails(): array
    {
        return $this->cache()->remember(sprintf('%s@getVerifiedEmails', static::class), static::TTL, function () {
            $verifiedResult = $this->client()->listVerifiedEmailAddresses();
            return $verifiedResult->hasKey('VerifiedEmailAddresses') ? $verifiedResult->get('VerifiedEmailAddresses') : [];
        });
    }

    private function cache(): Repository
    {
        return cache()->store();
    }

    private function client(): \Aws\Ses\SesClient
    {
        return app()->make('portal-mail-aws')->createClient('ses');
    }

    public function deleteEmail(string $email)
    {
        $this->client()->deleteIdentity(['Identity' => $email]);
    }

    public function addEmail(string $email)
    {
        $this->client()->verifyEmailIdentity(['EmailAddress' => $email]);
    }

    public function isDomainVerified(string $domain): bool
    {
        $attributes = $this->getDomainAttributes($domain);
        return !empty($attributes) && $attributes['DkimVerificationStatus'] === 'True';
    }

    public function getDkimTokens(string $domain): array
    {
        $attributes = $this->getDomainAttributes($domain);
        return empty($attributes)
            ? $this->client()->verifyDomainDkim(['Domain' => $domain])->get('DkimTokens')
            : $attributes['DkimTokens'];
    }

    public function getCnameRecordsForDomain(string $domain): array
    {
        return collect($this->getDkimTokens($domain))
            ->mapWithKeys(fn(string $token) => [sprintf('%s._domainkey.%s', $token, $domain) => sprintf('%s.dkim.amazonses.com', $token)])
            ->all();
    }

    public function getDomainAttributes(string $domain): array
    {
        return $this->cache()->remember(
            sprintf('%s@getDomainAttributes:%s', static::class, $domain),
            static::TTL,
            function () use ($domain) {
                $attributes = $this->client()->getIdentityDkimAttributes(['Identities' => [$domain]])->get('DkimAttributes');
                return array_key_exists($domain, $attributes) ? $attributes[$domain] : [];
            }
        );
    }

    public function isAwsEnabled(): bool
    {
        return true;
    }
}
