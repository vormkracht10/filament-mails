<?php

namespace Vormkracht10\FilamentMails\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Vormkracht10\Mails\Models\Mail;
use Illuminate\Support\Facades\Storage;
use Vormkracht10\Mails\Models\MailAttachment;

class MailDownloadController extends Controller
{
    public function __invoke(Request $request)
    {
        $attachment = MailAttachment::find($request->attachment);

        $file = Storage::disk($attachment->disk)->get($attachment->uuid);

        return response()->download($file);
    }
}