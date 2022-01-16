<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Storage;
use DB;
use Illuminate\Support\Facades\Hash;

class CompanyController extends Controller
{
    public function index(){
        $users1 = DB::table('company_admin')->select('company_admin.*')->orderBy('company_admin.id','desc')->get();
        return view('companylist',['users1'=>$users1]);
    }
    
    public function create()
    {
        $country = DB::table('countries')->select('countries.*')->get();
        $pin = DB::table('cities_pincode')->select('cities_pincode.*')->get();
        $supcat = DB::table('super_categories')->select('super_categories.*')->where('status','=',1)->get();
        $cat = DB::table('categories')->select('categories.*')->where('status','=',1)->get();
        $subcat = DB::table('sub_categories')->select('sub_categories.*')->where('status','=',1)->get();
        return view('add_company_form',['country'=>$country,'pin'=>$pin,'supcat'=>$supcat,'cat'=>$cat,'subcat'=>$subcat]);
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=>'required',
            'brand_name'=>'required',
            'password'=>'required',
            'short_name'=>'required',
            'contact_name'=>'required',
            'contact_mobile'=>'required',
            'email'=>'required',
            'country'=>'required',
            'state'=>'required',
            'city'=>'required',
            'address'=>'required',
            'website'=>'required',
            'pincode'=>'required',
            'radius'=>'required',
            'image'=>'required',
            'company_info'=>'required',
            'quick_shop'=>'required',
            'online_shop'=>'required',
            'video_minutes'=>'required',
            'audio_minutes'=>'required',
            'commision'=>'required',
            'store_price'=>'required',
            'reserve_video_minutes'=>'required',
            'reserve_audio_minutes'=>'required',
            'quick_click'=>'required',
            'online_click'=>'required',
            'quick_point'=>'required',
            'online_point'=>'required'
        ]);
        $name = (!empty($request->input('name'))) ? $request->input('name') : '';
        $email = (!empty($request->input('email'))) ? $request->input('email') : '';
        $brand_name = (!empty($request->input('brand_name'))) ? $request->input('brand_name') : '';
        $password = (!empty($request->input('password'))) ? $request->input('password') : '';
        $short_name = (!empty($request->input('short_name'))) ? $request->input('short_name') : '';
        $contact_name = (!empty($request->input('contact_name'))) ? $request->input('contact_name') : '';
        $contact_mobile = (!empty($request->input('contact_mobile'))) ? $request->input('contact_mobile') : '';
        $address = (!empty($request->input('address'))) ? $request->input('address') : '';
        $website = (!empty($request->input('website'))) ? $request->input('website') : '';
        $radius = (!empty($request->input('radius'))) ? $request->input('radius') : '';
        $country = (!empty($request->input('country'))) ? $request->input('country') : '';
        $state = (!empty($request->input('state'))) ? $request->input('state') : '';
        $city = (!empty($request->input('city'))) ? $request->input('city') : '';
        $pincode = (!empty($request->input('pincode'))) ? $request->input('pincode') : '';
        $quick = (!empty($request->input('quick_shop'))) ? $request->input('quick_shop') : '';
        $online = (!empty($request->input('online_shop'))) ? $request->input('online_shop') : '';
        $video = (!empty($request->input('video_minutes'))) ? $request->input('video_minutes') : '';
        $audio = (!empty($request->input('audio_minutes'))) ? $request->input('audio_minutes') : '';
        $quick_click = (!empty($request->input('quick_click'))) ? $request->input('quick_click') : '';
        $online_click = (!empty($request->input('online_click'))) ? $request->input('online_click') : '';
        $quick_point = (!empty($request->input('quick_point'))) ? $request->input('quick_point') : '';
        $online_point = (!empty($request->input('online_point'))) ? $request->input('online_point') : '';
        $commision = (!empty($request->input('commision'))) ? $request->input('commision') : '';
        $acc_number = (!empty($request->input('acc_number'))) ? $request->input('acc_number') : '';
        $cacc_number = (!empty($request->input('cacc_number'))) ? $request->input('cacc_number') : '';
        $beneficiary_name = (!empty($request->input('beneficiary_name'))) ? $request->input('beneficiary_name') : '';
        $ifsc_code = (!empty($request->input('ifsc_code'))) ? $request->input('ifsc_code') : '';
        $bank_name = (!empty($request->input('bank_name'))) ? $request->input('bank_name') : '';
        $store_price = (!empty($request->input('store_price'))) ? $request->input('store_price') : '';
        $reserve_video_minutes = (!empty($request->input('reserve_video_minutes'))) ? $request->input('reserve_video_minutes') : '';
        $reserve_audio_minutes = (!empty($request->input('reserve_audio_minutes'))) ? $request->input('reserve_audio_minutes') : '';
        $gst_number = (!empty($request->input('gst_number'))) ? $request->input('gst_number') : '';
        $dimension = (!empty($request->input('dimension'))) ? $request->input('dimension') : 'No';
        $weight = (!empty($request->input('weight'))) ? $request->input('weight') : 'No';
        $height = (!empty($request->input('height'))) ? $request->input('height') : 'No';
        $width = (!empty($request->input('width'))) ? $request->input('width') : 'No';
        $length = (!empty($request->input('length'))) ? $request->input('length') : 'No';
        $color = (!empty($request->input('color'))) ? $request->input('color') : 'No';
        $size = (!empty($request->input('size'))) ? $request->input('size') : 'No';
        $company_info = (!empty($request->input('company_info'))) ? $request->input('company_info') : '';
        
        // $supcat = implode(',',$request->input('super_category'));
        $cat = implode(',',$request->input('category'));
        $subcat = implode(',',$request->input('sub_category'));
        $fileContents = $request->image;
        $dt = Storage::disk('custom')->put('/',$fileContents);
        
        $insert = DB::table('company_admin')->insert([
            'company_id' => $short_name,
            'name' => $name,
            'brand_name'=>$brand_name,
            'address'=>$address,
            'website'=>$website,
            'contact_name'=>$contact_name,
            'contact_mobile'=>$contact_mobile,
            'email'=>$email,
            'radius'=>$radius,
            'country'=>$country,
            'state'=>$state,
            'city'=>$city,
            'pincode' => $pincode,
            'password'=>Hash::make($password),
            'company_logo'=>$dt,
            'company_info'=>$company_info,
            'quick_shop'=>$quick,
            'online_shop'=>$online,
            'quick_click'=>$quick_click,
            'online_click'=>$online_click,
            'quick_point'=>$quick_point,
            'online_point'=>$online_point,
            'video_minutes'=>$video,
            'audio_minutes'=>$audio,
            'commision'=>$commision,
            'store_price'=>$store_price,
            'reserve_video_minutes'=>$reserve_video_minutes,
            'reserve_audio_minutes'=>$reserve_audio_minutes,
            'gst_number'=>$gst_number,
            'account_number'=>$acc_number,
            'beneficiary_name'=>$beneficiary_name,
            'ifsc_code'=>$ifsc_code,
            'bank_name'=>$bank_name,
            'dimension' => $dimension,
            'weight' => $weight,
            'height'=>$height,
            'width'=>$width,
            'length'=>$length,
            'color'=>$color,
            'size'=>$size,
            // 'super_category_id'=>$supcat,
            'category_id'=>$cat,
            'subcategory_id'=>$subcat
            
        ]);
        return redirect()->route('company')->with('success','Company has been added successfully.');
    }
    
    public function delete($id)
    {
        $insert = DB::table('company_admin')->where('id','=',$id)->delete();
        return redirect()->route('company')->with('success','Company has been deleted successfully.');  
    }
    
    public function deleteMultiple(Request $request){
        $ids = $request->ids;
        DB::table('company_admin')->whereIn('id',explode(",",$ids))->delete();
        return redirect()->back()->with('success','Selected companies has been deleted successfully.');  
    }

    public function edit($id)
    {
        $edituser = DB::table('company_admin')
                    ->select('*')
                    ->where('id', '=',$id)
                    ->first();
        $country = DB::table('countries')->select('countries.*')->get(); 
        $pin = DB::table('cities_pincode')->select('cities_pincode.*')->get();
        $supcat = DB::table('super_categories')->select('super_categories.*')->get();
        $cat = DB::table('categories')->select('categories.*')->get();
        $subcat = DB::table('sub_categories')->select('sub_categories.*')->get();
        
        return view('company_form_edit',['edituser'=>$edituser,'country'=>$country,'pin'=>$pin,'supcat'=>$supcat,'cat'=>$cat,'subcat'=>$subcat]);
    }
    
    public function update(Request $request)
    {
        $id = (!empty($request->input('id'))) ? $request->input('id') : '';
        $name = (!empty($request->input('name'))) ? $request->input('name') : '';
        $email = (!empty($request->input('email'))) ? $request->input('email') : '';
        $brand_name = (!empty($request->input('brand_name'))) ? $request->input('brand_name') : '';
        $short_name = (!empty($request->input('short_name'))) ? $request->input('short_name') : '';
        $contact_name = (!empty($request->input('contact_name'))) ? $request->input('contact_name') : '';
        $contact_mobile = (!empty($request->input('contact_mobile'))) ? $request->input('contact_mobile') : '';
        $address = (!empty($request->input('address'))) ? $request->input('address') : '';
        $website = (!empty($request->input('website'))) ? $request->input('website') : '';
        $radius = (!empty($request->input('radius'))) ? $request->input('radius') : '';
        $country = (!empty($request->input('country'))) ? $request->input('country') : '';
        $state = (!empty($request->input('state'))) ? $request->input('state') : '';
        $city = (!empty($request->input('city'))) ? $request->input('city') : '';
        $pincode = (!empty($request->input('pincode'))) ? $request->input('pincode') : '';
        $quick = (!empty($request->input('quick_shop'))) ? $request->input('quick_shop') : '';
        $online = (!empty($request->input('online_shop'))) ? $request->input('online_shop') : '';
        $quick_click = (!empty($request->input('quick_click'))) ? $request->input('quick_click') : '';
        $online_click = (!empty($request->input('online_click'))) ? $request->input('online_click') : '';
        $quick_point = (!empty($request->input('quick_point'))) ? $request->input('quick_point') : '';
        $online_point = (!empty($request->input('online_point'))) ? $request->input('online_point') : '';
        $video = (!empty($request->input('video_minutes'))) ? $request->input('video_minutes') : '';
        $audio = (!empty($request->input('audio_minutes'))) ? $request->input('audio_minutes') : '';
        $commision = (!empty($request->input('commision'))) ? $request->input('commision') : '';
        $acc_number = (!empty($request->input('acc_number'))) ? $request->input('acc_number') : '';
        $cacc_number = (!empty($request->input('cacc_number'))) ? $request->input('cacc_number') : '';
        $beneficiary_name = (!empty($request->input('beneficiary_name'))) ? $request->input('beneficiary_name') : '';
        $ifsc_code = (!empty($request->input('ifsc_code'))) ? $request->input('ifsc_code') : '';
        $bank_name = (!empty($request->input('bank_name'))) ? $request->input('bank_name') : '';
        $store_price = (!empty($request->input('store_price'))) ? $request->input('store_price') : '';
        $reserve_video_minutes = (!empty($request->input('reserve_video_minutes'))) ? $request->input('reserve_video_minutes') : '';
        $reserve_audio_minutes = (!empty($request->input('reserve_audio_minutes'))) ? $request->input('reserve_audio_minutes') : '';
        $gst_number = (!empty($request->input('gst_number'))) ? $request->input('gst_number') : '';
        $dimension = (!empty($request->input('dimension'))) ? $request->input('dimension') : 'No';
        $weight = (!empty($request->input('weight'))) ? $request->input('weight') : 'No';
        $height = (!empty($request->input('height'))) ? $request->input('height') : 'No';
        $width = (!empty($request->input('width'))) ? $request->input('width') : 'No';
        $length = (!empty($request->input('length'))) ? $request->input('length') : 'No';
        $color = (!empty($request->input('color'))) ? $request->input('color') : 'No';
        $size = (!empty($request->input('size'))) ? $request->input('size') : 'No';
        $company_info = (!empty($request->input('company_info'))) ? $request->input('company_info') : '';
        
        // $supcat = implode(',',$request->input('super_category'));
        $cat = implode(',',$request->input('category'));
        $subcat = implode(',',$request->input('sub_category'));
        $selctdt = DB::table('company_admin')->select('company_admin.company_logo')->where('id','=',$id)->first();
         if(!empty($request->image)){
              $fileContents = $request->image;
              $dt = Storage::disk('custom')->put('/',$fileContents);
        }
        else
        {
           $dt =(!empty($selctdt->company_logo))? $selctdt->company_logo : '';   
        }
        $insert = DB::table('company_admin')->where('id','=',$id)->update([
            'company_id' => $short_name,
            'name' => $name,
            'brand_name'=>$brand_name,
            'address'=>$address,
            'website'=>$website,
            'contact_name'=>$contact_name,
            'contact_mobile'=>$contact_mobile,
            'email'=>$email,
            'radius'=>$radius,
            'country'=>$country,
            'state'=>$state,
            'city'=>$city,
            'pincode' => $pincode,
            'company_logo'=>$dt,
            'company_info'=>$company_info,
            'quick_shop'=>$quick,
            'online_shop'=>$online,
            'quick_click'=>$quick_click,
            'online_click'=>$online_click,
            'quick_point'=>$quick_point,
            'online_point'=>$online_point,
            'video_minutes'=>$video,
            'audio_minutes'=>$audio,
            'commision'=>$commision,
            'store_price'=>$store_price,
            'reserve_video_minutes'=>$reserve_video_minutes,
            'reserve_audio_minutes'=>$reserve_audio_minutes,
            'gst_number'=>$gst_number,
            'account_number'=>$acc_number,
            'beneficiary_name'=>$beneficiary_name,
            'ifsc_code'=>$ifsc_code,
            'bank_name'=>$bank_name,
            'dimension' => $dimension,
            'weight' => $weight,
            'height'=>$height,
            'width'=>$width,
            'length'=>$length,
            'color'=>$color,
            'size'=>$size,
            // 'super_category_id'=>$supcat,
            'category_id'=>$cat,
            'subcategory_id'=>$subcat
            
        ]);
        return redirect()->route('company')->with('success','Company has been updated successfully.');
    }
    
    public function changecomstatus1($id){
        $insert = DB::table('company_admin')->where('id','=',$id)->update([
            'status' => 1
        ]);
        return redirect()->back()->with('success','Status has been updated successfully.');
    }

    public function changecomstatus2($id){
        $insert = DB::table('company_admin')->where('id','=',$id)->update([
            'status' => 2
        ]);
        return redirect()->back()->with('success','Status has been updated successfully.');
    }
}
