<?php

use Illuminate\Support\Facades\Route;
use Vormkracht10\FilamentMails\Controllers\MailDownloadController;
use Vormkracht10\FilamentMails\Controllers\MailPreviewController;

Route::get('mails/{mail}/preview', MailPreviewController::class)->name('mail.preview');
Route::get('mails/{mail}/attachment/{attachment}/{filename}', MailDownloadController::class)->name('mail.attachment.download');
