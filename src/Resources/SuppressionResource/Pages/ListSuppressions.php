<?php

namespace Vormkracht10\FilamentMails\Resources\SuppressionResource\Pages;

use Filament\Resources\Pages\ListRecords;
use Vormkracht10\FilamentMails\Resources\SuppressionResource;

class ListSuppressions extends ListRecords
{
    protected static string $resource = SuppressionResource::class;

    public function getTitle(): string
    {
        return __('Suppressions');
    }

    protected function getActions(): array
    {
        return [];
    }
}
