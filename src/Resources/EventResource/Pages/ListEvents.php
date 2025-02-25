<?php

namespace Vormkracht10\FilamentMails\Resources\EventResource\Pages;

// use App\Filament\Widgets\MailsPerStatusChart;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Vormkracht10\FilamentMails\Resources\EventResource;
use Vormkracht10\Mails\Enums\EventType;
use Vormkracht10\Mails\Models\MailEvent;

class ListEvents extends ListRecords
{
    public static function getResource(): string
    {
        return config('filament-mails.resources.event', EventResource::class);
    }

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
                ->badgeColor('primary')
                ->icon('heroicon-o-inbox')
                ->badge(MailEvent::count()),

            'delivered' => Tab::make()
                ->label(__('Delivered'))
                ->badgeColor('success')
                ->icon('heroicon-o-check-circle')
                ->badge(MailEvent::where('type', EventType::DELIVERED)->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type', EventType::DELIVERED)),

            'clicked' => Tab::make()
                ->label(__('Clicked'))
                ->badgeColor('clicked')
                ->icon('heroicon-o-cursor-arrow-rays')
                ->badge(MailEvent::where('type', EventType::CLICKED)->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type', EventType::CLICKED)),

            'opened' => Tab::make()
                ->label(__('Opened'))
                ->badgeColor('info')
                ->icon('heroicon-o-envelope-open')
                ->badge(MailEvent::where('type', EventType::OPENED)->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type', EventType::OPENED)),

            'soft_bounce' => Tab::make()
                ->label(__('Soft Bounced'))
                ->icon('heroicon-o-x-circle')
                ->badge(MailEvent::where('type', EventType::SOFT_BOUNCED)->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type', EventType::SOFT_BOUNCED)),

            'bounced' => Tab::make()
                ->label(__('Bounced'))
                ->badgeColor('danger')
                ->icon('heroicon-o-x-circle')
                ->badge(fn () => MailEvent::where('type', EventType::SOFT_BOUNCED)->count() + MailEvent::where('type', EventType::HARD_BOUNCED)->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where(function ($query) {
                    $query->where('type', EventType::SOFT_BOUNCED)
                        ->orWhere('type', EventType::HARD_BOUNCED);
                })),

            'complained' => Tab::make()
                ->label(__('Complained'))
                ->badgeColor('warning')
                ->icon('heroicon-o-exclamation-circle')
                ->badge(MailEvent::where('type', EventType::COMPLAINED)->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type', EventType::COMPLAINED)),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            // MailsPerStatusChart::class,
        ];
    }
}
