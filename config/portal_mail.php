<?php

return [
    'aws' => [
        'credentials' => [
            'key'    => env('PORTAL_MAIL_ACCESS_KEY_ID', env('AWS_ACCESS_KEY_ID', '')),
            'secret' => env('PORTAL_MAIL_AWS_SECRET_ACCESS', env('AWS_SECRET_ACCESS_KEY', '')),
        ],
        'region' => env('PORTAL_MAIL_AWS_REGION', env('AWS_DEFAULT_REGION', 'us-east-1')),
        'version' => 'latest',
        'ua_append' => [
            'L5MOD/' . \BristolSU\Mail\MailServiceProvider::VERSION,
        ],
    ],
    'enable_aws' => env('MAIL_DRIVER', 'array') === 'ses'
];
