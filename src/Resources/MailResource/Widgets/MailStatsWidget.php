<?php

namespace Vormkracht10\FilamentMails\Resources\MailResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MailStatsWidget extends BaseWidget
{
    protected static ?int $sort = 0;

    protected static bool $isDiscovered = false;

    protected function getStats(): array
    {
        $class = config('mails.models.mail');

        $bouncedMails = $class::where(fn ($query) => $query->softBounced()->orWhere(fn ($query) => $query->hardBounced()))->count();
        $openedMails = $class::opened()->count();
        $deliveredMails = $class::delivered()->count();
        $clickedMails = $class::clicked()->count();

        $mailCount = $class::count();

        if ($mailCount === 0) {
            return [];
        }

        $widgets[] = Stat::make(__('Delivered'), number_format(($deliveredMails / $mailCount) * 100, 1) . '%')
            ->label(__('Delivered'))
            ->description($deliveredMails . ' ' . __('of') . ' ' . $mailCount . ' ' . __('emails'))
            ->color('success');

        $widgets[] = Stat::make(__('Opened'), number_format(($openedMails / $mailCount) * 100, 1) . '%')
            ->label(__('Opened'))
            ->description($openedMails . ' ' . __('of') . ' ' . $mailCount . ' ' . __('emails'))
            ->color('info')
            ->url(route('filament.' . filament()->getCurrentPanel()?->getId() . '.resources.mails.index', [
                'activeTab' => 'opened',
                'tenant' => filament()->getTenant()?->id,
            ]));

        $widgets[] = Stat::make(__('Clicked'), number_format(($clickedMails / $mailCount) * 100, 1) . '%')
            ->label(__('Clicked'))
            ->description($clickedMails . ' ' . __('of') . ' ' . $mailCount . ' ' . __('emails'))
            ->color('clicked');

        $widgets[] = Stat::make(__('Bounced'), number_format(($bouncedMails / $mailCount) * 100, 1) . '%')
            ->label(__('Bounced'))
            ->description($bouncedMails . ' ' . __('of') . ' ' . $mailCount . ' ' . __('emails'))
            ->color('danger')
            ->url(route('filament.' . filament()->getCurrentPanel()?->getId() . '.resources.mails.index', [
                'activeTab' => 'bounced',
                'tenant' => filament()->getTenant()?->id,
            ]));

        return $widgets;
    }
}
