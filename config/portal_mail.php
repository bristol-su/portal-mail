<?php

return [
    'aws' => [
        'credentials' => [
            'key'    => env('AWS_ACCESS_KEY_ID', ''),
            'secret' => env('AWS_SECRET_ACCESS_KEY', ''),
        ],
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
        'version' => 'latest',
        'ua_append' => [
            'L5MOD/' . \BristolSU\Mail\MailServiceProvider::VERSION,
        ],
    ],
    'enable_aws' => env('ENABLE_AWS_EMAIL_VERIFICATION', true)
];
