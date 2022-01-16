<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Storage;
use DB;
use Illuminate\Support\Facades\Hash;
use auth;

class OutletController extends Controller
{
    public function index(){
        $uid=auth::user()->id;
        $brand_id= DB::table('brand_admin')->select('brand_admin.brand_admin_id')->where('id','=',$uid)->first();
        $brand_admin_id=$brand_id->brand_admin_id;
        $users1 = DB::table('outlets')->select('outlets.*')->where("brand_admin_id", "like","%".$brand_admin_id."%")->orderBy('outlets.id','desc')->get();
        return view('outletlist',['users1'=>$users1,]);
    }
    
    public function create()
    {
        $country = DB::table('countries')->select('countries.*')->get();                
        $company = DB::table('company_admin')->select('company_admin.company_id')->where('status','=',1)->get();
        $brand = DB::table('brand_admin')->select('brand_admin.brand_admin_id')->where('status','=',1)->get(); 
        $pin = DB::table('cities_pincode')->select('cities_pincode.*')->get();
        return view('add_outlet_form',['country'=>$country,'company'=>$company,'brand'=>$brand,'pin'=>$pin]);
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'country'=>'required',
            'state'=>'required',
            'city'=>'required',
            'pincode'=>'required',
            'outlet_location'=>'required',
            'outlet_pincode'=>'required',
            'pincode'=>'required',
            'radius'=>'required'
        ]);
        
        $uid=auth::user()->id;
        $brand_id= DB::table('brand_admin')->select('brand_admin.brand_admin_id','brand_admin.company_id')->where('id','=',$uid)->first();
        $brand_admin_id=$brand_id->brand_admin_id;
        $company_admin_id = $brand_id->company_id;
        $country = (!empty($request->input('country'))) ? $request->input('country') : '';
        $state = (!empty($request->input('state'))) ? $request->input('state') : '';
        $city = (!empty($request->input('city'))) ? $request->input('city') : '';
        $outlet_location = (!empty($request->input('outlet_location'))) ? $request->input('outlet_location') : '';
        $outlet_pincode = (!empty($request->input('outlet_pincode'))) ? $request->input('outlet_pincode') : '';
        $pincode = implode(',',$request->input('pincode'));
        $radius = (!empty($request->input('radius'))) ? $request->input('radius') : '';
        
        $insert = DB::table('outlets')->insert([
            'company_id'=>$company_admin_id,
            'brand_admin_id' => $brand_admin_id,
            'country'=>$country,
            'state' => $state,
            'city'=>$city,
            'served_pincode' => $pincode,
            'outlet_location'=>$outlet_location,
            'outlet_pincode'=>$outlet_pincode,
            'radius'=>$radius
        ]);
        return redirect()->route('outlet')->with('success','Outlet has been added successfully.');
    }
    
    public function delete($id)
    {
        $insert = DB::table('outlets')->where('id','=',$id)->delete();
        return redirect()->route('store-admin')->with('success','Outlet has been deleted successfully.');  
    }
    
    public function deleteMultiple(Request $request){
        $ids = $request->ids;
        DB::table('outlets')->whereIn('id',explode(",",$ids))->delete();
        return redirect()->back()->with('success','Selected outlets has been deleted successfully.');  
    }

    public function edit($id)
    {
        $edituser = DB::table('outlets')
                    ->select('*')
                    ->where('id', '=',$id)
                    ->first();
        $country = DB::table('countries')->select('countries.*')->get();                
        $company = DB::table('company_admin')->select('company_admin.company_id')->where('status','=',1)->get();
        $brand = DB::table('brand_admin')->select('brand_admin.brand_admin_id')->where('status','=',1)->get(); 
        $pin = DB::table('cities_pincode')->select('cities_pincode.*')->get();
        $dis_explode=explode(",",$edituser->served_pincode);
        return view('outlet_form_edit',['country'=>$country,'company'=>$company,'brand'=>$brand,'edituser'=>$edituser,'pin'=>$pin,'dis_explodes'=>$dis_explode]);
    }
    
    public function update(Request $request)
    {
        $id = (!empty($request->input('id'))) ? $request->input('id') : '';
        $country = (!empty($request->input('country'))) ? $request->input('country') : '';
        $state = (!empty($request->input('state'))) ? $request->input('state') : '';
        $city = (!empty($request->input('city'))) ? $request->input('city') : '';
        $outlet_location = (!empty($request->input('outlet_location'))) ? $request->input('outlet_location') : '';
        $outlet_pincode = (!empty($request->input('outlet_pincode'))) ? $request->input('outlet_pincode') : '';
        $pincode = implode(',',$request->input('pincode'));
        $radius = (!empty($request->input('radius'))) ? $request->input('radius') : '';
        $uid=auth::user()->id;
        $brand_id= DB::table('brand_admin')->select('brand_admin.brand_admin_id','brand_admin.company_id')->where('id','=',$uid)->first();
        $brand_admin_id=$brand_id->brand_admin_id;
        $company_admin_id = $brand_id->company_id;
        $insert = DB::table('outlets')->where('id','=',$id)->update([
            'company_id'=>$company_admin_id,
            'brand_admin_id' => $brand_admin_id,
            'country'=>$country,
            'state' => $state,
            'city'=>$city,
            'served_pincode' => $pincode,
            'outlet_location'=>$outlet_location,
            'outlet_pincode'=>$outlet_pincode,
            'radius'=>$radius
            
        ]);
        return redirect()->route('outlet')->with('success','Outlet has been updated successfully.');
    }
    
    public function changeoutstatus1($id){
        $insert = DB::table('outlets')->where('id','=',$id)->update([
            'status' => 1
        ]);
        return redirect()->back()->with('success','Status has been updated successfully.');
    }

    public function changeoutstatus2($id){
        $insert = DB::table('outlets')->where('id','=',$id)->update([
            'status' => 2
        ]);
        return redirect()->back()->with('success','Status has been updated successfully.');
    }
    
    public function lision(){
        $uid=auth::user()->id;
        $brand_id= DB::table('brand_admin')->select('brand_admin.brand_admin_id')->where('id','=',$uid)->first();
        $brand_admin_id=$brand_id->brand_admin_id;
        $users1 = DB::table('outlets')->select('outlets.*')->where("brand_admin_id", "like","%".$brand_admin_id."%")->where('status','=',1)->get();
        $users2 = DB::table('store_admin')->select('store_admin.*')->where("city_brand_admin_id", "like","%".$brand_admin_id."%")->where('status','=',1)->get();
        return view('assign_lision',['outlet'=>$users1,'store'=>$users2]);
    }
    
    public function assign(Request $request){
        $this->validate($request, [
            'store_admin'=>'required'
        ]);
        
        $id=(!empty($request->input('outlet_id'))) ? $request->input('outlet_id') : '';
        $store_admin = implode(',',$request->store_admin);
        
        $insert = DB::table('outlets')->where('id','=',$id)->update([
            'store_admin_id'=>$store_admin 
        ]);
        
        return redirect()->back()->with('success','Store admin has been assigned successfully.');
    }
}
