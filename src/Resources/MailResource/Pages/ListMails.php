<?php

namespace Vormkracht10\FilamentMails\Resources\MailResource\Pages;

use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Vormkracht10\FilamentMails\Resources\MailResource;
use Vormkracht10\FilamentMails\Resources\MailResource\Widgets\MailStatsWidget;
use Vormkracht10\Mails\Models\Mail;

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
                ->badgeColor('primary')
                ->icon('heroicon-o-inbox')
                ->badge(Mail::count()),

            'sent' => Tab::make()
                ->label(__('Sent'))
                ->badgeColor('info')
                ->icon('heroicon-o-paper-airplane')
                ->badge(Mail::sent()->count())
                ->modifyQueryUsing(function (Builder $query): Builder {
                    /** @var Mail $model */
                    $model = $query->getModel();
                    return $model->sent();
                }),

            'delivered' => Tab::make()
                ->label(__('Delivered'))
                ->badgeColor('success')
                ->icon('heroicon-o-check-circle')
                ->badge(Mail::delivered()->count())
                ->modifyQueryUsing(function (Builder $query): Builder {
                    /** @var Mail $model */
                    $model = $query->getModel();
                    return $model->delivered();
                }),

            'opened' => Tab::make()
                ->label(__('Opened'))
                ->badgeColor('info')
                ->icon('heroicon-o-eye')
                ->badge(Mail::opened()->count())
                ->modifyQueryUsing(function (Builder $query): Builder {
                    /** @var Mail $model */
                    $model = $query->getModel();
                    return $model->opened();
                }),

            'clicked' => Tab::make()
                ->label(__('Clicked'))
                ->badgeColor('clicked')
                ->icon('heroicon-o-cursor-arrow-rays')
                ->badge(Mail::clicked()->count())
                ->modifyQueryUsing(function (Builder $query): Builder {
                    /** @var Mail $model */
                    $model = $query->getModel();
                    return $model->clicked();
                }),

            'bounced' => Tab::make()
                ->label(__('Bounced'))
                ->badgeColor('danger')
                ->icon('heroicon-o-x-circle')
                ->badge(fn() => Mail::softBounced()->count() + Mail::hardBounced()->count())
                ->modifyQueryUsing(fn(Builder $query) => $query->where(function ($query) {
                    /** @var Mail $model */
                    $model = $query->getModel();
                    return $model->where(function (Builder $query): void {
                        $query->softBounced()->orWhere(function (Builder $query): void {
                            $query->hardBounced();
                        });
                    });
                })),

            'unsent' => Tab::make()
                ->label(__('Unsent'))
                ->badgeColor('gray')
                ->icon('heroicon-o-x-circle')
                ->badge(Mail::unsent()->count())
                ->modifyQueryUsing(function (Builder $query): Builder {
                    /** @var Mail $model */
                    $model = $query->getModel();
                    return $model->unsent();
                }),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            MailStatsWidget::class,
        ];
    }
}
