<?php

namespace Vormkracht10\FilamentMails\Resources\MailResource\Pages;

use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Vormkracht10\FilamentMails\Models\Mail;
use Vormkracht10\FilamentMails\Resources\MailResource;
use Vormkracht10\FilamentMails\Widgets\BouncerateWidget;

class ListMails extends ListRecords
{
    protected static string $resource = MailResource::class;

    public function getTitle(): string
    {
        return __('Mails');
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
                ->badge(Mail::count()),
            'sent' => Tab::make()
                ->label(__('Sent'))
                ->icon('heroicon-o-paper-airplane')
                ->badge(Mail::sent()->count())
                ->modifyQueryUsing(fn(Builder $query) => $query->sent()),
            'delivered' => Tab::make()
                ->label(__('Delivered'))
                ->icon('heroicon-o-check-circle')
                ->badge(Mail::delivered()->count())
                ->modifyQueryUsing(fn(Builder $query) => $query->delivered()),
            'bounced' => Tab::make()
                ->label(__('Bounced'))
                ->icon('heroicon-o-x-circle')
                ->badge(fn() => Mail::softBounced()->count() + Mail::hardBounced()->count())
                ->modifyQueryUsing(fn(Builder $query) => $query->where(function ($query) {
                    $query->softBounced()->orWhere(function ($query) {
                        $query->hardBounced();
                    });
                })),
            'unsent' => Tab::make()
                ->label(__('Unsent'))
                ->icon('heroicon-o-x-circle')
                ->badge(Mail::unsent()->count())
                ->modifyQueryUsing(fn(Builder $query) => $query->unsent()),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            BouncerateWidget::class
        ];
    }
}