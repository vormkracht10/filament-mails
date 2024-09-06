<?php 

use Illuminate\Support\Facades\Route;
use Vormkracht10\FilamentMails\Controllers\MailPreviewController;

Route::get('/mail-preview/{mail}', MailPreviewController::class)->name('mail.preview');