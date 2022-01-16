<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Storage;
use DB;
use auth;
use Illuminate\Support\Facades\Hash;

class StoreAdminController extends Controller
{
    public function index(){
        $uid=auth::user()->id;
        $com_id= DB::table('company_admin')->select('company_admin.company_id')->where('id','=',$uid)->first();
        $company_id=$com_id->company_id;
        $users1 = DB::table('store_admin')->select('store_admin.*')->where("company_admin_id", "like","%".$company_id."%")->orderBy('store_admin.id','desc')->get();
        return view('storeadminlist',['users1'=>$users1]);
    }
    
    public function create()
    {
        $country = DB::table('countries')->select('countries.*')->get();                
        $uid=auth::user()->id;
        $com_id= DB::table('company_admin')->select('company_admin.company_id')->where('id','=',$uid)->first();
        $company_id=$com_id->company_id;
        $brand = DB::table('brand_admin')->select('brand_admin.brand_admin_id')->where("company_id", "like","%".$company_id."%")->where('status','=',1)->get();  
        return view('add_store_admin_form',['country'=>$country,'brand'=>$brand]);
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=>'required',
            'email'=>'required',
            'password'=>'required',
            'phone'=>'required',
            'age'=>'required',
            'gender'=>'required',
            'country'=>'required',
            'state'=>'required',
            'city'=>'required',
            'position'=>'required',
            'role'=>'required'
        ]);
        $name = (!empty($request->input('name'))) ? $request->input('name') : '';
        $email = (!empty($request->input('email'))) ? $request->input('email') : '';
        $password = (!empty($request->input('password'))) ? $request->input('password') : '';
        $phone = (!empty($request->input('phone'))) ? $request->input('phone') : '';
        $age = (!empty($request->input('age'))) ? $request->input('age') : '';
        $gender = (!empty($request->input('gender'))) ? $request->input('gender') : '';
        $country = (!empty($request->input('country'))) ? $request->input('country') : '';
        $state = (!empty($request->input('state'))) ? $request->input('state') : '';
        $city = (!empty($request->input('city'))) ? $request->input('city') : '';
        $position = (!empty($request->input('position'))) ? $request->input('position') : '';
        $role = implode(',',$request->input('role'));
        $uid=auth::user()->id;
        $com_id= DB::table('company_admin')->select('company_admin.company_id')->where('id','=',$uid)->first();
        $company_id=$com_id->company_id;
        $brand_admin_id=(!empty($request->input('brand_admin_id'))) ? $request->input('brand_admin_id') : '';
        
        $result1 = substr($city, 0, 2);
        $result2 = substr($name, 0, 2);
        $result3 = substr($phone,-4);
        $store_admin_id = $result1.'-'.$result2.'-'.$result3;
        
        $insert = DB::table('store_admin')->insert([
            'company_admin_id'=>$company_id,
            'city_brand_admin_id' => $brand_admin_id,
            'store_admin_id'=>$store_admin_id,
            'name' => $name,
            'email'=>$email,
            'phone' => $phone,
            'position'=>$position,
            'country'=>$country,
            'state' => $state,
            'city'=>$city,
            'age'=>$age,
            'gender' => $gender,
            'role'=>$role,
            'password'=>Hash::make($password)
        ]);
        return redirect()->route('store-admin')->with('success','Store admin has been added successfully.');
    }
    
    public function delete($id)
    {
        $insert = DB::table('store_admin')->where('id','=',$id)->delete();
        return redirect()->route('store-admin')->with('success','Store admin has been deleted successfully.');  
    }

    public function edit($id)
    {
        $edituser = DB::table('store_admin')
                    ->select('*')
                    ->where('id', '=',$id)
                    ->first();
                    
        $country = DB::table('countries')->select('countries.*')->get();                
        $uid=auth::user()->id;
        $com_id= DB::table('company_admin')->select('company_admin.company_id')->where('id','=',$uid)->first();
        $company_id=$com_id->company_id;
        $brand = DB::table('brand_admin')->select('brand_admin.brand_admin_id')->where("company_id", "like","%".$company_id."%")->where('status','=',1)->get();
        return view('store_admin_form_edit',['edituser'=>$edituser,'country'=>$country,'brand'=>$brand]);
    }
    
    public function update(Request $request)
    {
        $id = (!empty($request->input('id'))) ? $request->input('id') : '';
        $name = (!empty($request->input('name'))) ? $request->input('name') : '';
        $email = (!empty($request->input('email'))) ? $request->input('email') : '';
        $phone = (!empty($request->input('phone'))) ? $request->input('phone') : '';
        $age = (!empty($request->input('age'))) ? $request->input('age') : '';
        $gender = (!empty($request->input('gender'))) ? $request->input('gender') : '';
        $country = (!empty($request->input('country'))) ? $request->input('country') : '';
        $state = (!empty($request->input('state'))) ? $request->input('state') : '';
        $city = (!empty($request->input('city'))) ? $request->input('city') : '';
        $position = (!empty($request->input('position'))) ? $request->input('position') : '';
        $uid=auth::user()->id;
        $com_id= DB::table('company_admin')->select('company_admin.company_id')->where('id','=',$uid)->first();
        $company_id=$com_id->company_id;
        $brand_admin_id=(!empty($request->input('brand_admin_id'))) ? $request->input('brand_admin_id') : '';
        $role = implode(',',$request->input('role'));
        $result1 = substr($city, 0, 2);
        $result2 = substr($name, 0, 2);
        $result3 = substr($phone,-4);
        $store_admin_id = $result1.'-'.$result2.'-'.$result3;
        
        $insert = DB::table('store_admin')->where('id','=',$id)->update([
            'company_admin_id'=>$company_id,
            'city_brand_admin_id' => $brand_admin_id,
            'store_admin_id'=>$store_admin_id,
            'name' => $name,
            'email'=>$email,
            'phone' => $phone,
            'position'=>$position,
            'country'=>$country,
            'state' => $state,
            'city'=>$city,
            'age'=>$age,
            'gender' => $gender,
            'role'=>$role,
            
        ]);
        return redirect()->route('store-admin')->with('success','Store Admin has been updated successfully.');
    }
    
    public function changesadminstatus1($id){
        $insert = DB::table('store_admin')->where('id','=',$id)->update([
            'status' => 1
        ]);
        return redirect()->back()->with('success','Status has been updated successfully.');
    }

    public function changesadminstatus2($id){
        $insert = DB::table('store_admin')->where('id','=',$id)->update([
            'status' => 2
        ]);
        return redirect()->back()->with('success','Status has been updated successfully.');
    }
}
