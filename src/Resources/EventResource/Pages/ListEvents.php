<?php

namespace Vormkracht10\FilamentMails\Resources\EventResource\Pages;

use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Vormkracht10\FilamentMails\Resources\EventResource;
use Vormkracht10\Mails\Enums\EventType;
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

            'delivery' => Tab::make()
                ->label(__('Delivery'))
                ->icon('heroicon-o-check-circle')
                ->badge(MailEvent::where('type', EventType::DELIVERED)->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type', EventType::DELIVERED)),

            'click' => Tab::make()
                ->label(__('Click'))
                ->icon('heroicon-o-cursor-arrow-rays')
                ->badge(MailEvent::where('type', EventType::CLICKED)->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type', EventType::CLICKED)),

            'open' => Tab::make()
                ->label(__('Open'))
                ->icon('heroicon-o-envelope-open')
                ->badge(MailEvent::where('type', EventType::OPENED)->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type', EventType::OPENED)),

            'soft_bounce' => Tab::make()
                ->label(__('Soft Bounce'))
                ->icon('heroicon-o-x-circle')
                ->badge(MailEvent::where('type', EventType::SOFT_BOUNCED)->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type', EventType::SOFT_BOUNCED)),

            'hard_bounce' => Tab::make()
                ->label(__('Hard Bounce'))
                ->icon('heroicon-o-x-circle')
                ->badge(MailEvent::where('type', EventType::HARD_BOUNCED)->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type', EventType::HARD_BOUNCED)),

            'complaint' => Tab::make()
                ->label(__('Complaint'))
                ->icon('heroicon-o-exclamation-circle')
                ->badge(MailEvent::where('type', EventType::COMPLAINED)->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type', EventType::COMPLAINED)),
        ];
    }
}
