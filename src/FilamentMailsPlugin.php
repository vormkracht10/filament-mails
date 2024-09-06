<?php

namespace Vormkracht10\FilamentMails;

use Filament\Contracts\Plugin;
use Filament\Facades\Filament;
use Filament\Navigation\NavigationItem;
use Filament\Panel;
use Filament\Support\Colors\Color;
use Vormkracht10\FilamentMails\Resources\EventResource;
use Vormkracht10\FilamentMails\Resources\MailResource;

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
        //   
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
