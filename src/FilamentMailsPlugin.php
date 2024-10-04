<?php

namespace Vormkracht10\FilamentMails;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Colors\Color;

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
            ->resources([
                config('filament-mails.resources.mail'),
                config('filament-mails.resources.event'),
            ]);
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