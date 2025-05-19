<?php

namespace Vormkracht10\FilamentMails\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

class MailDownloadController extends Controller
{
    public function __invoke(...$arguments)
    {
        if (count($arguments) === 4) {
            [$tenant, $mail, $attachment, $filename] = $arguments;
        } else {
            [$mail, $attachment, $filename] = $arguments;
            $tenant = null;
        }

        $attachmentModel = Config::get('mails.models.attachment');
        /** @var \Vormkracht10\Mails\Models\MailAttachment $attachment */
        $attachment = $attachmentModel::find($attachment);

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
