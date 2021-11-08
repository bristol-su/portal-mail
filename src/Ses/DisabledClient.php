<?php

namespace BristolSU\Mail\Ses;

class DisabledClient implements SesClient
{

    public function resendVerificationEmail(string $email)
    {
        return;
    }

    public function isEmailVerified(string $email): bool
    {
        return false;
    }

    public function getVerifiedEmails(): array
    {
        return [];
    }

    public function deleteEmail(string $email)
    {
        return;
    }

    public function addEmail(string $email)
    {
        return;
    }

    public function isDomainVerified(string $domain): bool
    {
        return false;
    }

    public function getDkimTokens(string $domain): array
    {
        return [];
    }

    public function getDomainAttributes(string $domain): array
    {
        return [];
    }

    public function getCnameRecordsForDomain(string $domain): array
    {
        return [];
    }

    public function isAwsEnabled(): bool
    {
        return false;
    }
}
