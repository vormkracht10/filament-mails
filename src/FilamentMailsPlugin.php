<?php

namespace Vormkracht10\FilamentMails;

use Filament\Panel;
use Filament\Contracts\Plugin;
use Filament\Facades\Filament;
use Filament\Support\Colors\Color;
use Filament\Navigation\NavigationItem;
use Vormkracht10\FilamentMails\Models\Mail;
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
            ->resources([
                MailResource::class,
            ])
            ->colors([
                'clicked' => Color::Purple,
            ])
            ->widgets([
                BouncerateWidget::class,
            ])
            ->discoverWidgets(in: __DIR__ . '/Widgets', for: 'App\\Filament\\Widgets');
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
