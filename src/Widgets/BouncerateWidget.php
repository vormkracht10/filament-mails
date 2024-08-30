<?php

namespace Vormkracht10\FilamentMails\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Vormkracht10\FilamentMails\Models\Mail;

class BouncerateWidget extends BaseWidget
{
    protected static ?int $sort = 0;

    protected function getStats(): array
    {
        $bouncedMails = Mail::where(fn ($query) => $query->softBounced()->orWhere(fn ($query) => $query->hardBounced()))->count();
        $openedMails = Mail::opened()->count();
        $clickedMails = Mail::clicked()->count();

        $mailCount = Mail::count();

        $widgets[] = Stat::make(__('Bounced'), $bouncedMails)
            ->label(__('Bounced'))
            ->description($bouncedMails . ' ' . __('of') . ' ' . $mailCount . ' ' . __('emails'))
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->chart([7, 2, 10, 3, 22, 4, 17])
            ->color('danger')
            ->url(route('filament.admin.resources.mails.index', ['activeTab' => 'bounced']));

        $widgets[] = Stat::make(__('Opened'), $openedMails)
            ->label(__('Opened'))
            ->description($openedMails . ' ' . __('of') . ' ' . $mailCount . ' ' . __('emails'))
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->chart([7, 2, 10, 3, 22, 4, 17])
            ->color('success')
            ->url(route('filament.admin.resources.mails.index', ['activeTab' => 'opened']));

        $widgets[] = Stat::make(__('Clicked'), $clickedMails)
            ->label(__('Clicked'))
            ->description($clickedMails . ' ' . __('of') . ' ' . $mailCount . ' ' . __('emails'))
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->chart([7, 2, 10, 3, 22, 4, 17])
            ->color('clicked')
            ->url(route('filament.admin.resources.mails.index', ['activeTab' => 'clicked']));

        return $widgets;
    }
}
