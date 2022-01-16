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
class AppservicesController extends Controller
{ 
    
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
            $role = $stream["role"];
            $password = Hash::make($stream["password"]);
            
            $pro['name'] = $name;
            $pro['email'] = $email;
            $pro['mobile'] = $mobile;
            $pro['password'] = $password;
            $pro['company_name'] = $company_name;
            $pro['age'] = $age;
            $pro['gender'] = $gender;
            $pro['role'] = $role;
                
            
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
    public function login(Request $request){
        $stream = $request->json()->all();
        $fetchusr  = DB::table('users')
                    ->select('*')
                    ->where(['email'=>$stream["email"]])
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
            $pwd = $fetchusr->password;
            $a=  Hash::check($stream["password"], $pwd);
            if($fetchusr->status=='1'){
                if($a)
                {
                    return response()->json(['response'=>'success' ,'userid' =>$fetchusr->id,'name'=>$fetchusr->name,'email'=>$fetchusr->email,'mobile'=>$fetchusr->mobile,
                                            'company_name'=>$fetchusr->company_name,'age'=>$fetchusr->age,'gender'=>$fetchusr->gender]); 
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
    
    public function forgot_password_sent_otp(Request $request){
        $stream = $request->json()->all();
        
        $userinfo = DB::table('users')
                    ->select('users.id')
                    ->where('users.email', '=', $stream["email"])
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
    
    public function check_otp(Request $request){
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
    
    public function update_password(Request $request){
        $stream = $request->json()->all();
        // print_r($stream);exit;
        $email = $stream["email"];
        $password = Hash::make($stream["password"]);
        
        $up_pass=DB::table('users')
                    ->where('users.email','=',$email)
                    ->update(['users.password'=>$password]);
                    
        if($up_pass)
        {
            return response()->json(['response'=>'success','message'=>'Your Password has been changed successfully']); 
        }
        else
        {
            return response()->json(['response'=>'failed','message'=>'try again']);
        }            
    }
    
    public function change_password(Request $request){
        $stream = $request->json()->all();
        $password = Hash::make($stream["new_password"]);
        if($stream["new_password"] == $stream["confirm_password"]){
            $change_pass=DB::table('users')
                    ->where('users.id','=',$stream["userid"])
                    ->update(['users.password'=>$password]);
                    
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
                    ->select('users.name','users.email','users.mobile','users.age','users.gender','users.company_name','users.image')
                    ->where('users.id','=',$stream["userid"])
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
    
    public function edit_profile_details(Request $request){
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
    
    public function location_pincode(Request $request){
        $stream = $request->json()->all();
        
        $banner =    DB::table('banner')
                        ->select('banner.id','banner.image')
                        ->where('location','=',$stream['location'])
                        ->where('status','=',1)
                        ->get();
        
        $vouchers =  DB::table('vouchers')
                        ->select('vouchers.id','vouchers.type','vouchers.description','vouchers.off')
                        ->where('location','=',$stream['location'])
                        ->where('status','=',1)
                        ->get();              
                        
        $super_category = DB::table('super_categories')
                        ->select('super_categories.id','super_categories.name')
                        ->where('status','=',1)
                        ->get(); 
                        
        if(!empty($stream['pincode']))
        {
            return response()->json(['response'=>'success' ,'banners' =>$banner,'vouchers'=>$vouchers,'super_category'=>$super_category]); 
        }
        
        else
        {
            return response()->json(['response'=>'Failed ','message'=>'Enter Pincode or Current location.']);
        }                
    }
    
    public function fetch_category(Request $request){
        $stream = $request->json()->all();
        $id=$stream['super_category_id'];
        $fetch_category =  DB::table('categories')
                        ->select('categories.id','categories.name')
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
                        ->select('sub_categories.id','sub_categories.name')
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
    
    public function fetch_product_list(request $request){
        $stream = $request->json()->all();
        $cid=$stream['category_id'];
        $sid=$stream['sub_category_id'];
        
        if(!empty($sid)){
            $fetch_product =  DB::table('product')
                            // ->leftjoin('product_gallery','product_gallery.product_id','=','product.id')
                            ->select('product.id','product.product_name','product.store_admin_id as store_name','product.price','product.offers')
                            ->where('product.category_id','=',$cid)
                            ->where('product.subcategory_id','=',$sid)
                            ->where('product.status','=',1)
                            ->get(); 
                            
            foreach($fetch_product as $shop){
                $shop->image = DB::table('product_gallery')
                        ->select('product_image')
                        ->where('product_id','=',$shop->id)
                        ->first();
                        
                $shop->image=$shop->image;        
            }                
        }else{
            $fetch_product =  DB::table('product')
                        ->select('product.id','product.product_name','product.store_admin_id as store_name','product.price','product.offers')
                        ->where('product.category_id','=',$cid)
                        ->where('product.status','=',1)
                        ->get(); 
                        
            foreach($fetch_product as $shop){
                $shop->image = DB::table('product_gallery')
                        ->select('product_image')
                        ->where('product_id','=',$shop->id)
                        ->first();
                        
                $shop->image=$shop->image;        
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
    
    public function category_home_page(Request $request){
        $stream = $request->json()->all();
        $cid=$stream['category_id'];
        $sid=$stream['sub_category_id'];
        // print_r($stream);exit;
        
        if(!empty($sid)){
            $banner =    DB::table('sub_categories')
                        ->select('sub_categories.image')
                        ->where('id','=',$sid)
                        ->where('status','=',1)
                        ->get();
        
            $vouchers =  DB::table('vouchers')
                        ->select('vouchers.id','vouchers.type','vouchers.description','vouchers.off')
                        ->where('status','=',1)
                        ->get();
                        
            return response()->json(['response'=>'success' ,'subcategory_banner' =>$banner,'vouchers'=>$vouchers]);            
        }else{
            $banner =    DB::table('categories')
                        ->select('categories.image')
                        ->where('id','=',$cid)
                        ->where('status','=',1)
                        ->get();
        
            $vouchers =  DB::table('vouchers')
                        ->select('vouchers.id','vouchers.type','vouchers.description','vouchers.off')
                        ->where('status','=',1)
                        ->get();
                        
            return response()->json(['response'=>'success' ,'subcategory_banner' =>$banner,'vouchers'=>$vouchers]);  
        }
    }
    
    public function sort_by(Request $request){
        $stream = $request->json()->all();
        $cid=$stream['category_id'];
        $sid=$stream['sub_category_id'];
        $type=$stream['sort_by'];
        
        if(!empty($sid)){
            if($type=='new'){
                $fetch_product =  DB::table('product')
                                ->select('product.id','product.product_name','product.store_admin_id as store_name','product.price','product.offers')
                                ->where('product.category_id','=',$cid)
                                ->where('product.subcategory_id','=',$sid)
                                ->where('product.status','=',1)
                                ->orderBy('id','desc')
                                ->get(); 
                                
                foreach($fetch_product as $shop){
                    $shop->image = DB::table('product_gallery')
                            ->select('product_image')
                            ->where('product_id','=',$shop->id)
                            ->first();
                            
                    $shop->image=$shop->image;        
                } 
            }elseif($type == 'price_high_to_low'){
                $fetch_product =  DB::table('product')
                                ->select('product.id','product.product_name','product.store_admin_id as store_name','product.price','product.offers')
                                ->where('product.category_id','=',$cid)
                                ->where('product.subcategory_id','=',$sid)
                                ->where('product.status','=',1)
                                ->orderBy('price','desc')
                                ->get(); 
                                
                foreach($fetch_product as $shop){
                    $shop->image = DB::table('product_gallery')
                            ->select('product_image')
                            ->where('product_id','=',$shop->id)
                            ->first();
                            
                    $shop->image=$shop->image;        
                }
            }elseif($type == 'price_low_to_high'){
                $fetch_product =  DB::table('product')
                                ->select('product.id','product.product_name','product.store_admin_id as store_name','product.price','product.offers')
                                ->where('product.category_id','=',$cid)
                                ->where('product.subcategory_id','=',$sid)
                                ->where('product.status','=',1)
                                ->orderBy('price','asc')
                                ->get(); 
                                
                foreach($fetch_product as $shop){
                    $shop->image = DB::table('product_gallery')
                            ->select('product_image')
                            ->where('product_id','=',$shop->id)
                            ->first();
                            
                    $shop->image=$shop->image;        
                }
            }elseif($type == 'discount'){
                $fetch_product =  DB::table('product')
                                ->select('product.id','product.product_name','product.store_admin_id as store_name','product.price','product.offers')
                                ->where('product.category_id','=',$cid)
                                ->where('product.subcategory_id','=',$sid)
                                ->where('product.status','=',1)
                                ->orderBy('offers','desc')
                                ->get(); 
                                
                foreach($fetch_product as $shop){
                    $shop->image = DB::table('product_gallery')
                            ->select('product_image')
                            ->where('product_id','=',$shop->id)
                            ->first();
                            
                    $shop->image=$shop->image;        
                }
            }
        }else{
            if($type=='new'){
                $fetch_product =  DB::table('product')
                                ->select('product.id','product.product_name','product.store_admin_id as store_name','product.price','product.offers')
                                ->where('product.category_id','=',$cid)
                                ->where('product.status','=',1)
                                ->orderBy('id','desc')
                                ->get(); 
                                
                foreach($fetch_product as $shop){
                    $shop->image = DB::table('product_gallery')
                            ->select('product_image')
                            ->where('product_id','=',$shop->id)
                            ->first();
                            
                    $shop->image=$shop->image;        
                } 
            }elseif($type == 'price_high_to_low'){
                $fetch_product =  DB::table('product')
                                ->select('product.id','product.product_name','product.store_admin_id as store_name','product.price','product.offers')
                                ->where('product.category_id','=',$cid)
                                ->where('product.status','=',1)
                                ->orderBy('price','desc')
                                ->get(); 
                                
                foreach($fetch_product as $shop){
                    $shop->image = DB::table('product_gallery')
                            ->select('product_image')
                            ->where('product_id','=',$shop->id)
                            ->first();
                            
                    $shop->image=$shop->image;        
                }
            }elseif($type == 'price_low_to_high'){
                $fetch_product =  DB::table('product')
                                ->select('product.id','product.product_name','product.store_admin_id as store_name','product.price','product.offers')
                                ->where('product.category_id','=',$cid)
                                ->where('product.status','=',1)
                                ->orderBy('price','asc')
                                ->get(); 
                                
                foreach($fetch_product as $shop){
                    $shop->image = DB::table('product_gallery')
                            ->select('product_image')
                            ->where('product_id','=',$shop->id)
                            ->first();
                            
                    $shop->image=$shop->image;        
                }
            }elseif($type == 'discount'){
                $fetch_product =  DB::table('product')
                                ->select('product.id','product.product_name','product.store_admin_id as store_name','product.price','product.offers')
                                ->where('product.category_id','=',$cid)
                                ->where('product.status','=',1)
                                ->orderBy('offers','desc')
                                ->get(); 
                                
                foreach($fetch_product as $shop){
                    $shop->image = DB::table('product_gallery')
                            ->select('product_image')
                            ->where('product_id','=',$shop->id)
                            ->first();
                            
                    $shop->image=$shop->image;        
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
    
    public function product_details(Request $request){
        $stream = $request->json()->all();
        $pid=$stream['product_id'];
        $fetch_product =    DB::table('product')
                            ->select('product.company_id','product.brand_Admin_id','product.store_admin_id','product.brand_sku','product.product_name','product.price','product.offers','product.offered_price','product.description','product.specifications')
                            ->where('product.id','=',$pid)
                            ->first();
        
        $img = "images";
        
        $productimages = DB::table('product_gallery')
                            ->select('product_gallery.product_image')
                            ->where(['product_gallery.product_id'=>$pid])
                            ->get();
                    
        $fetch_product->$img = $productimages;
        
        $color = "color";
        
        $productcolor = DB::table('color')
                            ->leftjoin('product_color','product_color.color_id','=','color.id')
                            ->select('color.id as color_id','color.name')
                            ->where(['product_color.product_id'=>$pid])
                            ->get();           
        $fetch_product->$color = $productcolor;
        
        $size = "size";
        
        $productsize = DB::table('size')
                            ->leftjoin('product_size','product_size.size_id','=','size.id')
                            ->select('size.id as size_id','size.Size')
                            ->where(['product_size.product_id'=>$pid])
                            ->get();         
        $fetch_product->$size = $productsize;
       
        if(!empty($fetch_product))
        {
            return response()->json(['response'=>'success' ,'detail' =>$fetch_product]); 
        }
        else
        {
            return response()->json(['response'=>'Failed ','message'=>'No details found.']);
        }
    }
    
    public function filters(Request $request){
        $stream = $request->json()->all();
        
        if(!empty($stream['category'])){
            $catcls = $stream['category'];
        }
        else
        {
          $catcls = array('');   
        }
        
        if(!empty($stream['color'])){
            $color = $stream['color'];
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
        }
        
        if(!empty($stream['size'])){
            $size = $stream['size'];
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
            $size = array('');
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
        
        // DB::enableQueryLog();
        $fetch_product = DB::table('product')
                        ->leftjoin('sub_categories', 'product.subcategory_id', '=', 'sub_categories.id')
                        ->leftjoin('product_color','product_color.product_id','=','product.id')
                        ->leftjoin('product_size','product_size.product_id','=','product.id')
                        ->leftjoin('color', 'color.id', '=', 'product_color.color_id')
                        ->leftjoin('size', 'size.id', '=', 'product_size.size_id')
                        ->WhereIn('product.subcategory_id', $catcls)
                        ->WhereIn('product_color.color_id', $color)
                        ->WhereIn('product_size.size_id', $size)
                        ->where('product.price','>=',$minprice)->where('product.price','<=',$maxprice)->where('product.status','=',1)
                        ->groupBy('product.id')
                        ->select('product.id','product.product_name','product.store_admin_id as store_name','product.price','product.offers')
                        ->get();
        // $qwe=DB::getQueryLog();
        // print_r($qwe);exit;
        foreach($fetch_product as $shop){
            $shop->image = DB::table('product_gallery')
                    ->select('product_image')
                    ->where('product_id','=',$shop->id)
                    ->first();
                    
            $shop->image=$shop->image;        
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
                    ->select('product.offered_price')
                    ->where(['product.id'=>$pid])
                    ->first();
                    
        if(empty($chk_cart))
        {
            $cart["uid"] = $stream["user_id"];
            $cart["pid"] = $stream["product_id"];
            $cart["quantity"] = 1;
            $cart["color_id"] = $stream["color_id"];
            $cart["size_id"] = $stream["size_id"];
            $cart["product_price"]= $fetch_prd->offered_price;
            $cart["total_price"] =($fetch_prd->offered_price);
            
            $insert = DB::table('cart')->insert($cart);
            return response()->json(['response'=>'success','message'=>'Product successfully added into cart']);
        }
        else
        {
            return response()->json(['response'=>'failed','message'=>'Product is already in cart']);
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
                    ->select('product.offered_price')
                    ->where(['product.id'=>$pid])
                    ->first();
                    
        if(empty($chk_cart))
        {
            $cart["uid"] = $stream["user_id"];
            $cart["pid"] = $stream["product_id"];
            $cart["color_id"] = $stream["color_id"];
            $cart["size_id"] = $stream["size_id"];
            $cart["product_price"]= $fetch_prd->offered_price;
            $cart["total_price"] =($fetch_prd->offered_price);
            
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
                        
        if(!empty($get_wish))
        { 
            $cart["uid"] = $get_wish->uid;
            $cart["pid"] = $get_wish->pid;
            $cart["product_price"] = $get_wish->product_price;
            $cart["total_price"] = $get_wish->total_price;
            $cart["color_id"] = $get_wish->color_id;
            $cart["size_id"] = $get_wish->size_id;
            
            $get_cart = DB::table('cart')->where(['cart.uid'=>$get_wish->uid,'cart.pid'=>$get_wish->pid])->first();
            
            if(empty($get_cart)){
                $fetch_prd = DB::table('product')
                            ->select('product.offered_price')
                            ->where(['product.id'=>$get_wish->pid])
                            ->first();
                $cart["quantity"] = 1;
                $cart["product_price"] = $fetch_prd->offered_price;
                $cart["total_price"] = $fetch_prd->offered_price;
                
                $insert = DB::table('cart')->insert($cart);
                $del =DB::table('wishlist')->where('wishlist.id','=',$id)->delete();
                return response()->json(['response'=>'success','message'=>'Product successfully moved to cart']);
            }else{
                return response()->json(['response'=>'failed','message'=>'Product is already exist in cart']);
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
                    ->select('cart.id as cart_id','cart.pid as product_id','super_categories.name as super_category_name','color.name as color_name','cart.quantity','cart.total_price','product.product_name','product.company_id','product.price','product.offers','product.offered_price')
                    ->leftjoin('product', 'product.id', '=', 'cart.pid')
                    ->leftjoin('color','color.id','cart.color_id')
                    ->leftjoin('categories', 'categories.id', '=', 'product.category_id')
                    ->leftjoin('super_categories','super_categories.id','=','categories.super_category_id')
                    ->where(['cart.uid'=>$id])
                    ->groupBy('cart.id')
                    ->get();
                    
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
                    ->select('wishlist.id as wishlist_id','wishlist.pid as product_id','product.product_name','product.company_id','product.price','product.offers','product.offered_price')
                    ->leftjoin('product', 'product.id', '=', 'wishlist.pid')
                    ->where(['wishlist.uid'=>$id])
                    ->groupBy('wishlist.id')
                    ->get();
                    
        if(count($wishlist_data) !=0){
            return response()->json(['response'=>'success' ,'wish_list'=>$wishlist_data]); 
        }else{
            return response()->json(['response'=>'failed','message'=>'wishlist is empty']);
        }             
    }
    
    public function search(Request $request){
        $stream = $request->json()->all();
        $keyword = $stream["search_keyword"];
        
        if(!empty($keyword)){
        $prod_list=DB::table('product')
                ->where([['product.product_name','like','%'.$keyword.'%'],['product.status','=',1]])
                ->Orwhere([['product.search_keywords','like','%'.$keyword.'%'],['product.status','=',1]])
                ->select('product.id','product.product_name','product.store_admin_id as store_name','product.price','product.offers')
                ->get();
            return response()->json(['response'=>'success' ,'product_list'=>$prod_list]);         
        }else{
            return response()->json(['response'=>'failed' ,'message'=>'No data found']); 
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
        
        $coupon = DB::table('discounts')
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
                if($coupon->discount_type == 'fixed'){
                    $t_amount = $stream["total_amount"];
                    $c_amount =$coupon->discount_amount;
                    $new_t_amount = $t_amount-$c_amount;
                    return response()->json(['response'=>'success','total_price'=>$t_amount,'total_price_after_discount' =>$new_t_amount,'discount_price'=>$c_amount,'applied_coupon'=>$c_code]); 
                }
                else{
                    if($stream["total_amount"] >= $coupon->min_subtotal){
                        $c_amount =($stream["total_amount"])*($coupon->discount_amount / 100);
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
                    ->select('cart.id as cart_id','cart.pid as product_id','super_categories.name as super_category_name','color.name as color_name','cart.quantity','cart.total_price','product.product_name','product.company_id','product.price','product.offers','product.offered_price')
                    ->leftjoin('product', 'product.id', '=', 'cart.pid')
                    ->leftjoin('color','color.id','cart.color_id')
                    ->leftjoin('categories', 'categories.id', '=', 'product.category_id')
                    ->leftjoin('super_categories','super_categories.id','=','categories.super_category_id')
                    ->where(['cart.uid'=>$id])
                    ->groupBy('cart.id')
                    ->get();
        
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
        
        $string='';
        $srting=preg_replace('/[^a-zA-Z0-9_ -]/s',' ',$stream["address"]);
        $newstring = $srting." ".$stream["city"]." ".$stream["state"];
        if(!empty($newstring)){
            $formattedAddr = str_replace(' ','+',$newstring);
            $geocodeFromAddr = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddr.'&key=AIzaSyD9zsyZTkqWJDrw1pqHKeCPqlNwYOhnTOg');
            $output = json_decode($geocodeFromAddr);
            $clat = $output->results[0]->geometry->location->lat;
            $clng = $output->results[0]->geometry->location->lng;
        }
        
        $aorder["pay_type"] = (!empty($stream["pay_type"]))? $stream["pay_type"]: '';
        $aorder["total_amount"] = (!empty($stream["total_amount"]))? $stream["total_amount"]: '';
        $aorder["coupon_amount"] = (!empty($stream["coupon_amount"]))? $stream["coupon_amount"]: '0';
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
        $aorder["latitude"] = $clat;
        $aorder["longitude"] = $clng;
        $insertorder = DB::table('orders')->insert($aorder);
        
        $get_cart = DB::table('cart')
                    ->select('*')
                    ->where(['uid'=>$uid])
                    ->get();
        
        date_default_timezone_set('Asia/Kolkata');
    	
        foreach($get_cart as $sldt)
		{   
		    $ppid = $sldt->pid;
		    $insert_ordertxn = DB::table('transactions')->insert(['order_id'=>$aorder["order_id"],'product_id'=>$sldt->pid,'user_id'=>$sldt->uid,'qty'=>$sldt->quantity,
		    'product_amount'=>$sldt->product_price,'total_amount'=>$sldt->quantity*$sldt->product_price,'date'=>$date]);
		}
		
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
                    ->select('order_id as orderid','total_amount','delivery_status','created_at')
                    ->where(['user_id'=>$uid])
                    ->orderBy('id','desc')
                    ->get();
              
        foreach($orders as $sldt)
        {
            $datatr= DB::table('transactions')
                    ->leftjoin('product','product.id','=','transactions.product_id')
                    ->select('transactions.id as transactions_id','transactions.product_id','product.product_name',
                        'transactions.qty as quantity','transactions.product_amount','transactions.total_amount')
                    ->where(['transactions.order_id'=> $sldt->orderid])
                    ->get();
                    
            $dat[] = array('date'=>date('Y-m-d',strtotime($sldt->created_at)),'total_amount'=>$sldt->total_amount,'order_id'=>$sldt->orderid,'detail'=>$datatr);
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
    
}