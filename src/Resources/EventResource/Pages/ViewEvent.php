<?php

namespace Vormkracht10\FilamentMails\Resources\EventResource\Pages;

use Filament\Resources\Pages\ViewRecord;
use Vormkracht10\FilamentMails\Resources\EventResource;

class ViewEvent extends ViewRecord
{
    public static function getResource(): string
    {
        return config('filament-mails.resources.mail', EventResource::class);
    }
}
