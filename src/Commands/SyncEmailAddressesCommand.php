<?php

namespace BristolSU\Mail\Commands;

use BristolSU\Mail\Models\EmailAddress;
use BristolSU\Mail\Ses\Ses;
use Illuminate\Console\Command;

class SyncEmailAddressesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'portal-mail:sync-addresses';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the email addresses that are allowed to be sent from.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach(Ses::getVerifiedEmails() as $email) {
            if(!EmailAddress::where('email', $email)->exists()) {
                EmailAddress::create(['email' => $email]);
                $this->info(sprintf('Authorized sending from %s', $email));
            }
        }
    }
}
