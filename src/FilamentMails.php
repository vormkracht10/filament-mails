<?php

namespace Vormkracht10\FilamentMails;

use Illuminate\Support\Facades\Route;
use Vormkracht10\FilamentMails\Controllers\MailDownloadController;
use Vormkracht10\FilamentMails\Controllers\MailPreviewController;

class FilamentMails
{
    public static function routes(?string $prefix = null)
    {
        $routeGroup = function () {
            Route::get('mails/{mail}/preview', MailPreviewController::class)->name('mails.preview');
            Route::get('mails/{mail}/attachment/{attachment}/{filename}', MailDownloadController::class)->name('mails.attachment.download');
        };

        if ($prefix) {
            Route::prefix($prefix)->group($routeGroup);
        } else {
            $routeGroup();
        }
    }
}
