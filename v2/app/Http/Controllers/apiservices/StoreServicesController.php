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
use DateTime;
use DateTimeZone;
use App\{Sendmail, Sendmessage,sendnotification,RtcTokenBuilder};
use Illuminate\Support\Facades\Crypt;

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
            date_default_timezone_set('Asia/Kolkata');
            $pro['time']=now();
            $insert = DB::table('otp_verify')->insert($pro);
            $email= $stream["email"];
            if($insert)
            {
                $subject = "Forgot Password OTP";  
                $message = "
                Hi,
                <br><br>
                Your forgot password OTP for WeSeeShop is <b>$data</b>. It is valid for 10 minutes, Don't share it with anyone.
                <br><br>
                Thanks & Regards,
                <br>
                WeSeeShop App Team
                ";
                SendMail::send($email, $subject, $message);
                return response()->json(['response'=>'success','message'=>'Otp Sent']); 
            }
            else{
                return response()->json(['response'=>'Failed','message'=>'Try again']); 
            }
        }
        
    }
    
    public function store_check_otp(Request $request){
        $stream = $request->json()->all();
        $ck_otp = DB::table('otp_verify')
                    ->select('otp_verify.otp','time')
                    ->where('otp_verify.email', '=', $stream["email"])
                    ->orderBy('id','desc')
                    ->first();
                    
        $old_date = $stream['date'];
        $new_date=date('Y-m-d H:i:s',strtotime($old_date));
        $seconds = strtotime($new_date) - strtotime($ck_otp->time);
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
                    ->select('store_admin.company_admin_id','store_admin.name','store_admin.email','store_admin.phone','store_admin.state','store_admin.city','store_admin.age','store_admin.gender','store_admin.voucher_code','store_admin.image')
                    ->where('store_admin.id','=',$stream["userid"])
                    ->first();
                    
                    
        $company_name=DB::table('company_admin')
                    ->select('company_admin.name','company_admin.country as company_country','company_admin.state as company_state','company_admin.city as company_city')
                    ->where('company_id','=',$profile_data->company_admin_id)
                    ->first();
                    
        if($profile_data)
        {
            return response()->json(['response'=>'success' ,'user_data' =>$profile_data,'company_details'=>$company_name]); 
        }
        else
        {
            return response()->json(['response'=>'Failed ','message'=>'No data found']);
        }            
    }
    
    public function store_edit_profile_details(Request $request){
        $stream = $request->json()->all();
        if($stream["image"] != '')
        {
            $file = base64_decode($stream['image']);
            $safeName = str_random(10).'.'.'png';
            $destinationPath = public_path('../uploads/');
            file_put_contents(public_path('../uploads/').$safeName, $file);
            $pro['image'] = $safeName;
        }
        else{
            $pro['image']='';
        }
        
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
        $location_data=DB::table('banner_cities')
                    ->select('banner_cities.id','banner_cities.city as name','banner_cities.image')
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
    
    public function store_update(Request $request){
        $stream = $request->json()->all();
        $uid= $stream['userid'];
        $date=date('Y-m-d');
        $data=DB::table('store_admin')->select('store_admin.store_admin_id')->where('id','=',$stream["userid"])->first();
        $store_admin_id=$data->store_admin_id;
        
        $store_update=DB::table('promo')
                    ->leftjoin('store_admin','store_admin.store_admin_id','=','promo.store_admin_id')
                    ->select('promo.id','promo.promo_name','promo.headline','promo.image','store_admin.city','promo.start_date','promo.end_date','promo.category')
                    ->where('promo.store_admin_id','=',$store_admin_id)
                    ->where('start_date', '<=', $date)
                    ->where('end_date', '>=', $date)
                    ->where('promo.status','=',1)
                    ->get();
        
        if(count($store_update)!=0)
        {
            return response()->json(['response'=>'success' ,'updates' =>$store_update]); 
        }
        else
        {
            return response()->json(['response'=>'Failed ','message'=>'No data found']);
        }
    }
    
    public function store_live_stream(Request $request){
        $stream = $request->json()->all();
        $uid= $stream['userid'];
        
        $data=DB::table('store_admin')->select('store_admin.store_admin_id')->where('id','=',$stream["userid"])->first();
        $store_admin_id=$data->store_admin_id;
        
        $store_stream=DB::table('live_shop_requests')
                    ->leftjoin('store_admin','store_admin.store_admin_id','=','live_shop_requests.store_admin_id')
                    ->leftjoin('outlets','outlets.id','=','live_shop_requests.outlet_id')
                    ->leftjoin('users','users.id','=','live_shop_requests.user_id')
                    ->leftjoin('company_admin','company_admin.company_id','=','live_shop_requests.company_id')
                    ->select('live_shop_requests.id as rsid','company_admin.name as company_name','users.id as user_id','users.name as user_name','users.image as user_prfile_pic','outlets.outlet_location','outlets.city','live_shop_requests.rating','live_shop_requests.date','live_shop_requests.time','live_shop_requests.type')
                    ->where('live_shop_requests.store_admin_id','=',$store_admin_id)
                    ->where('live_shop_requests.status','=',2)
                    ->orderBy('live_shop_requests.id','desc')
                    ->get();
                    
        foreach($store_stream as $asd){
                $prods =  DB::table('live_shop_requests')
                            ->select('time','end_time')
                            ->where('live_shop_requests.id','=',$asd->rsid)
                            ->first();
                
                $date1 = strtotime($prods->time); 
                $date2 = strtotime($prods->end_time); 
                $diff = abs($date2 - $date1); 
                $totalSecondsDiff = abs($date2 - $date1); //42600225
                $img = "duration";
                
                $hours = floor($totalSecondsDiff / 3600);
                $minutes = floor(($totalSecondsDiff / 60) % 60);
                $seconds = $totalSecondsDiff % 60;
                
                $asd->$img = $hours .' Hour ' . $minutes.' Minutes '. $seconds.' Seconds ';
                
        }            
        
        if(count($store_stream)!=0)
        {
            return response()->json(['response'=>'success' ,'live_stream' =>$store_stream]); 
        }
        else
        {
            return response()->json(['response'=>'Failed ','message'=>'No data found']);
        }
    }
    
    public function store_live_shop(Request $request){
        $stream = $request->json()->all();
        $uid= $stream['userid'];
        
        $data=DB::table('store_admin')->select('store_admin.store_admin_id')->where('id','=',$stream["userid"])->first();
        $store_admin_id=$data->store_admin_id;
        
        $store_live_shops_req=DB::table('live_shop_requests')
                    ->leftjoin('store_admin','store_admin.store_admin_id','=','live_shop_requests.store_admin_id')
                    ->leftjoin('users','users.id','=','live_shop_requests.user_id')
                    ->select('live_shop_requests.id as live_id','users.id as user_id','users.name','users.mobile','users.age','users.gender','users.image','live_shop_requests.date','live_shop_requests.time')
                    ->where('live_shop_requests.store_admin_id','=',$store_admin_id)
                    ->where('live_shop_requests.status','=',2)
                    ->orderBy('live_shop_requests.id','desc')
                    ->get();
        
        if(count($store_live_shops_req)!=0)
        {
            return response()->json(['response'=>'success' ,'live_shops_requests' =>$store_live_shops_req]); 
        }
        else
        {
            return response()->json(['response'=>'Failed ','message'=>'No requests found']);
        }
    }
    
    public function points(Request $request){
        $stream = $request->json()->all();
        $uid= $stream['userid'];
        
        $data=DB::table('store_admin')->select('store_admin.live_shops_points','store_admin.star_rating_points','store_admin.my_score','store_admin.store_admin_id','store_admin.image')->where('id','=',$uid)->first();
        $adminid=$data->store_admin_id;
        $winner_banner=DB::table('winner_banner')->select('image')->where('store_admin_id','=',$adminid)->orderBy('id','desc')->first();
        if(!empty($winner_banner)){
            $winner_banner=$winner_banner->image;
        }else{
            $winner_banner=[];
        }
        if(!empty($data))
        {
            return response()->json(['response'=>'success','profile_image'=>$data->image,'live_shop_points' =>$data->live_shops_points,'star_rating_points'=>$data->star_rating_points,'My_score'=>$data->my_score,'winner_banner'=>$winner_banner]); 
        }
        else
        {
            return response()->json(['response'=>'Failed ','message'=>'No requests found']);
        }
    }
    
    public function store_search(Request $request){
        $stream = $request->json()->all();
        $keyword = $stream["search_keyword"];
        
        
        $prod_list=DB::table('product')
                ->leftjoin('outlets','outlets.id','=','product.outlet_id')
                ->where([['product.product_name','like','%'.$keyword.'%'],['product.status','=',1]])
                ->select('product.company_id')
                ->get();
                
        foreach($prod_list as $key =>$value){
                $comidss[] = $value->company_id;
        }
        if(!empty($comidss)){
            $fetch_company =  DB::table('company_admin')
                                ->select('company_admin.company_id','company_admin.name')
                                ->whereIn('company_admin.company_id',$comidss)
                                ->orderBy('id','desc')
                                ->get()->toArray();
                                
            foreach($fetch_company as $key=>$prod){
                $price='price';
                $oprice='price_after_discount';
                $offers='offers';
                $prodd = DB::table('product')
                    ->select('product.price','product.offers')
                    ->where('product.company_id','=',$prod->company_id)
                    ->orderBy('product.id','desc')
                    ->first();
                if(empty($prodd)){
                   unset($fetch_company[$key]); 
                }else{    
                    $prod->$price = $prodd->price; 
                    $prod->$offers = $prodd->offers;
                    
                    if(empty($prodd->offers)){
                        $prod->$oprice = $prodd->price;
                    }else{
                        $prod->$oprice = ($prodd->price)-($prodd->price)*($prodd->offers)/100;
                    }
                    $prods = DB::table('product')
                        ->select('product.images')
                        ->where('product.company_id','=',$prod->company_id)
                        ->first();
                        
                    $img = "product_image";
                    $productimages = json_decode($prods->images);
                    $prod->$img = $productimages[0]; 
                }   
                    
            }
            if(count($fetch_company)!=0){        
                return response()->json(['response'=>'success' ,'company_list' =>$fetch_company]);         
            }else{
                return response()->json(['response'=>'failed' ,'message'=>'No company found']); 
            }
        }else{
            return response()->json(['response'=>'failed' ,'message'=>'No company found']); 
        }
        
    }
    
    public function send_messages_old(Request $request){
        $stream = $request->json()->all();
        date_default_timezone_set('Asia/Kolkata');
        $user_id = $stream["user_id"];
        $store_admin_id = $stream["store_admin_id"];
        $sender = $stream["sender"];
        $message = Crypt::encryptString($stream["message"]);
        
        // $dec=Crypt::decryptString('eyJpdiI6IlJBaCtkSzA2S0dBdk1oNldWSXpRdEE9PSIsInZhbHVlIjoiVUNcL0pIRkltSk96R01vZndFdHdVNXc9PSIsIm1hYyI6IjkyYTdkYmQ5YTVlMDYwZGY4ZmFkZjg0MDJlY2FhOGM2MjFjN2M0Mzc1YzI0NjI4YmI0NjgwMWQ2YmM3ZjQ1YzUifQ==');
        // print_r($dec);exit;
        
        if($stream["image"] != '')
        {
            $file = base64_decode($stream['image']);
            $safeName = str_random(10).'.'.'png';
            $destinationPath = public_path('../uploads/chat/');
            file_put_contents(public_path('../uploads/chat/').$safeName, $file);
            $pro['image'] = $safeName;
        }
        
        else{
            $pro['image']='';
        }
        
        $pro['user_id'] = $user_id;
        $pro['store_admin_id'] = $store_admin_id;
        $pro['message'] = $message;
        $pro['sender'] = $sender;
        $pro['date']=now();
        $pro['time']=date('H:i:s');
        
        $data=DB::table('user_admin_chat')->insert($pro);
        
        if($data)
        {
            return response()->json(['response'=>'success','message'=>'Message sent Successful']); 
        }
        else
        {
            return response()->json(['response'=>'failed','message'=>'Failed,Try again']); 
        }
    }
    
    public function send_messages(Request $request){
        $stream = $request->json()->all();
        date_default_timezone_set('Asia/Kolkata');
        $user_id = $stream["user_id"];
        $store_admin_id = $stream["store_admin_id"];
        $sender = $stream["sender"];
        $message = $stream["message"];
        
        if($stream['sender']=='user'){
            $fcm = DB::table('store_admin')
                    ->select('fcm_token')
                    ->where('id','=',$stream['store_admin_id'])
                    ->first();
        }else{
            $fcm = DB::table('users')
                    ->select('fcm_token')
                    ->where('id','=',$stream['user_id'])
                    ->first();
        }
        
        if(!empty($fcm->fcm_token)){
            $fcm=$fcm->fcm_token;
            $url = 'https://fcm.googleapis.com/fcm/send';
            $token= $fcm;
            $server_key = "AAAA1p67NLU:APA91bHKwGzAxKb9EQ6OXYXT6029EKHqM4ZlK0dhIvzq4EMADi-cAFK63tmfE6cptUz0zMXyyF_940kI-yx9IstTm8_zpI1OavlsCGfMi8JW7xr_fu0_OYTDeEfPRWvvymxZHIiscWWP";
            $notification = array();
            $notification['title'] =  "New Message";
            $notification['message'] =  "You have new message";
            $notification['sound'] = 'default';
            $extraNotificationData = array("message" => $notification);
            
            $fields = array(
                            'to' => $token,
                            'notification' => $notification
                            );
            $headers = array(
                            'Authorization: key='.$server_key,
                            'Content-Type: application/json'
                            );
                                    
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            $result = curl_exec($ch);
            if($result === FALSE){
                die('Curl failed: ' . curl_error($ch));
                $r = false;
            }
            $r = true;
            curl_close($ch);
        }
        if($stream["image"] != '')
        {
            $file = base64_decode($stream['image']);
            $safeName = str_random(10).'.'.'png';
            $destinationPath = public_path('../uploads/chat/');
            file_put_contents(public_path('../uploads/chat/').$safeName, $file);
            $pro['image'] = $safeName;
        }
        
        else{
            $pro['image']='';
        }
        
        $pro['user_id'] = $user_id;
        $pro['store_admin_id'] = $store_admin_id;
        $pro['message'] = $message;
        $pro['sender'] = $sender;
        $pro['date']=now();
        $pro['time']=date('H:i:s');
        
        $data=DB::table('user_admin_chat')->insert($pro);
        
        if($data)
        {
            return response()->json(['response'=>'success','message'=>'Message sent Successful']); 
        }
        else
        {
            return response()->json(['response'=>'failed','message'=>'Failed,Try again']); 
        }
    }
    
    public function get_messages(Request $request){
        $stream = $request->json()->all();
        $page=$stream['page_no'];
        if($page == 1){
            $pagel=1;
            $pageh=$page*10;
        }else{
            $pagel = ($page-1)*10+1;
            $pageh= $page*10;
        }
        
        // DB::enableQueryLog();
        $msgs = DB::table('user_admin_chat')
                    ->select('id','message','image','date','time','sender')
                    ->where('user_id','=',$stream['user_id'])
                    ->where('store_admin_id','=',$stream['store_admin_id'])
                    // ->where('id','>=',$pagel)
                    // ->where('id','<=',$pageh)
                    ->orderBy('id','desc')
                    ->get();
        // $qwe=DB::getQueryLog();
        // print_r($qwe);exit;
        if(count($msgs)!=0)
        {
            return response()->json(['response'=>'success','list'=>$msgs]); 
        }
        else
        {
            return response()->json(['response'=>'failed','message'=>'No messages found']); 
        }
    }
    
    public function get_messages_new(Request $request){
        $stream = $request->json()->all();
        $msgs = DB::table('user_admin_chat')
                    ->select('id','message','image','date','time','sender')
                    ->where('user_id','=',$stream['user_id'])
                    ->where('store_admin_id','=',$stream['store_admin_id'])
                    ->orderBy('id','desc')
                    ->Paginate(50);
                    
        if(count($msgs)!=0)
        {
            return response()->json(['response'=>'success','list'=>$msgs]); 
        }
        else
        {
            return response()->json(['response'=>'failed','message'=>'No messages found']); 
        }
    }
    
    public function initiate_call(Request $request){
        $stream = $request->json()->all();
        if($stream['initiatior']=='user'){
            $fcm = DB::table('store_admin')
                    ->select('fcm_token')
                    ->where('id','=',$stream['store_admin_id'])
                    ->first();
        }else{
            $fcm = DB::table('users')
                    ->select('fcm_token')
                    ->where('id','=',$stream['user_id'])
                    ->first();
        }
        if(!empty($fcm->fcm_token)){
            $company_id=DB::table('outlets')->select('company_id')->where('id','=',$stream['outlet_id'])->first();
            $store_admin=DB::table('store_admin')->select('store_admin_id')->where('id','=',$stream['store_admin_id'])->first();
            
            
            $store_admin_dat=DB::table('live_shop_requests')->select('live_shop_requests.status')->where('store_admin_id','=',$store_admin->store_admin_id)->orderBy('id','desc')->first();
            // if($store_admin_dat=='' || $store_admin_dat->status == 2){
                $company_data=DB::table('company_admin')->select('video_minutes','audio_minutes')->where('company_id','=',$company_id->company_id)->first();
                if($stream['type'] == '1'){
                    if($company_data->video_minutes > 0){
                        date_default_timezone_set('Asia/Kolkata');
                        
                        $appID = "e1e1173b7c6546c3bba4cb1de4b7862f";
                        $appCertificate = "d49e6e0471c24c9c8ec6cbbbd4362aec";
                        $channelName = $stream["chanel_no"];
                        $uid = 0;
                        $uidStr=$uid;
                        $role = RtcTokenBuilder::RoleAttendee;
                        $expireTimeInSeconds = 3600 ;
                        $currentTimestamp = (new DateTime("now", new DateTimeZone('UTC')))->getTimestamp();
                        $privilegeExpiredTs =  $currentTimestamp + $expireTimeInSeconds;
                        $token = RtcTokenBuilder::buildTokenWithUid($appID, $appCertificate, $channelName, $uid, $role, $privilegeExpiredTs);
                        $token = RtcTokenBuilder::buildTokenWithUserAccount($appID, $appCertificate, $channelName, $uidStr, $role, $privilegeExpiredTs);
                        
                        $user_id = $stream["user_id"];
                        $store_admin_id = $stream["store_admin_id"];
                        $chanel = $stream["chanel_no"];
                        $token = $token;
                        $type = $stream["type"];
                        $outlet_id=$stream["outlet_id"];
                        
                        $pro['user_id'] = $user_id;
                        $pro['store_admin_id'] = $store_admin->store_admin_id;
                        $pro['chanel_no'] = $chanel;
                        $pro['token'] = $token;
                        $pro['type'] = $type;
                        $pro['outlet_id']=$outlet_id;
                        $pro['company_id']=$company_id->company_id;
                        $pro['date']=now();
                        $pro['time']=date('H:i:s');
                        
                        $datas=DB::table('live_shop_requests')->insertGetId($pro);
                        $data=array('id'=>$datas,'user_id'=>$user_id,'type'=>$type,'token'=>$token,'channel'=>$chanel);
                        $fcm=$fcm->fcm_token;
                        $url = 'https://fcm.googleapis.com/fcm/send';
                        $token= $fcm;
                        $server_key = "AAAA1p67NLU:APA91bHKwGzAxKb9EQ6OXYXT6029EKHqM4ZlK0dhIvzq4EMADi-cAFK63tmfE6cptUz0zMXyyF_940kI-yx9IstTm8_zpI1OavlsCGfMi8JW7xr_fu0_OYTDeEfPRWvvymxZHIiscWWP";
                        $notification = array();
                        $notification['title'] =  "Incoming call";
                        $notification['message'] =  "You have new Incoming call";
                        $notification['sound'] = 'default';
                        $extraNotificationData = array("message" => $notification);
                        
                        $fields = array(
                                        'to' => $token,
                                        'notification' => $notification,
                                        'data' => $data 
                                        );
                        $headers = array(
                                        'Authorization: key='.$server_key,
                                        'Content-Type: application/json'
                                        );
                                                
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
                        $result = curl_exec($ch);
                        if($result === FALSE){
                            die('Curl failed: ' . curl_error($ch));
                            $r = false;
                        }
                        $r = true;
                        curl_close($ch);
                        $notificatiomn=array('title'=>$notification['title'],'body'=>$notification['message']);
                        if($data){
                             return response()->json(['response'=>'success','message'=>$notificatiomn,'data'=>$data]); 
                        }else{
                            return response()->json(['response'=>'failed','message'=>'Try again']); 
                        }
                    }else{
                        return response()->json(['response'=>'failed','message'=>'You have insufficient balance']); 
                    }
                }else{
                    if($company_data->audio_minutes > 0){
                        date_default_timezone_set('Asia/Kolkata');
                        $user_id = $stream["user_id"];
                        $store_admin_id = $stream["store_admin_id"];
                        $chanel = $stream["chanel_no"];
                        $type = $stream["type"];
                        $outlet_id=$stream["outlet_id"];
                        
                        $appID = "e1e1173b7c6546c3bba4cb1de4b7862f";
                        $appCertificate = "d49e6e0471c24c9c8ec6cbbbd4362aec";
                        $channelName = $stream["chanel_no"];
                        $uid = 0;
                        $uidStr=$uid;
                        $role = RtcTokenBuilder::RoleAttendee;
                        $expireTimeInSeconds = 3600 ;
                        $currentTimestamp = (new DateTime("now", new DateTimeZone('UTC')))->getTimestamp();
                        $privilegeExpiredTs =  $currentTimestamp + $expireTimeInSeconds;
                        $token = RtcTokenBuilder::buildTokenWithUid($appID, $appCertificate, $channelName, $uid, $role, $privilegeExpiredTs);
                        $token = RtcTokenBuilder::buildTokenWithUserAccount($appID, $appCertificate, $channelName, $uidStr, $role, $privilegeExpiredTs);
                        
                        $pro['user_id'] = $user_id;
                        $pro['store_admin_id'] = $store_admin->store_admin_id;
                        $pro['chanel_no'] = $chanel;
                        $pro['token'] = $token;
                        $pro['type'] = $type;
                        $pro['outlet_id']=$outlet_id;
                        $pro['company_id']=$company_id->company_id;
                        $pro['date']=now();
                        $pro['time']=date('H:i:s');
                        $datas=DB::table('live_shop_requests')->insertGetId($pro);
                        
                        $data=array('id'=>$datas,'user_id'=>$user_id,'type'=>$type,'token'=>$token,'channel'=>$chanel);
                        $fcm=$fcm->fcm_token;
                        $url = 'https://fcm.googleapis.com/fcm/send';
                        $token= $fcm;
                        $server_key = "AAAA1p67NLU:APA91bHKwGzAxKb9EQ6OXYXT6029EKHqM4ZlK0dhIvzq4EMADi-cAFK63tmfE6cptUz0zMXyyF_940kI-yx9IstTm8_zpI1OavlsCGfMi8JW7xr_fu0_OYTDeEfPRWvvymxZHIiscWWP";
                        $notification = array();
                        $notification['title'] =  "Incoming call";
                        $notification['message'] =  "You have new Incoming call";
                        $notification['sound'] = 'default';
                        $extraNotificationData = array("message" => $notification);
                        
                        $fields = array(
                                        'to' => $token,
                                        'notification' => $notification,
                                        'data' => $data 
                                        );
                        $headers = array(
                                        'Authorization: key='.$server_key,
                                        'Content-Type: application/json'
                                        );
                                                
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
                        $result = curl_exec($ch);
                        if($result === FALSE){
                            die('Curl failed: ' . curl_error($ch));
                            $r = false;
                        }
                        $r = true;
                        curl_close($ch);
                        $notificatiomn=array('title'=>$notification['title'],'body'=>$notification['message']);
                        if($data){
                            return response()->json(['response'=>'success','message'=>$notificatiomn,'data'=>$data]); 
                        }else{
                            return response()->json(['response'=>'failed','message'=>'Try again']); 
                        }
                    }else{
                        return response()->json(['response'=>'failed','message'=>'You have insufficient balance']); 
                    }
                }
            //}
            // elseif($store_admin_dat->status == 1 && $store_admin_dat!=''){
            //     return response()->json(['response'=>'failed','message'=>'Store admin is busy']); 
            // }
        }
        else{
            return response()->json(['response'=>'failed','message'=>'Try again,Fcm token required']); 
        }
    }
    
    public function update_call_status(Request $request){
        $stream = $request->json()->all();
        
        $status = $stream["status"];
        date_default_timezone_set('Asia/Kolkata');
        $time = date('H:i:s');
        
        $pro['status'] = $status;
        $pro['end_time'] = $time;
        
        $data=DB::table('live_shop_requests')->where('live_shop_requests.id','=',$stream["id"])->update($pro);
        
        if($data)
        {
            return response()->json(['response'=>'success','message'=>'Updated successfully']); 
        }
        else
        {
            return response()->json(['response'=>'failed','message'=>'Try again']); 
        }
    }
    
    public function update_fcm_store(Request $request){
        $stream = $request->json()->all();
        $fcm_token = (!empty($stream["fcm_token"])) ? $stream["fcm_token"]: '';
        
        $affected = DB::table('store_admin')
                    ->where('id','=',$stream["user_id"])
                    ->update(['fcm_token'=>$fcm_token]);
        
        if($affected){
            return response()->json(['response'=>'success','message'=>'Fcm token updated success']); 
        }else{
            return response()->json(['response'=>'failed','message'=>'Try again']); 
        }
    }
}