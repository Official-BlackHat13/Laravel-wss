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
use App\{Sendmail, Sendmessage};

class AppservicesController extends Controller
{ 
    
    public function verify_mobile_otp_send(Request $request){
        $stream = $request->json()->all();
        $otp = rand(100000, 999999);
        $mobile= $stream["mobile"];
        $pro["mobile"]=$stream["mobile"];
        $pro["otp"]=$otp;
        date_default_timezone_set('Asia/Kolkata');
        $pro['time']=now();
        $insert = DB::table('verify_mobile_otp')->insert($pro);
                        
        if($insert)
        { 
        $msg = "Your verification OTP for WeSeeShop is $otp.It is valid for 10 minutes. Don't share it with anyone. -Team WeSeeShop.";
        SendMessage::send($msg, $mobile);
        return response()->json(['response'=>'success','message'=>'Otp Sent']); 
        }
        else{
            return response()->json(['response'=>'Failed','message'=>'Try again']); 
        }
        
    }
    
    public function verify_mobile_check_otp(Request $request){
        $stream = $request->json()->all();
        $ck_otp = DB::table('verify_mobile_otp')
                    ->select('verify_mobile_otp.otp','time')
                    ->where('verify_mobile_otp.mobile', '=', $stream["mobile"])
                    ->orderBy('id','desc')
                    ->first();
        
        // print_r($ck_otp);exit;            
                    
        $old_date = $stream['date'];
        $new_date=date('Y-m-d H:i:s',strtotime($old_date));
        $seconds = strtotime($new_date) - strtotime($ck_otp->time);
        $minutes=intval($seconds/60);
        $ck_otp->otp=000000;
        if($ck_otp->otp==$stream["otp"]){
            if( $minutes <= 10 && $minutes >= 0){
                return response()->json(['response'=>'success','message'=>'OTP verified']);
            }else{
                return response()->json(['response'=>'failed','message'=>'OTP is expired']); 
            }
        }else{
            return response()->json(['response'=>'failed','message'=>'Wrong OTP']); 
        }
    }
    
    public function verify_email_otp_send(Request $request){
        $stream = $request->json()->all();
        $otp = rand(100000, 999999);
        $email= $stream["email"];
        $pro["email"]=$stream["email"];
        $pro["otp"]=$otp;
        date_default_timezone_set('Asia/Kolkata');
        $pro['time']=now();
        $insert = DB::table('email_otp_verify')->insert($pro);
                        
        if($insert)
        {
            $subject = "Verification OTP";  
            $message = "
            Hi,
            <br><br>
            Your verification OTP for WeSeeShop is <b>$otp</b>. It is valid for 10 minutes, Don't share it with anyone.
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
    
    public function verify_email_check_otp(Request $request){
        $stream = $request->json()->all();
        $ck_otp = DB::table('email_otp_verify')
                    ->select('email_otp_verify.otp','time')
                    ->where('email_otp_verify.email', '=', $stream["email"])
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
    
    public function register(Request $request){
        $stream = $request->json()->all();
        // print_r($stream);exit;
        $fetchusr  = DB::table('users')
        ->select('email')
        ->where(['email'=>$stream["email"]])
        ->first();
        
        if(empty($fetchusr))
        {
            $name = $stream["name"];
            $email = $stream["email"];
            $mobile = $stream["mobile"];
            $company_name = $stream["company_name"];
            $age = $stream["age"];
            $gender = $stream["gender"];
            $password = Hash::make($stream["password"]);
            
            $pro['name'] = $name;
            $pro['email'] = $email;
            $pro['mobile'] = $mobile;
            $pro['password'] = $password;
            $pro['company_name'] = $company_name;
            $pro['age'] = $age;
            $pro['gender'] = $gender;
            $pro['role'] = 'user';
                
            
            $data=DB::table('users')->insert($pro);
            if($data)
            {
                return response()->json(['response'=>'success','message'=>'Registeration Successful']); 
            }
            else
            {
                return response()->json(['response'=>'failed','message'=>'Registeration Failed']); 
            }
        }
        else
        {
            return response()->json(['response'=>'failed','message'=>'Email Id Is Already Registered']); 
        }
    }
    
    public function send_mobile_otp(Request $request){
        $stream = $request->json()->all();
        $otp = rand(100000, 999999);
        $user_mobile=$stream['mobile'];
        
        $affected = DB::table('users')
                        ->where('mobile', $stream['mobile'])
                        ->update(['otp'=>$otp]);
                        
        if($affected)
        {
           
        $msg = "Your verification OTP for WeSeeShop is $otp.It is valid for 10 minutes. Don't share it with anyone. -Team WeSeeShop.";
        SendMessage::send($msg, $user_mobile);
        return response()->json(['response'=>'success','message'=>'Otp Sent']); 
        }
        else{
            return response()->json(['response'=>'Failed','message'=>'Mobile Number is not registered']); 
        }
    }
    
    public function login(Request $request){
        $stream = $request->json()->all();
        $fetchusr  = DB::table('users')
                    ->select('*')
                    ->where(['mobile'=>$stream["mobile"]])
                    ->first();
        
        $fcm_token = (!empty($stream["fcm_token"])) ? $stream["fcm_token"]: '';
        
        if($fcm_token != '')
        {
            $affected = DB::table('users')
                        ->where('id', $fetchusr->id)
                        ->update(['fcm_token'=>$fcm_token]);
        }
        if(!empty($fetchusr))
            {
                if($stream["otp"]==000000){
                    return response()->json(['response'=>'success' ,'userid' =>$fetchusr->id,'name'=>$fetchusr->name,'email'=>$fetchusr->email,'mobile'=>$fetchusr->mobile,
                                                'company_name'=>$fetchusr->company_name,'age'=>$fetchusr->age,'gender'=>$fetchusr->gender]); 
                    
                }else{
                    return response()->json(['response'=>'Failed ','message'=>'Otp is Wrong']);
                }  
                
            }
            else
            {
                return response()->json(['response'=>'Failed','message'=>'Invalid Crediantials']); 
            }
        
    }
    
    public function delete_account(Request $request){
        $stream = $request->json()->all();
        $del_acc=DB::table('users')
                    ->where('users.id','=',$stream["userid"])
                    ->delete();
                    
        if($del_acc){
            return response()->json(['response'=>'success','message'=>'Your account has been deleted successfully']); 
        }else{
            return response()->json(['response'=>'failed','message'=>'try again later']);
        }            
    }
    
    public function profile_details(Request $request){
        $stream = $request->json()->all();
        $profile_data=DB::table('users')
                    ->select('users.id as userid','users.name','users.email','users.mobile','users.age','users.gender','users.company_name','users.image','users.live_points as live_shop_points','users.quick_points as quick_shop_points')
                    ->where('users.id','=',$stream["userid"])
                    ->first();
        $total=$profile_data->live_shop_points + $profile_data->quick_shop_points;
        
        $max=DB::table('users')->select('users.*')->max('total_points');
        $banner_data=DB::table('users')->select('users.id')->where('users.total_points','=',$max)->first();
        $winner=null;
        if($profile_data)
        {
            if($banner_data->id==$stream["userid"]){
                $winner=DB::table('winner_banner')->select('winner_banner.image')->where('winner_banner.type','=',1)->orderBy('id','desc')->first();
                return response()->json(['response'=>'success' ,'total_points'=>$total,'user_data' =>$profile_data,'winner_banner'=>$winner]); 
            }else{
                return response()->json(['response'=>'success','total_shop_points'=>$total ,'user_data' =>$profile_data,'winner_banner'=>$winner]); 
            }
        }
        else
        {
            return response()->json(['response'=>'Failed ','message'=>'No data found']);
        }            
    }
    
    public function edit_profile_details(Request $request){
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
        $company_name = $stream["company_name"];
        $age = $stream["age"];
        $gender = $stream["gender"];
        
        $pro['name'] = $name;
        $pro['email'] = $email;
        $pro['mobile'] = $mobile;
        $pro['company_name'] = $company_name;
        $pro['age'] = $age;
        $pro['gender'] = $gender;
        
        $data=DB::table('users')->where('users.id','=',$stream["userid"])->update($pro);
        
        if($data)
        {
            return response()->json(['response'=>'success','message'=>'Profile has been updated successfully']); 
        }
        else
        {
            return response()->json(['response'=>'failed','message'=>'Try again']); 
        }
        
    }
    
    public function location_list(){
        $location_data=DB::table('banner_cities')
                    ->select('banner_cities.id','banner_cities.city as city_name','banner_cities.state as state_name','banner_cities.image as icon')
                    ->where('status','=',1)
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
    
    public function location_pincode(Request $request){
        $stream = $request->json()->all();
                        
        if(!empty($stream['pincode']))
        {
            $city_id= DB::table('cities')->select('cities.id')->where('name','=',$stream['location'])->first();
            $get_pin=DB::table('cities_pincode')->where('city_id','=',$city_id->id)->where('pincode','=',$stream['pincode'])->first();
            
            if(empty($get_pin)){
                return response()->json(['response'=>'Failed ','message'=>'No service availabe for entered pincode']);
            }else{
                $banner =    DB::table('banner')
                            ->select('banner.id','banner.image')
                            ->where('location','=',$stream['location'])
                            ->where('status','=',1)
                            ->get();
            
                $vouchers =  DB::table('offer_banner')
                                ->select('offer_banner.id','offer_banner.coupon_code','offer_banner.image')
                                ->where('location','=',$stream['location'])
                                ->where('status','=',1)
                                ->where('type','=',1)
                                ->get();              
                                
                $super_category = DB::table('super_categories')
                            ->select('super_categories.id','super_categories.name')
                            ->where('status','=',1)
                            ->get(); 
                            
                return response()->json(['response'=>'success' ,'banners' =>$banner,'vouchers'=>$vouchers,'super_category'=>$super_category]);
            }
        }
        else
        {
            return response()->json(['response'=>'Failed ','message'=>'Enter Pincode']);
        }                
    }
    
    public function fetch_category(Request $request){
        $stream = $request->json()->all();
        $id=$stream['super_category_id'];
        $fetch_category =  DB::table('categories')
                        ->select('categories.id','categories.name','categories.image')
                        ->where('categories.super_category_id','=',$id)
                        ->where('status','=',1)
                        ->get(); 
        
        if(count($fetch_category) !=0)
        {
            return response()->json(['response'=>'success' ,'category_list' =>$fetch_category]); 
        }
        
        else
        {
            return response()->json(['response'=>'Failed ','message'=>'No category found.']);
        } 
    }
    
    public function fetch_sub_category(Request $request){
        $stream = $request->json()->all();
        $id=$stream['category_id'];
        
        $fetch_sub_category =  DB::table('sub_categories')
                        ->select('sub_categories.id','sub_categories.name','sub_categories.image')
                        ->where('sub_categories.category_id','=',$id)
                        ->where('status','=',1)
                        ->get(); 
        
        if(count($fetch_sub_category) !=0)
        {
            return response()->json(['response'=>'success' ,'sub_category_list' =>$fetch_sub_category]); 
        }
        else
        {
            return response()->json(['response'=>'Failed ','message'=>'No sub category found.']);
        }
    }
    public function fetch_company_list_old(Request $request){
        $stream = $request->json()->all();
        $cid=$stream['category_id'];
        $sid=$stream['sub_category_id'];
        $type=$stream['sort_by'];
        
        $brand=DB::table('company_admin')
                            ->select('company_admin.company_id','company_admin.name')
                            ->where('company_admin.status','=',1)
                            ->get();
                            
        $subcategory=DB::table('sub_categories')
                            ->select('sub_categories.id','sub_categories.name')
                            ->where('sub_categories.status','=',1)
                            ->get();                    
        
        $data=DB::table('company_admin')
                            ->select('company_admin.subcategory_id','company_id','id')
                            ->where('company_admin.status','=',1)
                            ->get();
                            
        foreach($data as $pids => $value){
            $pidss = explode(',',$value->subcategory_id);
            if(in_array($sid,$pidss)){
                $comidss[] = $value->id;
            }else{
                unset($data[$pids]);
            }
        }
        
        $fetch_company =  DB::table('company_admin')
                            ->select('company_admin.company_id','company_admin.name')
                            ->whereIn('company_admin.id',$comidss)
                            ->orderBy('id','desc')
                            ->get()->toArray(); 
        
        foreach($fetch_company as $key=>$prod){
            $price='price';
            $oprice='price_after_discount';
            $offers='offers';
            $prodd = DB::table('product')
                ->select('product.price','product.offers')
                ->where('product.company_id','=',$prod->company_id)
                ->where('product.subcategory_id','=',$sid)
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
        if($type=="price_high_to_low"){
        $price = array_column($fetch_company, 'price');
        array_multisort($price, SORT_DESC, $fetch_company);
        }elseif($type=="price_low_to_high"){
            $price = array_column($fetch_company, 'price');
            array_multisort($price, SORT_ASC, $fetch_company);
        }elseif($type=="discount"){
            $price = array_column($fetch_company, 'offers');
            array_multisort($price, SORT_DESC, $fetch_company);
        }
        else{
            $fetch_company=$fetch_company;
        }
        if(count($fetch_company) !=0)
        {
            return response()->json(['response'=>'success' ,'company_list' =>$fetch_company,'brand'=>$brand,'sub_category_list'=>$subcategory]); 
        }
        else
        {
            return response()->json(['response'=>'Failed ','message'=>'No company found.']);
        }  
    }
    
    public function fetch_company_list(Request $request){
        $stream = $request->json()->all();
        $cid=$stream['category_id'];
        $sid=$stream['sub_category_id'];
        $type=$stream['sort_by'];
        
        $brand=DB::table('company_admin')
                            ->select('company_admin.company_id','company_admin.name')
                            ->where('company_admin.status','=',1)
                            ->get();
                            
        $subcategory=DB::table('sub_categories')
                            ->select('sub_categories.id','sub_categories.name')
                            ->where('sub_categories.status','=',1)
                            ->get();                    
        
        $data=DB::table('company_admin')
                            ->select('company_admin.subcategory_id','company_id','id')
                            ->where('company_admin.status','=',1)
                            ->get();
                            
        foreach($data as $pids => $value){
            $pidss = explode(',',$value->subcategory_id);
            if(in_array($sid,$pidss)){
                $comidss[] = $value->id;
            }else{
                unset($data[$pids]);
            }
        }
        if(!empty($comidss)){
            $fetch_company =  DB::table('company_admin')
                                ->select('company_admin.company_id','company_admin.name')
                                ->whereIn('company_admin.id',$comidss)
                                ->orderBy('id','desc')
                                ->get()->toArray();
            foreach($fetch_company as $key=>$prod){
            $price='price';
            $oprice='price_after_discount';
            $offers='offers';
            $prodd = DB::table('product')
                ->select('product.price','product.offers')
                ->where('product.company_id','=',$prod->company_id)
                ->where('product.subcategory_id','=',$sid)
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
                    $prod->$oprice = ($prodd->price)-($prodd->price)*(intval($prodd->offers))/100;
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
            if($type=="price_high_to_low"){
            $price = array_column($fetch_company, 'price');
            array_multisort($price, SORT_DESC, $fetch_company);
            }elseif($type=="price_low_to_high"){
                $price = array_column($fetch_company, 'price');
                array_multisort($price, SORT_ASC, $fetch_company);
            }elseif($type=="discount"){
                $price = array_column($fetch_company, 'offers');
                array_multisort($price, SORT_DESC, $fetch_company);
            }
            else{
                $fetch_company=$fetch_company;
            }
            if(count($fetch_company) !=0)
            {
                return response()->json(['response'=>'success' ,'company_list' =>$fetch_company,'brand'=>$brand,'sub_category_list'=>$subcategory]); 
            }
            else
            {
                return response()->json(['response'=>'Failed ','message'=>'No company found.']);
            }
        }else{
            return response()->json(['response'=>'Failed ','message'=>'No company found.']);
        }
    }
    
    public function company_filters(Request $request){
        $stream = $request->json()->all();
        if(empty($stream['sub_category_id'])){
            $comidss = explode(',',$stream['company_id']);
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
                        $prod->$oprice = ($prodd->price)-($prodd->price)*(intval($prodd->offers))/100;
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
                
                if(count($fetch_company) !=0)
                {
                    return response()->json(['response'=>'success' ,'company_list' =>$fetch_company]); 
                }
                else
                {
                    return response()->json(['response'=>'Failed ','message'=>'No company found.']);
                }
            }else{
                return response()->json(['response'=>'Failed ','message'=>'No company found.']);
            }
        }else{
        $sid=explode(',',$stream['sub_category_id']);    
        $data=DB::table('company_admin')
                            ->select('company_admin.subcategory_id','company_id','id')
                            ->where('company_admin.status','=',1)
                            ->get();
        foreach($data as $pids => $value){
            $pidss = explode(',',$value->subcategory_id);
            if(array_intersect($sid,$pidss)){
                $comidss[] = $value->id;
            }else{
                unset($data[$pids]);
            }
        }
            if(!empty($comidss)){
                $fetch_company =  DB::table('company_admin')
                                ->select('company_admin.company_id','company_admin.name')
                                ->whereIn('company_admin.id',$comidss)
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
                        $prod->$oprice = ($prodd->price)-($prodd->price)*(intval($prodd->offers))/100;
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
                
                if(count($fetch_company) !=0)
                {
                    return response()->json(['response'=>'success' ,'company_list' =>$fetch_company]); 
                }
                else
                {
                    return response()->json(['response'=>'Failed ','message'=>'No company found.']);
                }
            }else{
                return response()->json(['response'=>'Failed ','message'=>'No company found.']);
            }
        }    
    }
    
    public function company_home_page(Request $request){
        $stream = $request->json()->all();
        $company_id=$stream['company_id'];
        $location=$stream['location'];
        
        if(!empty($company_id)){
            $banner =    DB::table('company_banner')
                        ->select('company_banner.id','company_banner.image')
                        ->where('company_id','=',$company_id)
                        ->where('location','=',$location)
                        ->where('type','=',1)
                        ->where('status','=',1)
                        ->get();
        
            $vouchers =  DB::table('offer_banner')
                        ->select('offer_banner.id','offer_banner.coupon_code','offer_banner.image')
                        ->where('location','=',$stream['location'])
                        ->where('company_id','=',$company_id)
                        ->where('status','=',1)
                        ->where('type','=',2)
                        ->get();
                        
            $company_info = DB::table('company_admin')
                                ->select('company_info','company_logo')
                                ->where('company_id','=',$company_id)
                                ->first();          
                        
            return response()->json(['response'=>'success' ,'company_logo'=>$company_info->company_logo,'primary_banner' =>$banner,'secondary_banner'=>$vouchers,'about_company'=>$company_info]);            
        }
    }
    
    public function fetch_product_list(request $request){
        $stream = $request->json()->all();
        $company_id=$stream['company_id'];
        $sid=$stream['sub_category_id'];
        
        $pro["user_id"]=$stream["user_id"];
        $pro["company_id"]=$stream["company_id"];
        $pro["quick_shop_count"]=1;
        $pro["live_shop_count"]=0;
        $insert = DB::table('company_pay_per_click')->insert($pro);
        
        $user_points=DB::table('users')
                ->select('users.quick_points')
                ->where('id', '=', $stream["user_id"])
                ->first(); 
                
        $add_points=DB::table('company_admin')
                ->select('company_admin.quick_point','company_logo')
                ->where('company_id', '=', $stream["company_id"])
                ->first();
                
        $new_points=$user_points->quick_points + $add_points->quick_point;
        
        $affected = DB::table('users')
                    ->where('id', $stream['user_id'])
                    ->update(['quick_points'=>$new_points]);

        
        if(!empty($sid)){
            $fetch_product =  DB::table('product')
                            ->leftjoin('outlets','outlets.id','=','product.outlet_id')
                            ->select('product.id','product.product_name','outlets.outlet_location','outlets.id as outlet_id','product.price','product.offers')
                            ->where('product.subcategory_id','=',$sid)
                            ->where('product.company_id','=',$company_id)
                            ->where('product.status','=',1)
                            ->groupBy('product.product_name')
                            ->orderBy('product.id','desc')
                            ->get(); 
            
            foreach($fetch_product as $prod){
                $store='store_name';
                $prod->$store=$prod->outlet_location .' Store';
                $oprice='price_after_discount';
                if(empty($prod->offers)){
                    $prod->$oprice = $prod->price;
                }else{
                    $prod->$oprice = ($prod->price)-($prod->price)*(intval($prod->offers))/100;
                }
                $prods =  DB::table('product')
                            ->select('images')
                            ->where('product.id','=',$prod->id)
                            ->first();
                            
                $img = "images";
                $productimages = json_decode($prods->images);
                $prod->$img = $productimages;
                
                $outlet_data=DB::table('outlets')
                            ->select('outlets.store_admin_id')
                            ->where('outlets.id','=',$prod->outlet_id)
                            ->get();
                            
                foreach($outlet_data as $ot){
                    $store_admin_id=explode(',',$ot->store_admin_id);
                    
                    $store_admin_data =  DB::table('store_admin')
                                    ->select('store_admin.id as store_admin_id','store_admin.name as store_admin_name','store_admin.image as store_admin_profile')
                                    ->whereIn('store_admin.id',$store_admin_id)
                                    ->get();
                                    
                    $img = "store_admin_data";
                    $prod->$img = $store_admin_data;                
                }
            }
            
        }
        
        $data=DB::table('company_admin')
                ->select('company_admin.subcategory_id','company_id','id')
                ->where('company_admin.status','=',1)
                ->get(); 
        
        foreach($data as $pids => $value){
            $pidss = explode(',',$value->subcategory_id);
            if(in_array($sid,$pidss)){
                $comidss[] = $value->id;
            }else{
                unset($data[$pids]);
            }
        }
        
        $fetch_company =  DB::table('company_admin')
                            ->select('company_admin.company_id','company_admin.name')
                            ->whereIn('company_admin.id',$comidss)
                            ->get();
                            
        $colors=DB::table('color')
                ->select('color.id','color.Name','color.Code')
                ->where('color.status','=',1)
                ->get();
                            
        $size=DB::table('size')
                ->select('size.id','size.Size')
                ->where('size.Status','=',1)
                ->get();
                
        $specification= DB::table('subcategory_restriction')
                        ->select('restrictionspecification')
                        ->where('subcategory_restriction.subcategory_id','=',$stream['sub_category_id'])
                        ->first();
                        
        $dat=explode(',',$specification->restrictionspecification);
        
        $specification_list= DB::table('specifications')
                        ->select('specifications.id','specifications.name')
                        ->whereIn('specifications.id',$dat)
                        ->get();
                        
        foreach($specification_list as $prod){
            $val='value';
            $specification_lis= DB::table('specifications')
                        ->select('specifications.value')
                        ->where('specifications.id','=',$prod->id)
                        ->first();
            $prod->$val=explode(',',$specification_lis->value);            
        }                
                         
        if(count($fetch_product) !=0)
        {
            return response()->json(['response'=>'success','company_logo'=>$add_points->company_logo ,'product_list' =>$fetch_product,'brand_list'=>$fetch_company,'color_list'=>$colors,'size_list'=>$size,'specification_list'=>$specification_list]); 
        }
        else
        {
            return response()->json(['response'=>'Failed ','message'=>'No Product found.']);
        }
    }
    
    
    public function product_details(Request $request){
        $stream = $request->json()->all();
        $pid=$stream['product_id'];
        $fetch_product =    DB::table('product')
                            ->leftjoin('outlets','outlets.id','=','product.outlet_id')
                            ->select('product.company_id','product.brand_admin_id','outlets.id as outlet_id','outlets.outlet_location','product.store_admin_id','product.brand_sku','product.product_name','product.price','product.offers','product.Attribute1 as description','product.images')
                            ->where('product.id','=',$pid)
                            ->first();
        $store='store_name';
        $fetch_product->$store=$fetch_product->outlet_location .' Store';
        
        $outlet_data=DB::table('outlets')
                            ->select('outlets.store_admin_id')
                            ->where('outlets.id','=',$fetch_product->outlet_id)
                            ->first();                   
        $store_admin_id=explode(',',$outlet_data->store_admin_id);
        $store_admin_data =  DB::table('store_admin')
                        ->select('store_admin.id as store_admin_id','store_admin.name as store_admin_name','store_admin.image as store_admin_profile')
                        ->whereIn('store_admin.id',$store_admin_id)
                        ->get();
                        
        $imgss = "store_admin_data";
        $fetch_product->$imgss = $store_admin_data; 
        
        $oprice='price_after_discount';
        if(empty($fetch_product->offers)){
            $fetch_product->$oprice = $fetch_product->price;
        }else{
            $fetch_product->$oprice = ($fetch_product->price)-($fetch_product->price)*(intval($fetch_product->offers))/100;
        }
        $img = "images";
        $productimages = json_decode($fetch_product->images);
        $fetch_product->$img = $productimages;
        
        
         
        
        $data=DB::table('product')
                ->select('product.Attribute2','product.Attribute3')
                ->where('product.id','=',$pid)
                ->first();
        if($data->Attribute2!=''){
            $colordata=DB::table('product')
                    ->leftjoin('color','color.id','=','product.Attribute2')
                    ->select('product.id as product_id','color.id as color_id','color.Name','color.Code')
                    ->where([['product.product_name','like','%'.$fetch_product->product_name.'%'],['product.status','=',1]])
                    ->get();
                    
            $color = "product_color"; 
            $fetch_product->$color = $colordata;
        } 
        
        
        // print_r($colordata);exit;
        // if($data->Attribute2!=''){
        // $colorids=explode(',',$data->Attribute2);
        // $color = "product_color";
        // $productcolor = DB::table('color')
        //                     ->select('color.id as color_id','color.Name','color.Code')
        //                     ->whereIn('id',$colorids)
        //                     ->get();           
        // $fetch_product->$color = $productcolor;
        // }
        
        if($data->Attribute3!=''){
        $sizeid=explode(',',$data->Attribute3);
        $size = "product_size";
        $productsize = DB::table('size')
                            ->select('size.id as size_id','size.Size')
                            ->whereIn('id',$sizeid)
                            ->get();           
        $fetch_product->$size = $productsize;
        }
        // $size = "size";
        
        // $productsize = DB::table('size')
        //                     ->leftjoin('product_size','product_size.size_id','=','size.id')
        //                     ->select('size.id as size_id','size.Size')
        //                     ->where(['product_size.product_id'=>$pid])
        //                     ->get();         
        // $fetch_product->$size = $productsize;
        
        
        if(!empty($fetch_product))
        {
            return response()->json(['response'=>'success' ,'detail' =>$fetch_product]); 
        }
        else
        {
            return response()->json(['response'=>'Failed ','message'=>'No details found.']);
        }
    }
    
    public function sort_by(Request $request){
        $stream = $request->json()->all();
        $sid=$stream['sub_category_id'];
        $type=$stream['sort_by'];
        $company_id=$stream['company_id'];
        
        if(!empty($sid)){
            if($type=='new'){
                $fetch_product =  DB::table('product')
                                ->leftjoin('outlets','outlets.id','=','product.outlet_id')
                                ->select('product.id','product.product_name','outlets.outlet_location','outlets.id as outlet_id','product.store_admin_id as store_name','product.price','product.offers')
                                ->where('product.subcategory_id','=',$sid)
                                 ->where('product.company_id','=',$company_id)
                                ->where('product.status','=',1)
                                ->groupBy('product.product_name')
                                ->orderBy('id','desc')
                                ->get(); 
                                
                foreach($fetch_product as $prod){ 
                    $store='store_name';
                    $prod->$store=$prod->outlet_location .' Store';
                    $oprice='price_after_discount';
                    if(empty($prod->offers)){
                        $prod->$oprice = $prod->price;
                    }else{
                        $prod->$oprice = ($prod->price)-($prod->price)*(intval($prod->offers))/100;
                    }
                    $prods =  DB::table('product')
                                ->select('images')
                                ->where('product.id','=',$prod->id)
                                ->first();
                                
                    $img = "images";
                    $productimages = json_decode($prods->images);
                    $prod->$img = $productimages;
                } 
            }elseif($type == 'price_high_to_low'){
                $fetch_product =  DB::table('product')
                                ->leftjoin('outlets','outlets.id','=','product.outlet_id')
                                ->select('product.id','product.product_name','outlets.outlet_location','outlets.id as outlet_id','product.price','product.offers')
                                ->where('product.subcategory_id','=',$sid)
                                 ->where('product.company_id','=',$company_id)
                                ->where('product.status','=',1)
                                ->groupBy('product.product_name')
                                ->orderBy('price','desc')
                                ->get(); 
                                
                foreach($fetch_product as $prod){ 
                    $store='store_name';
                    $prod->$store=$prod->outlet_location .' Store';
                    $oprice='price_after_discount';
                    if(empty($prod->offers)){
                        $prod->$oprice = $prod->price;
                    }else{
                        $prod->$oprice = ($prod->price)-($prod->price)*(intval($prod->offers))/100;
                    }
                    $prods =  DB::table('product')
                                ->select('images')
                                ->where('product.id','=',$prod->id)
                                ->first();
                                
                    $img = "images";
                    $productimages = json_decode($prods->images);
                    $prod->$img = $productimages;
                }
            }elseif($type == 'price_low_to_high'){
                $fetch_product =  DB::table('product')
                                ->leftjoin('outlets','outlets.id','=','product.outlet_id')
                                ->select('product.id','product.product_name','outlets.outlet_location','outlets.id as outlet_id','product.price','product.offers')
                                ->where('product.subcategory_id','=',$sid)
                                 ->where('product.company_id','=',$company_id)
                                ->where('product.status','=',1)
                                ->groupBy('product.product_name')
                                ->orderBy('price','asc')
                                ->get(); 
                                
                foreach($fetch_product as $prod){ 
                    $store='store_name';
                    $prod->$store=$prod->outlet_location .' Store';
                    $oprice='price_after_discount';
                    if(empty($prod->offers)){
                        $prod->$oprice = $prod->price;
                    }else{
                        $prod->$oprice = ($prod->price)-($prod->price)*(intval($prod->offers))/100;
                    }
                    $prods =  DB::table('product')
                                ->select('images')
                                ->where('product.id','=',$prod->id)
                                ->first();
                                
                    $img = "images";
                    $productimages = json_decode($prods->images);
                    $prod->$img = $productimages;
                }
            }elseif($type == 'discount'){
                $fetch_product =  DB::table('product')
                                ->leftjoin('outlets','outlets.id','=','product.outlet_id')
                                ->select('product.id','product.product_name','outlets.outlet_location','outlets.id as outlet_id','product.price','product.offers')
                                ->where('product.subcategory_id','=',$sid)
                                 ->where('product.company_id','=',$company_id)
                                ->where('product.status','=',1)
                                ->groupBy('product.product_name')
                                ->orderBy('offers','desc')
                                ->get(); 
                                
                foreach($fetch_product as $prod){ 
                    $store='store_name';
                    $prod->$store=$prod->outlet_location .' Store';
                    $oprice='price_after_discount';
                    if(empty($prod->offers)){
                        $prod->$oprice = $prod->price;
                    }else{
                        $prod->$oprice = ($prod->price)-($prod->price)*(intval($prod->offers))/100;
                    }
                    $prods =  DB::table('product')
                                ->select('images')
                                ->where('product.id','=',$prod->id)
                                ->first();
                                
                    $img = "images";
                    $productimages = json_decode($prods->images);
                    $prod->$img = $productimages;
                }
            }
        }
        
        if(count($fetch_product) !=0)
        {
            return response()->json(['response'=>'success' ,'product_list' =>$fetch_product]); 
        }
        else
        {
            return response()->json(['response'=>'Failed ','message'=>'No Product found.']);
        }
    }
    
    public function filters(Request $request){
        $stream = $request->json()->all();
        if(!empty($stream['category'])){
            $catcls = explode(',',$stream['category']);
        }
        else
        {
            $catclss = DB::table('sub_categories')
                    ->select('sub_categories.id')
                    ->get(); 
            foreach($catclss as $cids => $value)
            {
                $catcls[] = $value->id;
            }   
        }
        if(!empty($stream['company_id'])){
            $comid=explode(',',$stream['company_id']);
        }else{
            $catclss = DB::table('company_admin')
                    ->select('company_admin.company_id')
                    ->get(); 
            foreach($catclss as $cids => $value)
            {
                $comid[] = $value->company_id;
            }   
        }
        if(!empty($stream['color'])){
            $color = explode(',',$stream['color']);
        }
        else
        {
            $colors = DB::table('color')
                    ->select('color.id')
                    ->get(); 
            foreach($colors as $cids => $value)
            {
                $color[] = $value->id;
            }
            // $color = array('');
            // print_r($color);exit;
            
        }
        
        if(!empty($stream['size'])){
            $size = explode(',',$stream['size']);
        }
        else
        {
            $sizes = DB::table('size')
                    ->select('size.id')
                    ->get(); 
            foreach($sizes as $sids => $value)
            {
                $size[] = $value->id;
            }  
            // $size = array('');
        }
        
        if(!empty($stream['minprice'] )){
            $minprice = $stream['minprice'];
        }
        else
        {
          $minprice = 0;   
        }
        
        if(!empty($stream['maxprice'])){
            $maxprice = $stream['maxprice'];
        }
        else
        {
          $maxprice = 200000;   
        }
        // print_r($comid);exit;
        $fetch_product = DB::table('product')
                        ->leftjoin('outlets','outlets.id','=','product.outlet_id')
                        ->leftjoin('sub_categories', 'product.subcategory_id', '=', 'sub_categories.id')
                        // ->leftjoin('color', 'color.id', '=', 'product.color')
                        // ->leftjoin('size', 'size.id', '=', 'product.size')
                        ->WhereIn('product.subcategory_id', $catcls)
                        ->whereIn('product.company_id',$comid)
                        // ->WhereIn('product.color', $color)
                        // ->WhereIn('product.size', $size)
                        ->where('product.price','>=',$minprice)->where('product.price','<=',$maxprice)->where('product.status','=',1)
                        ->groupBy('product.product_name')
                        ->select('product.id','product.product_name','outlets.outlet_location','outlets.id as outlet_id','product.price','product.offers')
                        ->get();
        foreach($fetch_product as $prod){
            $store='store_name';
            $prod->$store=$prod->outlet_location .' Store';
            $oprice='price_after_discount';
            if(empty($prod->offers)){
                $prod->$oprice = $prod->price;
            }else{
                $prod->$oprice = ($prod->price)-($prod->price)*(intval($prod->offers))/100;
            }
            $prods =  DB::table('product')
                        ->select('images')
                        ->where('product.id','=',$prod->id)
                        ->first();
                        
            $img = "images";
            $productimages = json_decode($prods->images);
            $prod->$img = $productimages;
        }
        
        if(count($fetch_product) !=0)
        {
            return response()->json(['response'=>'success' ,'product_list' =>$fetch_product]); 
        }
        else
        {
            return response()->json(['response'=>'Failed ','message'=>'No Product found.']);
        }
    }
    
    public function specification_old(Request $request){
        $stream = $request->json()->all();
        $company_id=$stream['company_id'];
        $sid=$stream['sub_category_id'];

        if(!empty($sid)){
            $fetch_product =  DB::table('product')
                            ->leftjoin('outlets','outlets.id','=','product.outlet_id')
                            ->select('product.id','product.product_name','outlets.outlet_location','product.price','product.offers')
                            ->where('product.subcategory_id','=',$sid)
                            ->where('product.company_id','=',$company_id)
                            ->where('product.status','=',1)
                            ->groupBy('product.product_name')
                            ->orderBy('product.id','desc')
                            ->get(); 
            
            foreach($fetch_product as $prod){
                $store='store_name';
                $prod->$store=$prod->outlet_location .' Store';
                $oprice='price_after_discount';
                if(empty($prodd->offers)){
                    $prod->$oprice = $prod->price;
                }else{
                    $prod->$oprice = ($prod->price)-($prod->price)*(intval($prod->offers))/100;
                }
                $prods =  DB::table('product')
                            ->select('images')
                            ->where('product.id','=',$prod->id)
                            ->first();
                            
                $img = "images";
                $productimages = json_decode($prods->images);
                $prod->$img = $productimages;
            }
            
        }
        if(count($fetch_product) !=0)
        {
            return response()->json(['response'=>'success' ,'product_list' =>$fetch_product]); 
        }
        else
        {
            return response()->json(['response'=>'Failed ','message'=>'No Product found.']);
        }
    }
    
    public function specification(Request $request){
        $stream = $request->json()->all();
        $name=explode(',',$stream['name']);
        $value=explode(',',$stream['value']);
        // DB::enableQueryLog();
            $fetch_product =  DB::table('product')
                            ->leftjoin('outlets','outlets.id','=','product.outlet_id')
                            ->select('product.id','product.product_name','outlets.outlet_location','outlets.id as outlet_id','product.price','product.offers')
                            ->where([['product.Attribute4','like','%'.'"'.$name[0].'"'.':'.'"'.$value[0].'"'.'%'],['product.status','=',1]])
                            ->groupBy('product.product_name')
                            ->orderBy('product.id','desc')
                            ->get(); 
            // $qwe=DB::getQueryLog() ;              
            // print_r($qwe);exit;
            foreach($fetch_product as $prod){
                $store='store_name';
                $prod->$store=$prod->outlet_location .' Store';
                $oprice='price_after_discount';
                if(empty($prodd->offers)){
                    $prod->$oprice = $prod->price;
                }else{
                    $prod->$oprice = ($prod->price)-($prod->price)*(intval($prod->offers))/100;
                }
                $prods =  DB::table('product')
                            ->select('images')
                            ->where('product.id','=',$prod->id)
                            ->first();
                            
                $img = "images";
                $productimages = json_decode($prods->images);
                $prod->$img = $productimages;
            }
            
        
        if(count($fetch_product) !=0)
        {
            return response()->json(['response'=>'success' ,'product_list' =>$fetch_product]); 
        }
        else
        {
            return response()->json(['response'=>'Failed ','message'=>'No Product found.']);
        }
    }
    
    public function add_cart(Request $request){
        $stream = $request->json()->all();
        $uid = $stream["user_id"];
		$pid = $stream["product_id"];
		
		$chk_cart = DB::table('cart')
                    ->where(['cart.uid'=>$uid,'cart.pid'=>$pid])
                    ->first();
                    
        $fetch_prd = DB::table('product')
                    ->select('product.price','product.offers','product.outlet_id')
                    ->where(['product.id'=>$pid])
                    ->first();
        
        $get_cart=DB::table('cart')->select('cart.*')->where('cart.uid','=',$uid)->first();
        
        if(empty($get_cart)){
            if(empty($chk_cart))
            {
                $cart["uid"] = $stream["user_id"];
                $cart["pid"] = $stream["product_id"];
                $cart["quantity"] = 1;
                $cart["color_id"] = $stream["color_id"];
                $cart["size_id"] = $stream["size_id"];
                $cart["outlet_id"]=$fetch_prd->outlet_id;
                $cart["product_price"]= ($fetch_prd->price)-($fetch_prd->price)*(intval($fetch_prd->offers))/100;
                $cart["total_price"] =($fetch_prd->price)-($fetch_prd->price)*(intval($fetch_prd->offers))/100;
                
                $insert = DB::table('cart')->insert($cart);
                return response()->json(['response'=>'success','message'=>'Product successfully added into cart']);
            }
            else
            {
                return response()->json(['response'=>'failed','message'=>'Product is already in cart']);
            }
        }
        elseif($fetch_prd->outlet_id == $get_cart->outlet_id){
            if(empty($chk_cart))
            {
                $cart["uid"] = $stream["user_id"];
                $cart["pid"] = $stream["product_id"];
                $cart["quantity"] = 1;
                $cart["color_id"] = $stream["color_id"];
                $cart["size_id"] = $stream["size_id"];
                $cart["outlet_id"]=$fetch_prd->outlet_id;
                $cart["product_price"]= ($fetch_prd->price)-($fetch_prd->price)*(intval($fetch_prd->offers))/100;
                $cart["total_price"] =($fetch_prd->price)-($fetch_prd->price)*(intval($fetch_prd->offers))/100;
                
                $insert = DB::table('cart')->insert($cart);
                return response()->json(['response'=>'success','message'=>'Product successfully added into cart']);
            }
            else
            {
                return response()->json(['response'=>'failed','message'=>'Product is already in cart']);
            }
        }
        else{
            return response()->json(['response'=>'failed','message'=>'you can shop only from one store at a time,please clear cart to continue']);
        }
    }
    
    public function delete_cart(Request $request){
        $stream = $request->json()->all();
        $id = $stream["cart_id"];
        
        $get_cart=DB::table('cart')
                    ->where(['cart.id'=>$id])
                    ->delete();
                    
        if($get_cart){
            return response()->json(['response'=>'success' ,'message'=>'Product has been remove successfully']); 
        }else{
            return response()->json(['response'=>'failed','message'=>'cart is empty']);
        }           
    }
    
    public function update_cart_quantity(Request $request){
        $stream = $request->json()->all();
        $id = $stream["cart_id"];
        $quantity=$stream["qty"];
        $price=$stream["unit_price"];
        $totalprice=$quantity*$price;
        
        $get_cart=DB::table('cart')
                        ->where(['cart.id'=>$id])
                        ->update(['quantity'=>$quantity,'total_price'=>$totalprice]);
                    
        if($get_cart){
            return response()->json(['response'=>'success' ,'message'=>'Quantity has been update successfully']); 
        }else{
            return response()->json(['response'=>'failed','message'=>'Try again later']);
        }
    }
    
    public function move_to_wishlist(Request $request){
        $stream = $request->json()->all();
        $id = $stream["cart_id"];
        
        $get_cart=DB::table('cart')
                        ->select('*')
                        ->where(['cart.id'=>$id])
                        ->first();
                        
        if(!empty($get_cart))
        { 
            $cart["uid"] = $get_cart->uid;
            $cart["pid"] = $get_cart->pid;
            $cart["product_price"] = $get_cart->product_price;
            $cart["total_price"] = $get_cart->total_price;
            $cart["color_id"] = $get_cart->color_id;
            $cart["size_id"] = $get_cart->size_id;
            $cart["outlet_id"]=$get_cart->outlet_id;
            
            $get_wish = DB::table('wishlist')->where(['wishlist.uid'=>$get_cart->uid,'wishlist.pid'=>$get_cart->pid])->first();
            
            if(empty($get_wish)){
                $insert = DB::table('wishlist')->insert($cart);
                $del =DB::table('cart')->where('cart.id','=',$id)->delete();
                return response()->json(['response'=>'success','message'=>'Product successfully moved to wishlist']);
            }else{
                return response()->json(['response'=>'failed','message'=>'Product is already exist in wishlist']);
            }
        }
        else
        {
            return response()->json(['response'=>'failed','message'=>'Try again later']);
        }
    }
    
    public function add_wishlist(Request $request){
        $stream = $request->json()->all();
        $uid = $stream["user_id"];
		$pid = $stream["product_id"];
		
		$chk_cart = DB::table('wishlist')
                    ->where(['wishlist.uid'=>$uid,'wishlist.pid'=>$pid])
                    ->first();
        
        $fetch_prd = DB::table('product')
                    ->select('product.price','product.offers','product.outlet_id')
                    ->where(['product.id'=>$pid])
                    ->first();
                    
        if(empty($chk_cart))
        {
            $cart["uid"] = $stream["user_id"];
            $cart["pid"] = $stream["product_id"];
            $cart["color_id"] = $stream["color_id"];
            $cart["size_id"] = $stream["size_id"];
            $cart["outlet_id"] = $fetch_prd->outlet_id;
            $cart["product_price"]= ($fetch_prd->price)-($fetch_prd->price)*(intval($fetch_prd->offers))/100;
            $cart["total_price"] =($fetch_prd->price)-($fetch_prd->price)*(intval($fetch_prd->offers))/100;
            
            $insert = DB::table('wishlist')->insert($cart);
            return response()->json(['response'=>'success','message'=>'Product successfully added into wishlist']);
        }
        else
        {
            return response()->json(['response'=>'failed','message'=>'Product is already exist in wishlist']);
        }
    }
    
    public function move_to_cart(Request $request){
        $stream = $request->json()->all();
        $id = $stream["wishlist_id"];
        
        $get_wish=DB::table('wishlist')
                        ->select('*')
                        ->where(['wishlist.id'=>$id])
                        ->first();
        
        $get_cart1=DB::table('cart')->select('cart.*')->where('cart.uid','=',$get_wish->uid)->first();
        
        if(!empty($get_wish))
        { 
            $cart["uid"] = $get_wish->uid;
            $cart["pid"] = $get_wish->pid;
            $cart["product_price"] = $get_wish->product_price;
            $cart["total_price"] = $get_wish->total_price;
            $cart["color_id"] = $get_wish->color_id;
            $cart["size_id"] = $get_wish->size_id;
            $cart["outlet_id"] = $get_wish->outlet_id;
            
            $get_cart = DB::table('cart')->where(['cart.uid'=>$get_wish->uid,'cart.pid'=>$get_wish->pid])->first();
            if(empty($get_cart1)){
                if(empty($get_cart)){
                    $fetch_prd = DB::table('product')
                                ->select('product.price','product.offers')
                                ->where(['product.id'=>$get_wish->pid])
                                ->first();
                    $cart["quantity"] = 1;
                    $cart["product_price"] = ($fetch_prd->price)-($fetch_prd->price)*(intval($fetch_prd->offers))/100;
                    $cart["total_price"] = ($fetch_prd->price)-($fetch_prd->price)*(intval($fetch_prd->offers))/100;
                    
                    $insert = DB::table('cart')->insert($cart);
                    $del =DB::table('wishlist')->where('wishlist.id','=',$id)->delete();
                    return response()->json(['response'=>'success','message'=>'Product successfully moved to cart']);
                }else{
                    return response()->json(['response'=>'failed','message'=>'Product is already exist in cart']);
                }
            }elseif($get_cart1->outlet_id==$get_wish->outlet_id){
                if(empty($get_cart)){
                    $fetch_prd = DB::table('product')
                                ->select('product.price','product.offers')
                                ->where(['product.id'=>$get_wish->pid])
                                ->first();
                    $cart["quantity"] = 1;
                    $cart["product_price"] = ($fetch_prd->price)-($fetch_prd->price)*(intval($fetch_prd->offers))/100;
                    $cart["total_price"] = ($fetch_prd->price)-($fetch_prd->price)*(intval($fetch_prd->offers))/100;
                    
                    $insert = DB::table('cart')->insert($cart);
                    $del =DB::table('wishlist')->where('wishlist.id','=',$id)->delete();
                    return response()->json(['response'=>'success','message'=>'Product successfully moved to cart']);
                }else{
                    return response()->json(['response'=>'failed','message'=>'Product is already exist in cart']);
                }
            }else{
                return response()->json(['response'=>'failed','message'=>'you can shop only from one store at a time,please clear cart to continue']);
            }
        }
        else
        {
            return response()->json(['response'=>'failed','message'=>'Try again later']);
        }
    }
    
    public function delete_wishlist(Request $request){
        $stream = $request->json()->all();
        $id = $stream["wishlist_id"];
        
        $get_cart=DB::table('wishlist')
                    ->where(['wishlist.id'=>$id])
                    ->delete();
                    
        if($get_cart){
            return response()->json(['response'=>'success' ,'message'=>'Product has been remove successfully']); 
        }else{
            return response()->json(['response'=>'failed','message'=>'wishlist is empty']);
        } 
    }
    
    public function fetch_cart(Request $request){
        $stream = $request->json()->all();
        $id = $stream["user_id"];
        
        $cart_data=DB::table('cart')
                    ->select('cart.id as cart_id','cart.pid as product_id','super_categories.name as super_category_name','color.Name as color_name','size.Size','cart.specification_id as specification','cart.quantity','cart.total_price','product.product_name','product.company_id','product.price','product.offers','product.Attribute1 as product_description')
                    ->leftjoin('product', 'product.id', '=', 'cart.pid')
                    ->leftjoin('color','color.id','cart.color_id')
                    ->leftjoin('size','size.id','cart.size_id')
                    ->leftjoin('categories', 'categories.id', '=', 'product.category_id')
                    ->leftjoin('super_categories','super_categories.id','=','categories.super_category_id')
                    ->where(['cart.uid'=>$id])
                    ->groupBy('cart.id')
                    ->get();
        foreach($cart_data as $prod){            
            $oprice='price_after_discount';
            if(empty($prod->offers)){
                $prod->$oprice = $prod->price;
            }else{
                $prod->$oprice = ($prod->price)-($prod->price)*(intval($prod->offers))/100;
            }
            $prods =  DB::table('product')
                        ->select('images')
                        ->where('product.id','=',$prod->product_id)
                        ->first();
                        
            $img = "image";
            $productimages = json_decode($prods->images);
            $prod->$img = $productimages[0];
        }
        
        if(count($cart_data)!=0){
            return response()->json(['response'=>'success' ,'cart_list'=>$cart_data]); 
        }else{
            return response()->json(['response'=>'failed','message'=>'cart is empty']);
        }             
    }
    
    public function fetch_wishlist(Request $request){
        $stream = $request->json()->all();
        $id = $stream["user_id"];
        
        $wishlist_data=DB::table('wishlist')
                    ->select('wishlist.id as wishlist_id','wishlist.pid as product_id','product.product_name','color.Name as color_name','size.Size','wishlist.specification_id as specification','product.company_id','product.price','product.offers')
                    ->leftjoin('product', 'product.id', '=', 'wishlist.pid')
                    ->leftjoin('color','color.id','wishlist.color_id')
                    ->leftjoin('size','size.id','wishlist.size_id')
                    ->where(['wishlist.uid'=>$id])
                    ->groupBy('wishlist.id')
                    ->get();
        
        foreach($wishlist_data as $prod){            
            $oprice='price_after_discount';
            if(empty($prod->offers)){
                $prod->$oprice = $prod->price;
            }else{
                $prod->$oprice = ($prod->price)-($prod->price)*(intval($prod->offers))/100;
            }
            $prods =  DB::table('product')
                        ->select('images')
                        ->where('product.id','=',$prod->product_id)
                        ->first();
                        
            $img = "image";
            $productimages = json_decode($prods->images);
            $prod->$img = $productimages[0];
        }
        
        if(count($wishlist_data) !=0){
            return response()->json(['response'=>'success' ,'wish_list'=>$wishlist_data]); 
        }else{
            return response()->json(['response'=>'failed','message'=>'wishlist is empty']);
        }             
    }
    
    public function search(Request $request){
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
    
    public function check_address(Request $request){
        $stream = $request->json()->all();
        $fetchusr  = DB::table('address')
                    ->select('address.id as address_id','address.name','address.email','address.phone','address.address','address.city','address.state','address.country','address.postalcode as pincode')
                    ->where(['address.uid'=>$stream["user_id"]])
                    ->orderBy('id','desc')
                    ->get();
        
        if(count($fetchusr)==0)
        {
            return response()->json(['response'=>'failed','message'=>'No Address Found']);
        }
        else
        {
            return response()->json(['response'=>'success','userinfo'=>$fetchusr]);
        }
    }
    
    public function add_address(Request $request){
        $stream = $request->json()->all();
        $pro["uid"]=$stream["user_id"];
        $pro["name"]=$stream["name"];
        $pro["email"]=$stream["email"];
        $pro["phone"]=$stream["phone"];
        $pro["address"] = $stream["address"];
        $pro["city"] = $stream["city"];
        $pro["state"] = $stream["state"];
        $pro["postalcode"] = $stream["pincode"];
        $pro["country"] = $stream["country"];
        
        $insert = DB::table('address')->insert($pro);
        
        if($insert)
        {
            return response()->json(['response'=>'success' ,'message' =>'Address Added']);
        }
        
        else
        {
            return response()->json(['response'=>'failed','message'=>'Try Again']);
        }
    }
    
    public function update_address(Request $request){
        $stream = $request->json()->all();
        $insert = DB::table('address')
                    ->where('id', $stream["address_id"])
                    ->update(['address'=>$stream["address"],'city'=>$stream["city"],'state'=>$stream["state"],'postalcode'=>$stream["pincode"],'country'=>$stream["country"],'name'=>$stream["name"],'email'=>$stream["email"],'phone'=>$stream["phone"]]);
        
        if($insert)
        {
            return response()->json(['response'=>'success' ,'message' =>'Address Updated']);
        }
        else
        {
            return response()->json(['response'=>'failed','message'=>'Try Again']);
        }
    }
    
    public function delete_address(Request $request){
        $stream = $request->json()->all();
        $affected = DB::table('address')
                    ->where('id', '=', $stream["address_id"])
                    ->delete();
        
        if($affected)
        {
            return response()->json(['response'=>'success' ,'message' =>'Address Deleted']);
        }
        else
        {
            return response()->json(['response'=>'failed','message'=>'Try Again']);
        }
    }
    
    public function apply_coupon(Request $request){
        $stream = $request->json()->all();
        $c_code = $stream["coupon_code"];
        date_default_timezone_set('Asia/Kolkata');
        $date = date( 'Y-m-d' );
        
        $coupon = DB::table('offer_banner')
                    ->select('*')
                    ->where('coupon_code','=',$c_code)
                    ->first();
              
        if(empty($coupon))
        {
            return response()->json(['response'=>'failed','message'=>'Invalid Coupon']);
        }
        else
        {
            if(strtotime($date) > strtotime($coupon->expiry_date))
            {
                return response()->json(['response'=>'failed','message'=>'Coupon is Expired']);
            }
            else
            {  
                if($stream["total_amount"] >= $coupon->min_subtotal){
                    $c_amount =($stream["total_amount"])*($coupon->discount / 100);
                    if($coupon->max_discount > $c_amount){
                        $t_amount = $stream["total_amount"];
                        $new_t_amount = $t_amount-$c_amount;
                        return response()->json(['response'=>'success','total_price'=>$t_amount,'total_price_after_discount' =>$new_t_amount,'discount_price'=>$c_amount,'applied_coupon'=>$c_code]);
                    }else{
                        $t_amount = $stream["total_amount"];
                        $new_t_amount = $t_amount-$coupon->max_discount;
                        return response()->json(['response'=>'success','total_price'=>$t_amount,'total_price_after_discount' =>$new_t_amount,'discount_price'=>$coupon->max_discount,'applied_coupon'=>$c_code]);
                    }
                }else{
                    return response()->json(['response'=>'failed','message'=>"Minimum amount should be $coupon->min_subtotal "]);
                }
            }
        }
    }
    
    public function add_review(Request $request){
        $stream = $request->json()->all();
        $review = array();
        
        $user = DB::table('users')
                    ->select('users.name')
                    ->where('id','=',$stream["user_id"])
                    ->first();
                    
        $fetch_review = DB::table('review')->where(['review.user_id'=>$stream["user_id"],'review.product_id'=>$stream["product_id"]])->first();
        if(empty($fetch_review)){
            $review["user_id"] = $stream["user_id"];
            $review["name"] = $user->name;
            $review["product_id"] = $stream["product_id"];
            $review["review"] = $stream["comment"];
            $review["rating"] = $stream["rating"];
            $insertorder = DB::table('review')->insert($review);
            if($insertorder)
            {
                return response()->json(['response'=>'success' ,'message' =>'Review Added']);
            }
            else
            {
                return response()->json(['response'=>'failed','message'=>'Try Again']);
            }
        }else{
            return response()->json(['response'=>'failed','message'=>'You have already reviewed this product']);
        }
    }
    
    public function checkout(Request $request){
        $stream = $request->json()->all();
        $id = $stream["user_id"];
        
        $cart_data=DB::table('cart')
                    ->select('cart.id as cart_id','cart.pid as product_id','super_categories.name as super_category_name','color.name as color_name','size.Size','cart.specification_id as specification','cart.quantity','cart.total_price','product.product_name','product.company_id','product.price','product.offers')
                    ->leftjoin('product', 'product.id', '=', 'cart.pid')
                    ->leftjoin('color','color.id','cart.color_id')
                    ->leftjoin('size','size.id','cart.size_id')
                    ->leftjoin('categories', 'categories.id', '=', 'product.category_id')
                    ->leftjoin('super_categories','super_categories.id','=','categories.super_category_id')
                    ->where(['cart.uid'=>$id])
                    ->groupBy('cart.id')
                    ->get();
        foreach($cart_data as $prod){            
            $oprice='price_after_discount';
            if(empty($prod->offers)){
                $prod->$oprice = $prod->price;
            }else{
                $prod->$oprice = ($prod->price)-($prod->price)*(intval($prod->offers))/100;
            }
            $prods =  DB::table('product')
                        ->select('images')
                        ->where('product.id','=',$prod->product_id)
                        ->first();
                        
            $img = "image";
            $productimages = json_decode($prods->images);
            $prod->$img = $productimages[0];
        }
        
        $sub_total =    $cart_data->sum('total_price'); 
        $tax= 50;
        $delivery_cahrges =10;
        $final_total =$sub_total + $tax + $delivery_cahrges;
        
        if(count($cart_data)!=0){
            return response()->json(['response'=>'success' ,'sub_total'=>$sub_total,'tax'=>$tax,'delivery_charges'=>$delivery_cahrges,'final_amount'=>$final_total,'cart_list'=>$cart_data]); 
        }else{
            return response()->json(['response'=>'failed','message'=>'cart is empty']);
        } 
    }
    
    public function checkout_new(Request $request){
        $stream = $request->json()->all();
        $id = $stream["user_id"];
        
        $cart_data=DB::table('cart')
                    ->select('cart.id as cart_id','cart.pid as product_id','super_categories.name as super_category_name','color.name as color_name','size.Size','cart.specification_id as specification','cart.quantity','cart.total_price','product.product_name','product.company_id','product.price','product.offers')
                    ->leftjoin('product', 'product.id', '=', 'cart.pid')
                    ->leftjoin('color','color.id','cart.color_id')
                    ->leftjoin('size','size.id','cart.size_id')
                    ->leftjoin('categories', 'categories.id', '=', 'product.category_id')
                    ->leftjoin('super_categories','super_categories.id','=','categories.super_category_id')
                    ->where(['cart.uid'=>$id])
                    ->groupBy('cart.id')
                    ->get();
        foreach($cart_data as $prod){            
            $oprice='price_after_discount';
            if(empty($prod->offers)){
                $prod->$oprice = $prod->price;
            }else{
                $prod->$oprice = ($prod->price)-($prod->price)*(intval($prod->offers))/100;
            }
            
            $prods =  DB::table('product')
                        ->select('images','gst_type','gst_amount')
                        ->where('product.id','=',$prod->product_id)
                        ->first();
                        
            $img = "image";
            $productimages = json_decode($prods->images);
            $prod->$img = $productimages[0];
            
            $type="GST_Type";
            $amount="GST_Amount";
            if($prods->gst_type=='Fixed'){
                $prod->$type=$prods->gst_type;
                $prod->$amount = $prods->gst_amount;
            }else{
                $prod->$type=$prods->gst_type;
                $prod->$amount= ($prod->$oprice/$prods->gst_amount);
            }
            
        }
        
        $sub_total =    $cart_data->sum('total_price'); 
        $tax= $cart_data->sum('GST_Amount');
        $delivery_cahrges =10;
        $final_total =$sub_total + $tax + $delivery_cahrges;
        
        if(count($cart_data)!=0){
            return response()->json(['response'=>'success' ,'sub_total'=>$sub_total,'tax'=>$tax,'delivery_charges'=>$delivery_cahrges,'final_amount'=>$final_total,'cart_list'=>$cart_data]); 
        }else{
            return response()->json(['response'=>'failed','message'=>'cart is empty']);
        } 
    }
    
    public function checkout_final(Request $request){
        $stream = $request->json()->all();
        $id = $stream["user_id"];
        $pincode= DB::table('address')->select('postalcode')->where('id','=',$stream['address_id'])->first();
        $pincode=$pincode->postalcode;
        $cart_data=DB::table('cart')
                    ->select('cart.id as cart_id','cart.pid as product_id','super_categories.name as super_category_name','color.name as color_name','size.Size','cart.specification_id as specification','cart.quantity','cart.total_price','product.product_name','product.company_id','product.price','product.offers')
                    ->leftjoin('product', 'product.id', '=', 'cart.pid')
                    ->leftjoin('color','color.id','cart.color_id')
                    ->leftjoin('size','size.id','cart.size_id')
                    ->leftjoin('categories', 'categories.id', '=', 'product.category_id')
                    ->leftjoin('super_categories','super_categories.id','=','categories.super_category_id')
                    ->where(['cart.uid'=>$id])
                    ->groupBy('cart.id')
                    ->get();
        foreach($cart_data as $prod){            
            $oprice='price_after_discount';
            if(empty($prod->offers)){
                $prod->$oprice = $prod->price;
            }else{
                $prod->$oprice = ($prod->price)-($prod->price)*(intval($prod->offers))/100;
            }
            $prods =  DB::table('product')
                        ->select('images','outlet_id')
                        ->where('product.id','=',$prod->product_id)
                        ->first();
                        
            $img = "image";
            $productimages = json_decode($prods->images);
            $prod->$img = $productimages[0];
            
            $outlet= DB::table('outlets')
                    ->select('outlets.outlet_pincode','outlets.radius','outlets.served_pincode')
                    ->where('id', '=', $prods->outlet_id)
                    ->first();
                    
            $data=explode(',',$outlet->served_pincode);
            if(in_array($pincode,$data)){
                $msg = "message";
                $prod->$msg = 'Delivery option is available';
            }else{
                $zip1=$pincode;
                $zip2=$outlet->outlet_pincode;
                $url='https://maps.googleapis.com/maps/api/geocode/json?address='.$zip1.'&sensor=false&key=AIzaSyDDSLtnVcQB2m-9gtvjOyWkXavPBXx5SX8';
                $curl = curl_init($url);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, true);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_HEADER, false);
                curl_setopt($curl, CURLOPT_TIMEOUT, 30);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                
                $json=curl_exec($curl);
                
                $decode=json_decode($json,true);
                if(!empty($decode['results'])){
                    $result1[]=$decode['results'][0];
                    $result2[]=$result1[0]['geometry'];
                    $result3[]=$result2[0]['location'];
                }else{
                    return response()->json(['response'=>'failed','message'=>'Enter correct pincode']);
                }
                
                $url1='https://maps.googleapis.com/maps/api/geocode/json?address='.$zip2.'&sensor=false&key=AIzaSyDDSLtnVcQB2m-9gtvjOyWkXavPBXx5SX8';
                $curl1 = curl_init($url1);
                curl_setopt($curl1, CURLOPT_POST, true);
                curl_setopt($curl1, CURLOPT_POSTFIELDS, true);
                curl_setopt($curl1, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl1, CURLOPT_HEADER, false);
                curl_setopt($curl1, CURLOPT_TIMEOUT, 30);
                curl_setopt($curl1, CURLOPT_SSL_VERIFYPEER, false);
                
                $json1=curl_exec($curl1);
                $decode1=json_decode($json1,true);
                if(!empty($decode1['results'])){
                    $result11[]=$decode1['results'][0];
                    $result21[]=$result11[0]['geometry'];
                    $result31[]=$result21[0]['location'];
                }
                else{
                    return response()->json(['response'=>'failed','message'=>'Enter correct pincode']);
                }
                
                
                $lat1=$result3[0]['lat'];
                $lon1=$result3[0]['lng'];
                $lat2=$result31[0]['lat'];
                $lon2=$result31[0]['lng'];
                
                $unit='km';
                $theta=$lon1-$lon2;
                $dist=sin(deg2rad((double)$lat1)) * sin(deg2rad((double)$lat2)) + cos(deg2rad((double)$lat1)) * cos(deg2rad((double)$lat2)) * cos(deg2rad((double)$theta));
                $dist=acos($dist);
                $dist=rad2deg($dist);
                $distance=round($dist * 60 * 1.1515 * 1.609344);
                if($distance < $outlet->radius){
                    $msg = "message";
                    $prod->$msg = 'Delivery option is available';
                }else{
                    $msg = "message";
                    $prod->$msg = 'Delivery option is not available';
                }
            }
        }
            $sub_total =    $cart_data->sum('total_price'); 
            $tax= 50;
            $delivery_cahrges =10;
            $final_total =$sub_total + $tax + $delivery_cahrges;
            
            if(count($cart_data)!=0){
                return response()->json(['response'=>'success' ,'sub_total'=>$sub_total,'tax'=>$tax,'delivery_charges'=>$delivery_cahrges,'final_amount'=>$final_total,'cart_list'=>$cart_data]); 
            }else{
                return response()->json(['response'=>'failed','message'=>'cart is empty']);
            } 
        
    }
    
    public function checkout_final_new(Request $request){
        $stream = $request->json()->all();
        $id = $stream["user_id"];
        $pincode= DB::table('address')->select('postalcode')->where('id','=',$stream['address_id'])->first();
        $pincode=$pincode->postalcode;
        
        $cart_data=DB::table('cart')
                    ->select('cart.id as cart_id','cart.pid as product_id','super_categories.name as super_category_name','color.name as color_name','size.Size','cart.specification_id as specification','cart.quantity','cart.total_price','product.product_name','product.company_id','product.price','product.offers')
                    ->leftjoin('product', 'product.id', '=', 'cart.pid')
                    ->leftjoin('color','color.id','cart.color_id')
                    ->leftjoin('size','size.id','cart.size_id')
                    ->leftjoin('categories', 'categories.id', '=', 'product.category_id')
                    ->leftjoin('super_categories','super_categories.id','=','categories.super_category_id')
                    ->where(['cart.uid'=>$id])
                    ->groupBy('cart.id')
                    ->get();
        foreach($cart_data as $prod){            
            $oprice='price_after_discount';
            if(empty($prod->offers)){
                $prod->$oprice = $prod->price;
            }else{
                $prod->$oprice = ($prod->price)-($prod->price)*(intval($prod->offers))/100;
            }
            $prods =  DB::table('product')
                        ->select('images','outlet_id','gst_type','gst_amount')
                        ->where('product.id','=',$prod->product_id)
                        ->first();
                        
            $img = "image";
            $productimages = json_decode($prods->images);
            $prod->$img = $productimages[0];
            
            $type="GST_Type";
            $amount="GST_Amount";
            if($prods->gst_type=='Fixed'){
                $prod->$type=$prods->gst_type;
                $prod->$amount = ($prods->gst_amount * $prod->quantity);
            }else{
                $prod->$type=$prods->gst_type;
                // print_r($prod->$oprice*$prods->gst_amount/100);exit;
                $prod->$amount= ($prod->$oprice*$prods->gst_amount/100)*($prod->quantity);
            }
            
            $outlet= DB::table('outlets')
                    ->select('outlets.outlet_pincode','outlets.radius','outlets.served_pincode')
                    ->where('id', '=', $prods->outlet_id)
                    ->first();
                    
            $data=explode(',',$outlet->served_pincode);
            if(in_array($pincode,$data)){
                $msg = "message";
                $prod->$msg = 'Delivery option is available';
            }else{
                $zip1=$pincode;
                $zip2=$outlet->outlet_pincode;
                $url='https://maps.googleapis.com/maps/api/geocode/json?address='.$zip1.'&sensor=false&key=AIzaSyDDSLtnVcQB2m-9gtvjOyWkXavPBXx5SX8';
                $curl = curl_init($url);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, true);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_HEADER, false);
                curl_setopt($curl, CURLOPT_TIMEOUT, 30);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                
                $json=curl_exec($curl);
                
                $decode=json_decode($json,true);
                if(!empty($decode['results'])){
                    $result1[]=$decode['results'][0];
                    $result2[]=$result1[0]['geometry'];
                    $result3[]=$result2[0]['location'];
                }else{
                    return response()->json(['response'=>'failed','message'=>'Enter correct pincode']);
                }
                
                $url1='https://maps.googleapis.com/maps/api/geocode/json?address='.$zip2.'&sensor=false&key=AIzaSyDDSLtnVcQB2m-9gtvjOyWkXavPBXx5SX8';
                $curl1 = curl_init($url1);
                curl_setopt($curl1, CURLOPT_POST, true);
                curl_setopt($curl1, CURLOPT_POSTFIELDS, true);
                curl_setopt($curl1, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl1, CURLOPT_HEADER, false);
                curl_setopt($curl1, CURLOPT_TIMEOUT, 30);
                curl_setopt($curl1, CURLOPT_SSL_VERIFYPEER, false);
                
                $json1=curl_exec($curl1);
                $decode1=json_decode($json1,true);
                if(!empty($decode1['results'])){
                    $result11[]=$decode1['results'][0];
                    $result21[]=$result11[0]['geometry'];
                    $result31[]=$result21[0]['location'];
                }
                else{
                    return response()->json(['response'=>'failed','message'=>'Enter correct pincode']);
                }
                
                
                $lat1=$result3[0]['lat'];
                $lon1=$result3[0]['lng'];
                $lat2=$result31[0]['lat'];
                $lon2=$result31[0]['lng'];
                
                $unit='km';
                $theta=$lon1-$lon2;
                $dist=sin(deg2rad((double)$lat1)) * sin(deg2rad((double)$lat2)) + cos(deg2rad((double)$lat1)) * cos(deg2rad((double)$lat2)) * cos(deg2rad((double)$theta));
                $dist=acos($dist);
                $dist=rad2deg($dist);
                $distance=round($dist * 60 * 1.1515 * 1.609344);
                if($distance < $outlet->radius){
                    $msg = "message";
                    $prod->$msg = 'Delivery option is available';
                }else{
                    $msg = "message";
                    $prod->$msg = 'Delivery option is not available';
                }
            }
        }
            $sub_total =    $cart_data->sum('total_price'); 
            $tax= $cart_data->sum('GST_Amount');
            $check_city=DB::table('cities_pincode')->select('id')->where('pincode','=',$pincode)->where('city_id','=',1558)->first();
            if(!empty($check_city)){
                $cgst= $cart_data->sum('GST_Amount')/2;
                $sgst= $cart_data->sum('GST_Amount')/2;
                $igst=0;
            }else{
                $cgst= 0;
                $sgst= 0;
                $igst =$cart_data->sum('GST_Amount');
            }
            $delivery_cahrges =10;
            $final_total =($sub_total + $tax + $delivery_cahrges);
            
            if(count($cart_data)!=0){
                return response()->json(['response'=>'success' ,'sub_total'=>$sub_total,'CGST'=>$cgst,'SGST'=>$sgst,'IGST'=>$igst,'delivery_charges'=>$delivery_cahrges,'final_amount'=>$final_total,'cart_list'=>$cart_data]); 
            }else{
                return response()->json(['response'=>'failed','message'=>'cart is empty']);
            } 
        
    }
    
    public function order_generation(Request $request){
        $stream = $request->json()->all();
        $uid = $stream["user_id"];
        $acoupon = array();
        $aorder = array();
        $aorder["user_id"] = $uid;
        $aorder["order_id"] = uniqid();
        
        $get_cart1 =DB::table('cart')
                    ->select('*')
                    ->where(['uid'=>$uid])
                    ->get();
                    
        $qty=$get_cart1->sum('quantity');
        
        $date = date('Y-m-d');
        
        // $string='';
        // $srting=preg_replace('/[^a-zA-Z0-9_ -]/s',' ',$stream["address"]);
        // $newstring = $srting." ".$stream["city"]." ".$stream["state"];
        // if(!empty($newstring)){
        //     $formattedAddr = str_replace(' ','+',$newstring);
        //     $geocodeFromAddr = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddr.'&key=AIzaSyD9zsyZTkqWJDrw1pqHKeCPqlNwYOhnTOg');
        //     $output = json_decode($geocodeFromAddr);
        //     $clat = $output->results[0]->geometry->location->lat;
        //     $clng = $output->results[0]->geometry->location->lng;
        // }
        
        $aorder["pay_type"] = (!empty($stream["pay_type"]))? $stream["pay_type"]: '';
        $aorder["total_amount"] = (!empty($stream["total_amount"]))? $stream["total_amount"]: '';
        $aorder["coupon_amount"] = (!empty($stream["coupon_amount"]))? $stream["coupon_amount"]: '0';
        $aorder["coupon"] = (!empty($stream["coupon"]))? $stream["coupon"]: '0';
        $aorder["delivery_amount"] = (!empty($stream["delivery_amount"]))? $stream["delivery_amount"]: '0';
        $aorder["tax_amount"] = (!empty($stream["tax_amount"]))? $stream["tax_amount"]: '0';
        $aorder["delivery_status"] = "Processing Order";
        $aorder["name"] = (!empty($stream["name"]))? $stream["name"]: '';
        $aorder["address"] = (!empty($stream["address"]))? $stream["address"]: '';
        $aorder["city"] = (!empty($stream["city"]))? $stream["city"]: '';
        $aorder["state"] = (!empty($stream["state"]))? $stream["state"]: '';
        $aorder["country"] = (!empty($stream["country"]))? $stream["country"]: '';
        $aorder["phone"] = (!empty($stream["phone"]))? $stream["phone"]: '';
        $aorder["email"] = (!empty($stream["email"]))? $stream["email"]: '';
        $aorder["qty"] = $qty;
        
        $aorder["postal_code"] = (!empty($stream["pincode"]))? $stream["pincode"]: '';
        // $aorder["latitude"] = $clat;
        // $aorder["longitude"] = $clng;
        $insertorder = DB::table('orders')->insertGetId($aorder);
        
        $get_cart = DB::table('cart')
                    ->select('*')
                    ->where(['uid'=>$uid])
                    ->get();
        
        date_default_timezone_set('Asia/Kolkata');
    	
        foreach($get_cart as $sldt)
		{   
		    $ppid = $sldt->pid;
		    $company_id=DB::table('product')->select('company_id')->where('id','=',$ppid)->first();
		    $insert_ordertxn = DB::table('transactions')->insert(['order_id'=>$aorder["order_id"],'company_id'=>$company_id->company_id,'color_id'=>$sldt->color_id,'size_id'=>$sldt->size_id,'specification_id'=>$sldt->specification_id,'product_id'=>$sldt->pid,'user_id'=>$sldt->uid,'qty'=>$sldt->quantity,
		    'product_amount'=>$sldt->product_price,'total_amount'=>$sldt->quantity*$sldt->product_price,'date'=>$date]);
		}
		
		$order = DB::table('orders')->where('id', $insertorder)->first();
        $order=json_decode(json_encode($order),true);
        // print_r($order);exit;
        Mail::send('invoicedemo', $order, function($message) use($order) {
            $message->to($order['email'], 'Order Placed')
            ->cc('maheshchoudhary9913103649@gmail.com')
            ->subject('Order Placed');
            $message->from('info@bniindiastore.com', 'Order Placed');
            
        });
		
		$deletecart  = DB::table('cart')->where(['uid'=>$uid])->delete();
		
		if($insertorder != '')
		{
		    return response()->json(['response'=>'success','order_id'=>$aorder["order_id"]]);
		}
		else
		{
		    return response()->json(['response'=>'failed','message'=>'No Data']);
		}
		
    }
    
    public function order_generation_new(Request $request){
        $stream = $request->json()->all();
        $uid = $stream["user_id"];
        $acoupon = array();
        $aorder = array();
        $aorder["user_id"] = $uid;
        $aorder["order_id"] = uniqid();
        
        $get_cart1 =DB::table('cart')
                    ->select('*')
                    ->where(['uid'=>$uid])
                    ->get();
                    
        $qty=$get_cart1->sum('quantity');
        
        $date = date('Y-m-d');
        
        // $string='';
        // $srting=preg_replace('/[^a-zA-Z0-9_ -]/s',' ',$stream["address"]);
        // $newstring = $srting." ".$stream["city"]." ".$stream["state"];
        // if(!empty($newstring)){
        //     $formattedAddr = str_replace(' ','+',$newstring);
        //     $geocodeFromAddr = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddr.'&key=AIzaSyD9zsyZTkqWJDrw1pqHKeCPqlNwYOhnTOg');
        //     $output = json_decode($geocodeFromAddr);
        //     $clat = $output->results[0]->geometry->location->lat;
        //     $clng = $output->results[0]->geometry->location->lng;
        // }
        
        $aorder["pay_type"] = (!empty($stream["pay_type"]))? $stream["pay_type"]: '';
        $aorder["total_amount"] = (!empty($stream["total_amount"]))? $stream["total_amount"]: '';
        $aorder["coupon_amount"] = (!empty($stream["coupon_amount"]))? $stream["coupon_amount"]: '0';
        $aorder["coupon"] = (!empty($stream["coupon"]))? $stream["coupon"]: '0';
        $aorder["delivery_amount"] = (!empty($stream["delivery_amount"]))? $stream["delivery_amount"]: '0';
        $aorder["tax_amount"] = (!empty($stream["tax_amount"]))? $stream["tax_amount"]: '0';
        $aorder["delivery_status"] = "Processing Order";
        $aorder["name"] = (!empty($stream["name"]))? $stream["name"]: '';
        $aorder["address"] = (!empty($stream["address"]))? $stream["address"]: '';
        $aorder["city"] = (!empty($stream["city"]))? $stream["city"]: '';
        $aorder["state"] = (!empty($stream["state"]))? $stream["state"]: '';
        $aorder["country"] = (!empty($stream["country"]))? $stream["country"]: '';
        $aorder["phone"] = (!empty($stream["phone"]))? $stream["phone"]: '';
        $aorder["email"] = (!empty($stream["email"]))? $stream["email"]: '';
        $aorder["qty"] = $qty;
        
        $aorder["postal_code"] = (!empty($stream["pincode"]))? $stream["pincode"]: '';
        // $aorder["latitude"] = $clat;
        // $aorder["longitude"] = $clng;
        $insertorder = DB::table('orders')->insertGetId($aorder);
        
        $get_cart = DB::table('cart')
                    ->select('*')
                    ->where(['uid'=>$uid])
                    ->get();
        
        date_default_timezone_set('Asia/Kolkata');
    	
        foreach($get_cart as $sldt)
		{   
		    $ppid = $sldt->pid;
		    $insert_ordertxn = DB::table('transactions')->insert(['order_id'=>$aorder["order_id"],'color_id'=>$sldt->color_id,'size_id'=>$sldt->size_id,'specification_id'=>$sldt->specification_id,'product_id'=>$sldt->pid,'user_id'=>$sldt->uid,'qty'=>$sldt->quantity,
		    'product_amount'=>$sldt->product_price,'total_amount'=>$sldt->quantity*$sldt->product_price,'date'=>$date]);
		}
		
		$order = DB::table('orders')->where('id', $insertorder)->first();
        $order=json_decode(json_encode($order),true);
        // print_r($order);exit;
        Mail::send('invoicedemo', $order, function($message) use($order) {
            $message->to($order['email'], 'Order Placed')
            ->cc('maheshchoudhary9913103649@gmail.com')
            ->subject('Order Placed');
            $message->from('info@bniindiastore.com', 'Order Placed');
            
        });
        
		$deletecart  = DB::table('cart')->where(['uid'=>$uid])->delete();
		
		if($insertorder != '')
		{
		    return response()->json(['response'=>'success','order_id'=>$aorder["order_id"]]);
		}
		else
		{
		    return response()->json(['response'=>'failed','message'=>'No Data']);
		}
		
    }
    
    public function get_order_info(Request $request){
        $stream = $request->json()->all();
        $uid = $stream["user_id"];
        
        $orders = DB::table('orders')
                    ->select('order_id as orderid','total_amount','delivery_amount','tax_amount','coupon','coupon_amount','delivery_status','created_at')
                    ->where(['user_id'=>$uid])
                    ->orderBy('id','desc')
                    ->get();
              
        foreach($orders as $sldt)
        {
            $datatr= DB::table('transactions')
                    ->leftjoin('product','product.id','=','transactions.product_id')
                    ->leftjoin('color','color.id','transactions.color_id')
                    ->leftjoin('size','size.id','transactions.size_id')
                    ->select('transactions.id as transactions_id','transactions.product_id','product.product_name','color.Name as color_name','size.Size as size','transactions.specification_id as specification','product.Attribute1 as product_description',
                        'transactions.qty as quantity','transactions.product_amount','transactions.total_amount')
                    ->where(['transactions.order_id'=> $sldt->orderid])
                    ->get();
            foreach($datatr as $prod){            
                $oprice='price_after_discount';
                if(empty($prod->offers)){
                    $prod->$oprice = $prod->product_amount;
                }else{
                    $prod->$oprice = ($prod->product_amount)-($prod->product_amount)*(intval($prod->offers))/100;
                }
                $prods =  DB::table('product')
                            ->select('images')
                            ->where('product.id','=',$prod->product_id)
                            ->first();
                            
                $img = "image";
                $productimages = json_decode($prods->images);
                $prod->$img = $productimages[0];
            }
                    
                    
            $dat[] = array('date'=>date('Y-m-d',strtotime($sldt->created_at)),'order_status'=>$sldt->delivery_status,'price'=>($datatr->sum('product_amount')),'coupon'=>$sldt->coupon,'coupon_amount'=>$sldt->coupon_amount,'tax_amount'=>$sldt->tax_amount,'delivery_amount'=>$sldt->delivery_amount,'total_amount'=>$sldt->total_amount,'order_id'=>$sldt->orderid,'detail'=>$datatr);
        }
        
        if(!empty($dat))
        {
            return response()->json(['response'=>'success','orderdata'=>$dat]);
        }
        else
        {
            return response()->json(['response'=>'failed','message'=>'No Data']);
        }
    }
    
    public function shop_type(Request $request){
        $stream = $request->json()->all();
        $type=$stream['type'];
        if($type==1){
            $pro["user_id"]=$stream["user_id"];
            $pro["company_id"]=$stream["company_id"];
            $pro["quick_shop_count"]=1;
            $pro["live_shop_count"]=0;
            $insert = DB::table('company_pay_per_click')->insert($pro);
            
            $user_points=DB::table('users')
                    ->select('users.quick_points')
                    ->where('id', '=', $stream["user_id"])
                    ->first(); 
                    
            $add_points=DB::table('company_admin')
                    ->select('company_admin.quick_point')
                    ->where('company_id', '=', $stream["company_id"])
                    ->first();
                    
            $new_points=$user_points->quick_points + $add_points->quick_point;
            
            $affected = DB::table('users')
                        ->where('id', $stream['user_id'])
                        ->update(['quick_points'=>$new_points]);
            
            return response()->json(['response'=>'success','message'=>'Data Updated']); 
        }else{
            $pro["user_id"]=$stream["user_id"];
            $pro["company_id"]=$stream["company_id"];
            $pro["quick_shop_count"]=0;
            $pro["live_shop_count"]=1;
            $insert = DB::table('company_pay_per_click')->insert($pro);
            
            $user_points=DB::table('users')
                    ->select('users.live_points')
                    ->where('id', '=', $stream["user_id"])
                    ->first(); 
                    
            $add_points=DB::table('company_admin')
                    ->select('company_admin.online_point')  
                    ->where('company_id', '=', $stream["company_id"])
                    ->first();
                    
            $new_points=$user_points->live_points + $add_points->online_point;
            
            $affected = DB::table('users')
                        ->where('id', $stream['user_id'])
                        ->update(['live_points'=>$new_points]);
                        
            return response()->json(['response'=>'success','message'=>'Data Updated']); 
        }
    }
    
    public function live_stream_list(Request $request){
        $stream = $request->json()->all();
        $add_points=DB::table('live_shop_requests')
                    ->leftjoin('store_admin','store_admin.store_admin_id','=','live_shop_requests.store_admin_id')
                    ->leftjoin('outlets','outlets.id','=','live_shop_requests.outlet_id')
                    ->leftjoin('users','users.id','=','live_shop_requests.user_id')
                    ->leftjoin('company_admin','company_admin.company_id','=','live_shop_requests.company_id')
                    ->select('live_shop_requests.id as rsid','company_admin.name as company_name','store_admin.id as store_admin_id','store_admin.name as store_boy_name','store_admin.image as store_boy_prfile_pic','outlets.outlet_location','outlets.city','live_shop_requests.rating','live_shop_requests.date','live_shop_requests.time','live_shop_requests.type')
                    ->where('live_shop_requests.user_id', '=', $stream["user_id"])
                    ->where('live_shop_requests.status','=',2)
                    ->orderBy('live_shop_requests.id','desc')
                    ->get();
        foreach($add_points as $asd){
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
                    
        if(count($add_points)!=0){
            return response()->json(['response'=>'success','calls_list'=>$add_points]); 
        }else{
            return response()->json(['response'=>'failed','message'=>'No calls found']); 
        }           
    }
    
    public function live_shop_list(Request $request){
        $stream = $request->json()->all();
        $add_points=DB::table('live_shop_requests')
                    ->leftjoin('store_admin','store_admin.store_admin_id','=','live_shop_requests.store_admin_id')
                    ->leftjoin('outlets','outlets.id','=','live_shop_requests.outlet_id')
                    ->leftjoin('users','users.id','=','live_shop_requests.user_id')
                    ->leftjoin('company_admin','company_admin.company_id','=','live_shop_requests.company_id')
                    ->select('company_admin.name as company_name','store_admin.id as store_admin_id','store_admin.name as store_boy_name','store_admin.image as store_boy_prfile_pic','outlets.outlet_location','outlets.city','live_shop_requests.rating','live_shop_requests.date','live_shop_requests.time')
                    ->where('live_shop_requests.user_id', '=', $stream["user_id"])
                    ->where('live_shop_requests.status','=',2)
                    ->orderBy('live_shop_requests.id','desc')
                    ->get();
                    
        if(count($add_points)!=0){
            return response()->json(['response'=>'success','calls_list'=>$add_points]); 
        } else{
            return response()->json(['response'=>'failed','message'=>'No calls found']); 
        }           
    }
    
    public function updates(Request $request){
        $stream = $request->json()->all();
        $date=date('Y-m-d');
        $add_points=DB::table('promo')
                    ->leftjoin('store_admin','store_admin.store_admin_id','=','promo.store_admin_id')
                    ->leftjoin('outlets','outlets.id','=','promo.outlet_id')
                    ->leftjoin('company_admin','company_admin.company_id','=','promo.company_id')
                    ->select('company_admin.name as company_name','promo.image','promo.headline','outlets.outlet_location','outlets.city','promo.start_date','promo.end_date')
                    ->where('start_date', '<=', $date)
                    ->where('end_date', '>=', $date)
                    ->get();
                    
        if(count($add_points)!=0){
            return response()->json(['response'=>'success','updates_list'=>$add_points]); 
        } else{
            return response()->json(['response'=>'failed','message'=>'No data found']); 
        }           
    }
    
    public function check_pincode_delivery_option(Request $request){
        $stream = $request->json()->all();
        $pincode=$stream['pincode'];
        $pid=$stream['product_id'];
        
        $prd=DB::table('product')
                    ->select('product.outlet_id')
                    ->where('id', '=', $pid)
                    ->first();
        $outlet= DB::table('outlets')
                    ->select('outlets.outlet_pincode','outlets.radius','outlets.served_pincode')
                    ->where('id', '=', $prd->outlet_id)
                    ->first();
        $data=explode(',',$outlet->served_pincode);
        if(in_array($pincode,$data)){
             return response()->json(['response'=>'success','message'=>'Delivery option is available.']); 
        }else{
            $zip1=$pincode;
            $zip2=$outlet->outlet_pincode;
            $url='https://maps.googleapis.com/maps/api/geocode/json?address='.$zip1.'&sensor=true_or_false&key=AIzaSyDDSLtnVcQB2m-9gtvjOyWkXavPBXx5SX8';
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_TIMEOUT, 30);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            
            $json=curl_exec($curl);
            $decode=json_decode($json,true);
            $result1[]=$decode['results'][0];
            $result2[]=$result1[0]['geometry'];
            $result3[]=$result2[0]['location'];
            
            $url1='https://maps.googleapis.com/maps/api/geocode/json?address='.$zip2.'&sensor=true_or_false&key=AIzaSyDDSLtnVcQB2m-9gtvjOyWkXavPBXx5SX8';
            $curl1 = curl_init($url1);
            curl_setopt($curl1, CURLOPT_POST, true);
            curl_setopt($curl1, CURLOPT_POSTFIELDS, true);
            curl_setopt($curl1, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl1, CURLOPT_HEADER, false);
            curl_setopt($curl1, CURLOPT_TIMEOUT, 30);
            curl_setopt($curl1, CURLOPT_SSL_VERIFYPEER, false);
            
            $json1=curl_exec($curl1);
            $decode1=json_decode($json1,true);
            $result11[]=$decode1['results'][0];
            $result21[]=$result11[0]['geometry'];
            $result31[]=$result21[0]['location'];
            
            $lat1=$result3[0]['lat'];
            $lon1=$result3[0]['lng'];
            $lat2=$result31[0]['lat'];
            $lon2=$result31[0]['lng'];
            
            $unit='km';
            $theta=$lon1-$lon2;
            $dist=sin(deg2rad((double)$lat1)) * sin(deg2rad((double)$lat2)) + cos(deg2rad((double)$lat1)) * cos(deg2rad((double)$lat2)) * cos(deg2rad((double)$theta));
            $dist=acos($dist);
            $dist=rad2deg($dist);
            $distance=round($dist * 60 * 1.1515 * 1.609344);
            if($distance < $outlet->radius){
                return response()->json(['response'=>'success','message'=>'Delivery option is available.']);
            }else{
                return response()->json(['response'=>'failed','message'=>'Delivery option is not available.']);
            }
        }
    }
    
    public function cancel_order(Request $request){
        $stream = $request->json()->all();
        $data= DB::table('transactions')->select('status')->where('order_id','=',$stream['order_id'])->where('product_id','=',$stream['product_id'])->first();
        $st=$data->status;
        if($st=='1'){
            $data=DB::table('transactions')->where('order_id','=',$stream['order_id'])->where('product_id','=',$stream['product_id'])->update(['status'=>4]);
            if($data){
                return response()->json(['response'=>'success','message'=>'Your order has been cancelled.']);
            }else{
                return response()->json(['response'=>'failed','message'=>'Try again']);
            }
        }else{
            return response()->json(['response'=>'success','message'=>'You can not cancel order']);
        }
    }
    
    public function update_fcm_user(Request $request){
        $stream = $request->json()->all();
        $fcm_token = (!empty($stream["fcm_token"])) ? $stream["fcm_token"]: '';
        
        $affected = DB::table('users')
                    ->where('id','=',$stream["user_id"])
                    ->update(['fcm_token'=>$fcm_token]);
                    
        if($affected){
            return response()->json(['response'=>'success','message'=>'Fcm token updated success']); 
        }else{
            return response()->json(['response'=>'failed','message'=>'Try again']); 
        }
    }
    
    public function store_admin_status_block(Request $request){
        $stream = $request->json()->all();
        $user_id = (!empty($stream["user_id"])) ? $stream["user_id"]: '';
        $store_admin_id = (!empty($stream["store_admin_id"])) ? $stream["store_admin_id"]: '';
        $status = (!empty($stream["status"])) ? $stream["status"]: '';
        
        $store_admin=DB::table('store_admin')->select('store_admin_id')->where('id','=',$store_admin_id)->first();
        
        $data=DB::table('blocked_store_admin')->where('user_id','=',$user_id)->where('store_admin_id','=',$store_admin->store_admin_id)->count();
        
        if($data==0){
            $pro['user_id']=$user_id;
            $pro['store_admin_id']=$store_admin->store_admin_id;
            $pro['status']=$status;
            
            $affected = DB::table('blocked_store_admin')->insert($pro);
            if($affected){
                return response()->json(['response'=>'success','message'=>'Store admin has been successfully blocked']); 
            }else{
                return response()->json(['response'=>'failed','message'=>'Try again']); 
            }
        }else{
            $affected = DB::table('blocked_store_admin')
                    ->where('user_id','=',$stream["user_id"])
                    ->where('store_admin_id','=',$store_admin->store_admin_id)
                    ->update(['status'=>$status]);
            
            if($status==1){        
                return response()->json(['response'=>'success','message'=>'Store admin has been successfully blocked']); 
            }else{
                return response()->json(['response'=>'success','message'=>'Store admin has been successfully unblocked']); 
            }
        }    
    }
}
          