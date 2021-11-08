<?php

namespace BristolSU\Mail\Ses;

interface SesClient
{

    public function resendVerificationEmail(string $email);

    public function isEmailVerified(string $email): bool;

    public function getVerifiedEmails(): array;

    public function deleteEmail(string $email);

    public function addEmail(string $email);

    public function isDomainVerified(string $domain): bool;

    public function getDkimTokens(string $domain): array;

    public function getDomainAttributes(string $domain): array;

    public function getCnameRecordsForDomain(string $domain): array;

    public function isAwsEnabled(): bool;

}
