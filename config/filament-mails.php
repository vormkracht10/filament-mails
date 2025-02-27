<?php

use Vormkracht10\FilamentMails\Resources\EventResource;
use Vormkracht10\FilamentMails\Resources\MailResource;
use Vormkracht10\FilamentMails\Resources\SuppressionResource;

return [
    'resources' => [
        'mail' => MailResource::class,
        'event' => EventResource::class,
        'suppression' => SuppressionResource::class,
    ],

    'navigation' => [
        'group' => null,
    ],
];
