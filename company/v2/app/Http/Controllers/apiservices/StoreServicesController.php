<?php
namespace App\Http\Controllers\apiservices;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\User;
use Response;
use Storage;
use File;
use Hash;
use Mail;
class StoreServicesController extends Controller
{ 
    
    public function store_login(Request $request){
        $stream = $request->json()->all();
        $fetchusr  = DB::table('store_admin')
                    ->select('*')
                    ->where(['email'=>$stream["email"]])
                    ->first();
        
        $fcm_token = (!empty($stream["fcm_token"])) ? $stream["fcm_token"]: '';
        
        if($fcm_token != '')
        {
            $affected = DB::table('store_admin')
                        ->where('id', $fetchusr->id)
                        ->update(['fcm_token'=>$fcm_token]);
        }
        
        if(!empty($fetchusr))
        {
            $pwd = $fetchusr->password;
            $a=  Hash::check($stream["password"], $pwd);
            if($fetchusr->status=='1'){
                if($a)
                {
                    return response()->json(['response'=>'success' ,'userid' =>$fetchusr->id,'name'=>$fetchusr->name,'email'=>$fetchusr->email,'mobile'=>$fetchusr->phone,
                                            'age'=>$fetchusr->age,'gender'=>$fetchusr->gender]); 
                }
                else
                {
                    return response()->json(['response'=>'Failed ','message'=>'Invalid Password']);
                }
            }else{
                return response()->json(['response'=>'Failed ','message'=>'Your account is not activated yet']);
            }    
        }
        else
        {
            return response()->json(['response'=>'Failed','message'=>'Invalid Email']); 
        }
        
    }
    
    public function store_forgot_password_sent_otp(Request $request){
        $stream = $request->json()->all();
        
        $userinfo = DB::table('store_admin')
                    ->select('store_admin.id')
                    ->where('store_admin.email', '=', $stream["email"])
                    ->first();
                    
        if(empty($userinfo))
        {
            return response()->json(['response'=>'Failed','message'=>'This email is not exist']); 
        }
        else
        {   
            $data=rand(100000,999999);
            $pro["email"]=$stream["email"];
            $pro["otp"]=$data;
            $insert = DB::table('otp_verify')->insert($pro);
            if($insert){
                $u='<html xmlns="http://www.w3.org/1999/xhtml">
                    <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
                    </head>
                    <body style="margin: 0; padding: 0;">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%"> 
                            <tr>
                                <td style="padding: 10px 0 30px 0;">
                                    <span>You are receiving this email because we recieved a password reset request for your account</span><br><br>
                                    <span href="#">Use this OTP to verify your account. Your OTP is '.$data.' </span><br><br>
                                    <span href="#">This OTP is valid for 10 Minutes.</span>
                                </td>
                            </tr>
                        </table>
                    </body>
                    </html>';
                $to_email = $stream["email"];
                $subject = 'OTP for  Forgot Password ';
                $message = $u;
                $headers = "From: mahesh.c@technobyte.in \r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                mail($to_email,$subject,$message,$headers);
                
                return response()->json(['response'=>'success','message'=>'Password reset OTP has been sent to your email']); 
            }
        }
        
    }
    
    public function store_check_otp(Request $request){
        $stream = $request->json()->all();
        $ck_otp = DB::table('otp_verify')
                    ->select('otp_verify.otp','created_at')
                    ->where('otp_verify.email', '=', $stream["email"])
                    ->orderBy('id','desc')
                    ->first();
                    
        $old_date = $stream['date'];
        $new_date=date('Y-m-d H:i:s',strtotime($old_date));
        $seconds = strtotime($new_date) - strtotime($ck_otp->created_at);
        $minutes=intval($seconds/60);
        if($ck_otp->otp==$stream["otp"]){
            if( $minutes <= 10 && $minutes >= 0){
                return response()->json(['response'=>'success','message'=>'OTP verified']);
            }else{
                return response()->json(['response'=>'failed','message'=>'OTP is expired']); 
            }
        }else{
            return response()->json(['response'=>'failed','message'=>'OTP is incorrect']); 
        }
    }
    
    public function store_update_password(Request $request){
        $stream = $request->json()->all();
        // print_r($stream);exit;
        $email = $stream["email"];
        $password = Hash::make($stream["password"]);
        
        $up_pass=DB::table('store_admin')
                    ->where('store_admin.email','=',$email)
                    ->update(['store_admin.password'=>$password]);
                    
        if($up_pass)
        {
            return response()->json(['response'=>'success','message'=>'Your Password has been changed successfully']); 
        }
        else
        {
            return response()->json(['response'=>'failed','message'=>'try again']);
        }            
    }
    
    public function store_change_password(Request $request){
        $stream = $request->json()->all();
        $password = Hash::make($stream["new_password"]);
        if($stream["new_password"] == $stream["confirm_password"]){
            $change_pass=DB::table('store_admin')
                    ->where('store_admin.id','=',$stream["userid"])
                    ->update(['store_admin.password'=>$password]);
                    
            if($change_pass)
            {
                return response()->json(['response'=>'success','message'=>'Your Password has been changed successfully']); 
            }
            else
            {
                return response()->json(['response'=>'failed','message'=>'try again later']);
            }    
            
        }else{
            return response()->json(['response'=>'failed','message'=>'New password and current password did not matched']);
        }
        
    }
    
    public function store_delete_account(Request $request){
        $stream = $request->json()->all();
        $del_acc=DB::table('store_admin')
                    ->where('store_admin.id','=',$stream["userid"])
                    ->delete();
                    
        if($del_acc){
            return response()->json(['response'=>'success','message'=>'Your account has been deleted successfully']); 
        }else{
            return response()->json(['response'=>'failed','message'=>'try again later']);
        }            
    }
    
    public function store_profile_details(Request $request){
        $stream = $request->json()->all();
        $profile_data=DB::table('store_admin')
                    ->select('store_admin.name','store_admin.email','store_admin.phone','store_admin.age','store_admin.gender','store_admin.image')
                    ->where('store_admin.id','=',$stream["userid"])
                    ->first();
        
        if($profile_data)
        {
            return response()->json(['response'=>'success' ,'user_data' =>$profile_data]); 
        }
        else
        {
            return response()->json(['response'=>'Failed ','message'=>'No data found']);
        }            
    }
    
    public function store_edit_profile_details(Request $request){
        $stream = $request->json()->all();
        
        // if($stream["image"] != '')
        // {
            // $destinationPath = "uploads/";
            // $decodedImage = base64_decode($stream["image"]);
            // $file = $destinationPath . uniqid().'.jpg';
            // // print_r($file);exit;
            // $return = file_put_contents($file, $decodedImage);
            // print_r($return);exit;
            // $workimage = preg_replace("/\w+\//", '',$file);
            // $pro['image'] = $workimage;
            
        // }
        
        $name = $stream["name"];
        $email = $stream["email"];
        $mobile = $stream["mobile"];
        $age = $stream["age"];
        $gender = $stream["gender"];
        
        $pro['name'] = $name;
        $pro['email'] = $email;
        $pro['phone'] = $mobile;
        $pro['age'] = $age;
        $pro['gender'] = $gender;
        
        $data=DB::table('store_admin')->where('store_admin.id','=',$stream["userid"])->update($pro);
        
        if($data)
        {
            return response()->json(['response'=>'success','message'=>'Profile has been updated successfully']); 
        }
        else
        {
            return response()->json(['response'=>'failed','message'=>'Try again']); 
        }
        
    }
    
    public function store_location_list(){
        $location_data=DB::table('cities')
                    ->select('cities.id','cities.city as name')
                    ->get();
        
        if($location_data)
        {
            return response()->json(['response'=>'success' ,'cities_list' =>$location_data]); 
        }
        else
        {
            return response()->json(['response'=>'Failed ','message'=>'No city found']);
        }
    }
}