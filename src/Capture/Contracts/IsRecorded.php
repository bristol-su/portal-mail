<?php

namespace BristolSU\Mail\Capture\Contracts;

use BristolSU\Mail\Mail\EmailPayload;

interface IsRecorded
{

    public function payload(): EmailPayload;

}
