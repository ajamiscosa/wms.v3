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
}