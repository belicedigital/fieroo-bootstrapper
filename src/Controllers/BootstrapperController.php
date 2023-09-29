<?php

namespace Fieroo\Bootstrapper\Controllers;

use App\Http\Controllers\Controller;
use Mail;

class BootstrapperController extends Controller
{
    public function sendEmail($subject, $emailFormatData, $emailTemplate, $emailFrom, $emailTo)
    {
        $body = formatDataForEmail($emailFormatData, $emailTemplate);

        $data = [
            'body' => $body
        ];

        Mail::send('emails.form-data', ['data' => $data], function ($m) use ($emailFrom, $emailTo, $subject){
            $m->from($emailFrom, env('MAIL_FROM_NAME'));
            $m->to($emailTo)->subject(env('APP_NAME').' '.$subject);
        });
    }
}
