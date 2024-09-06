<?php

namespace Vormkracht10\FilamentMails\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Vormkracht10\Mails\Models\Mail;

class MailPreviewController extends Controller
{
    public function __invoke(Request $request)
    {
        $mail = Mail::find($request->mail);
        return response($mail->html);
    }
}