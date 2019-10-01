<?php
namespace App\Classes;

use Illuminate\Support\Facades\Mail;
use Mockery\Exception;

class MailHelper {
    public function sendMail($template, $params, $to, $subject) {
        try{
            Mail::send(
                $template,
                $params,
                function($message) use ($to, $subject) {
                    $message
                        ->to($to) // receiver mail
                        ->subject($subject); // title
                }
            );
        }catch(Exception $e)
        {
            throw new Exception("Mail not sent.");
        }
    }
    
    public function sendMailWithAttachment($template, $params, $to, $subject, $data, $fileName) {
        try{
            Mail::send(
                $template,
                $params,
                function($message) use ($to, $subject, $data, $fileName) {
                    $message
                        ->to($to) // receiver mail
                        ->subject($subject)
                        ->attach(public_path('../storage/exports/'.$fileName, []));
                }
            );
        }catch(Exception $e)
        {
            throw new Exception("Mail not sent.");
        }
    }
}