<?php

namespace Vormkracht10\FilamentMails;

use Filament\Panel;
use Filament\Contracts\Plugin;
use Filament\Facades\Filament;
use Filament\Support\Colors\Color;
use Filament\Navigation\NavigationItem;
use Vormkracht10\FilamentMails\Resources\MailResource;
use Vormkracht10\FilamentMails\Resources\EventResource;
use Vormkracht10\FilamentMails\Widgets\BouncerateWidget;

class FilamentMailsPlugin implements Plugin
{
    public function getId(): string
    {
        return 'filament-mails';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->colors([
                'clicked' => Color::Purple,
            ])
            ->discoverResources(in: __DIR__ . '/Resources', for: 'Vormkracht10\\FilamentMails\\Resources')
            ->discoverWidgets(in: __DIR__ . '/Widgets', for: 'Vormkracht10\\FilamentMails\\Widgets');
    }

    public function boot(Panel $panel): void
    {
        Filament::serving(function () use ($panel) {
            Filament::registerNavigationItems([
                NavigationItem::make()
                    ->group(__('Test'))
                    ->label('Mails')
                    ->url(fn(): string => MailResource::getUrl('index'))
                    ->icon('heroicon-o-envelope')
                    ->isActiveWhen(fn(): bool => request()->routeIs('filament.' . $panel->getId() . '.resources.mails.*'))
                    ->childItems([
                        NavigationItem::make()
                            ->label('Events')
                            ->url(fn(): string => EventResource::getUrl('index'))
                            ->icon('heroicon-o-calendar')
                            ->isActiveWhen(fn(): bool => request()->routeIs('filament.' . $panel->getId() . '.resources.events.*'))
                    ])
            ]);
        });
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }
}
