<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class SendMail extends Model
{
   public static function send($to, $subject, $message)
    {
        $headers  = 'From: <info@bmongers.com>' . "\r\n" .
            		'MIME-Version: 1.0' . "\r\n" .
            	    'Content-type: text/html; charset=utf-8';   
		mail($to, $subject, $message, $headers);
    }
}
