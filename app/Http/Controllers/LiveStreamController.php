<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Storage;
use DB;

class LiveStreamController extends Controller
{

    public function create()
    {         
        $company = DB::table('company_admin')->select('company_admin.company_id')->where('status','=',1)->get();
        $store = DB::table('store_admin')->select('store_admin.store_admin_id')->where('status','=',1)->get();
        $city = DB::table('banner_cities')->select('banner_cities.*')->where('status','=',1)->get();
        return view('add_live_stream_form',['company'=>$company,'store'=>$store,'city'=>$city]);
    }
    public function create1()
    {         
        $company = DB::table('company_admin')->select('company_admin.company_id')->where('status','=',1)->get();
        $store = DB::table('store_admin')->select('store_admin.store_admin_id')->where('status','=',1)->get();
        $city = DB::table('banner_cities')->select('banner_cities.*')->where('status','=',1)->get();
        return view('add_promo_form',['company'=>$company,'store'=>$store,'city'=>$city]);
    } 
    public function create2()
    {         
        $company = DB::table('company_admin')->select('company_admin.company_id')->where('status','=',1)->get();
        $store = DB::table('store_admin')->select('store_admin.store_admin_id')->where('status','=',1)->get();
        $city = DB::table('banner_cities')->select('banner_cities.*')->where('status','=',1)->get();
        return view('add_team_updates_form',['company'=>$company,'store'=>$store,'city'=>$city]);
    } 
    
    public function storelive(Request $request){
        $this->validate($request, [
            'assign_phone'=>'required',
            'assign_email'=>'required',
            'code'=>'required',
            'city'=>'required',
            'date'=>'required',
            'time'=>'required',
            'gender'=>'required',
            'promo_name'=>'required',
            'headline'=>'required',
            'message'=>'required',
            'image'=>'required',
            'image.*' => 'image|mimes:jpeg,png,jpg|max:2048'
            
        ]);
        
        $company_admin_id=(!empty($request->input('company_id'))) ? $request->input('company_id') : '';
        $store_id=(!empty($request->input('store_id'))) ? $request->input('store_id') : '';
        $assign_phone= (!empty($request->input('assign_phone'))) ? $request->input('assign_phone') : '';
        $assign_email= (!empty($request->input('assign_email'))) ? $request->input('assign_email') : '';
        $city = (!empty($request->input('city'))) ? $request->input('city') : '';
        $code = (!empty($request->input('code'))) ? $request->input('code') : '';
        $date = (!empty($request->input('date'))) ? $request->input('date') : '';
        $time = (!empty($request->input('time'))) ? $request->input('time') : '';
        $gender = (!empty($request->input('gender'))) ? $request->input('gender') : '';
        $promo_name = (!empty($request->input('promo_name'))) ? $request->input('promo_name') : '';
        $headline = (!empty($request->input('headline'))) ? $request->input('headline') : '';
        $message = (!empty($request->input('message'))) ? $request->input('message') : '';
        
        $fileContents = $request->image;
        $dt = Storage::disk('custom')->put('/',$fileContents);
        
        $insert = DB::table('store_stream')->insert([
            'company_id'=>$company_admin_id,
            'store_admin_id' => $store_id,
            'phone'=>$assign_phone,
            'email' => $assign_email,
            'city'=>$city,
            'code' => $code,
            'date'=>$date,
            'time'=>$time,
            'gender'=>$gender,
            'promo_name'=>$promo_name,
            'title'=>$headline,
            'description'=>$message,
            'image'=>$dt
        ]);
        return redirect()->back()->with('success','Live stream has been added successfully.');
    }
}
