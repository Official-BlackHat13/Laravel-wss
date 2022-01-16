<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SendMessage extends Model
{
    public static function send($message, $mobile)
    {
        $message_data = urlencode($message);
       
        $api_url = 'https://api.msg91.com/api/sendhttp.php?mobiles='.$mobile.'&authkey=120132AQvwVvLmz5f997a8eP1&route=4&sender=SLMYCL&message='.$message_data.'&country=91&DLT_TE_ID=1307161968498176149';
        SendMessage :: url_get_contents($api_url);
    }
    static function url_get_contents ($Url) 
    {
        // print_r($Url);exit;
        if (!function_exists('curl_init'))
        { 
            die('CURL is not installed!');
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $Url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);
        // print_r($output);exit;
        return $output;
        
    }
}