<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class SendNotification extends Model

{
    public static function send($device_id, $title, $message, $open_data)
    {
        // print_r($device_id);exit;
                            $url_fcm = "https://fcm.googleapis.com/fcm/send";
                            $server_key = "AAAA1p67NLU:APA91bHKwGzAxKb9EQ6OXYXT6029EKHqM4ZlK0dhIvzq4EMADi-cAFK63tmfE6cptUz0zMXyyF_940kI-yx9IstTm8_zpI1OavlsCGfMi8JW7xr_fu0_OYTDeEfPRWvvymxZHIiscWWP";
                            $header = array('Authorization: key='.$server_key, 'Content-Type: application/json');
                            $field = array('to'=>$device_id,
                                    	'priority'=>'high',
                                    	'data'=>array('title'=>$title, 'message'=>$message, 'open_data'=>$open_data)
                                    );
                            $ch = curl_init();
                            curl_setopt($ch, CURLOPT_URL, $url_fcm);
                            curl_setopt($ch, CURLOPT_POST, true);
                            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                            curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($field));
                            $result_curl = curl_exec($ch);
                            if ($result_curl === FALSE) 
                            {
                            	die('Curl failed: ' . curl_error($ch));
                            }
                            curl_close($ch);
        
    }
    
    
} 
?>