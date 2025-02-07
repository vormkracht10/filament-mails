<?php

namespace Vormkracht10\FilamentMails;

use Illuminate\Support\Facades\Route;
use Vormkracht10\FilamentMails\Controllers\MailDownloadController;
use Vormkracht10\FilamentMails\Controllers\MailPreviewController;

class FilamentMails
{
    protected static string $path;

    protected static string $name;

    public static function setPath(?string $path = null): void
    {
        static::$path = $path ?? filament()->getDefaultPanel()->getPath();
    }

    public static function setName(?string $name = null): void
    {
        static::$name = $name ?? 'filament.' . filament()->getDefaultPanel()->getId();
    }

    public static function routes(?string $path = null, ?string $name = null): void
    {
        static::setPath($path);
        static::setName($name);

        Route::prefix(static::$path)
            ->name(static::$name)
            ->group(function () {
                Route::get('mails/{mail}/preview', MailPreviewController::class)->name('mails.preview');
                Route::get('mails/{mail}/attachment/{attachment}/{filename}', MailDownloadController::class)->name('mails.attachment.download');
            });
    }
}
