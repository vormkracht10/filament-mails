<?php

namespace Vormkracht10\FilamentMails\Resources\EventResource\Pages;

use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Vormkracht10\FilamentMails\Resources\EventResource;
use Vormkracht10\Mails\Models\MailEvent;

class ListEvents extends ListRecords
{
    protected static string $resource = EventResource::class;

    public function getTitle(): string
    {
        return __('Events');
    }

    protected function getActions(): array
    {
        return [];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make()
                ->label(__('All'))
                ->icon('heroicon-o-inbox')
                ->badge(MailEvent::count()),
        ];
    }
}
