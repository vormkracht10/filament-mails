<?php

namespace Vormkracht10\FilamentMails\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Vormkracht10\Mails\Models\MailAttachment;

class MailDownloadController extends Controller
{
    public function __invoke(string $tenant, string $mail, string $attachment, string $filename)
    {
        /** @var MailAttachment $attachment */
        $attachment = MailAttachment::find($attachment);

        $file = Storage::disk($attachment->disk)->path($attachment->storagePath);

        return response()->download(
            file: $file,
            name: $filename,
            headers: [
                'Content-Type' => $attachment->mime,
            ]
        );
    }
}