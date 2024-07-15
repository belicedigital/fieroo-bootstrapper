<?php

namespace Fieroo\Bootstrapper\Controllers;

use App\Http\Controllers\Controller;
use Mail;

class BootstrapperController extends Controller
{
    public function sendEmail($subject, $emailFormatData, $emailTemplate, $emailFrom, $emailTo, $pdfContent = null, $pdfFileName= null)
    {
        $body = formatDataForEmail($emailFormatData, $emailTemplate);
        if(!is_string($body)) {
            dd('non è una stringa');
        }
        $data = [
            'body' => $body
        ];

        Mail::send('bootstrapper::emails.form-data', ['data' => $data], function ($m) use ($emailFrom, $emailTo, $subject, $pdfContent, $pdfFileName){
            $m->from($emailFrom, env('MAIL_FROM_NAME'));
            $m->to($emailTo)->subject(env('APP_NAME').' '.$subject);
            // Attach PDF
            if ($pdfContent && $pdfFileName) {
                $m->attachData($pdfContent, $pdfFileName, [
                    'mime' => 'application/pdf',
                ]);
            }
        });
    }
}
