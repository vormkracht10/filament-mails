<?php

use Illuminate\Support\Facades\Route;
use Vormkracht10\FilamentMails\Controllers\MailPreviewController;
use Vormkracht10\FilamentMails\Controllers\MailDownloadController;

Route::get('/mail-preview/{mail}', MailPreviewController::class)->name('mail.preview');
Route::get('/mail-download/{attachment}', MailDownloadController::class)->name('mail.download');