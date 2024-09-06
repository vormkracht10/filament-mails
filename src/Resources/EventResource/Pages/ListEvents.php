<?php

namespace Vormkracht10\FilamentMails\Resources\EventResource\Pages;

use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Vormkracht10\FilamentMails\Resources\EventResource;
use Vormkracht10\Mails\Enums\WebhookEventType;
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
                ->badge(MailEvent::where('type', WebhookEventType::DELIVERY)->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type', WebhookEventType::DELIVERY)),

            'click' => Tab::make()
                ->label(__('Click'))
                ->icon('heroicon-o-cursor-arrow-rays')
                ->badge(MailEvent::where('type', WebhookEventType::CLICK)->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type', WebhookEventType::CLICK)),

            'open' => Tab::make()
                ->label(__('Open'))
                ->icon('heroicon-o-envelope-open')
                ->badge(MailEvent::where('type', WebhookEventType::OPEN)->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type', WebhookEventType::OPEN)),

            'bounce' => Tab::make()
                ->label(__('Bounce'))
                ->icon('heroicon-o-x-circle')
                ->badge(MailEvent::where('type', WebhookEventType::BOUNCE)->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type', WebhookEventType::BOUNCE)),

            'complaint' => Tab::make()
                ->label(__('Complaint'))
                ->icon('heroicon-o-exclamation-circle')
                ->badge(MailEvent::where('type', WebhookEventType::COMPLAINT)->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type', WebhookEventType::COMPLAINT)),
        ];
    }
}
