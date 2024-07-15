<?php

namespace Fieroo\Bootstrapper\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Mail;

class BootstrapperController extends Controller
{
    public function sendEmail($subject, $emailFormatData, $emailTemplate, $emailFrom, $emailTo, $pdfContent = null, $pdfFileName= null)
    {
        Log::info('entro nella funzione sendEmail');
        $body = formatDataForEmail($emailFormatData, $emailTemplate);
        Log::info('dati body formattati');

        $data = [
            'body' => $body
        ];

        dd($data);

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
        
        Log::info('email inviata...? boh');
    }
}
