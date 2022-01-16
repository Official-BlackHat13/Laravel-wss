<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Storage;
use DB;
use Illuminate\Support\Facades\Hash;

class BrandAdminController extends Controller
{
    public function index(){
        $users1 = DB::table('brand_admin')->select('brand_admin.*')->orderBy('brand_admin.id','desc')->get();
        return view('brandadminlist',['users1'=>$users1]);
    }
    
    public function create()
    {
        $city = DB::table('cities')->select('cities.*')->where('status','=',1)->orderBy('cities.id','desc')->get();
        $pin = DB::table('cities_pincode')->select('cities_pincode.*')->get();
        return view('add_brand_admin_form',['city'=>$city,'pin'=>$pin]);
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
            'state'=>'required',
            'city'=>'required',
            'pincode'=>'required',
            'position'=>'required'
        ]);
        $name = (!empty($request->input('name'))) ? $request->input('name') : '';
        $email = (!empty($request->input('email'))) ? $request->input('email') : '';
        $password = (!empty($request->input('password'))) ? $request->input('password') : '';
        $phone = (!empty($request->input('phone'))) ? $request->input('phone') : '';
        $age = (!empty($request->input('age'))) ? $request->input('age') : '';
        $gender = (!empty($request->input('gender'))) ? $request->input('gender') : '';
        $state = (!empty($request->input('state'))) ? $request->input('state') : '';
        $city = (!empty($request->input('city'))) ? $request->input('city') : '';
        $pincode = implode(',',$request->input('pincode'));
        $position = (!empty($request->input('position'))) ? $request->input('position') : '';
        
        $result1 = substr($city, 0, 2);
        $result2 = substr($name, 0, 2);
        $result3 = substr($phone,-4);
        $brand_admin_id = $result1.'-'.$result2.'-'.$result3;
        
        $insert = DB::table('brand_admin')->insert([
            'company_id' => '',
            'brand_admin_id'=>$brand_admin_id,
            'name' => $name,
            'email'=>$email,
            'phone' => $phone,
            'position'=>$position,
            'state' => $state,
            'city'=>$city,
            'pincodes_managed' => $pincode,
            'age'=>$age,
            'gender' => $gender,
            'password'=>Hash::make($password)
        ]);
        return redirect()->route('brand-admin')->with('success','Brand admin has been added successfully.');
    }
    
    public function delete($id)
    {
        $insert = DB::table('brand_admin')->where('id','=',$id)->delete();
        return redirect()->route('brand-admin')->with('success','Brand admin has been deleted successfully.');  
    }

    public function edit($id)
    {
        $edituser = DB::table('brand_admin')
                    ->select('*')
                    ->where('id', '=',$id)
                    ->first();
        $city = DB::table('cities')->select('cities.*')->orderBy('cities.id','desc')->where('status','=',1)->groupBy('id')->get();
        $pin = DB::table('cities_pincode')->select('cities_pincode.*')->get(); 
        
        $dis_explode=explode(",",$edituser->pincodes_managed);
        return view('brand_admin_form_edit',['edituser'=>$edituser,'pin'=>$pin,'city'=>$city,'dis_explodes'=>$dis_explode]);
    }
    
    public function update(Request $request)
    {
        $id = (!empty($request->input('id'))) ? $request->input('id') : '';
        $name = (!empty($request->input('name'))) ? $request->input('name') : '';
        $email = (!empty($request->input('email'))) ? $request->input('email') : '';
        $phone = (!empty($request->input('phone'))) ? $request->input('phone') : '';
        $age = (!empty($request->input('age'))) ? $request->input('age') : '';
        $gender = (!empty($request->input('gender'))) ? $request->input('gender') : '';
        $state = (!empty($request->input('state'))) ? $request->input('state') : '';
        $city = (!empty($request->input('city'))) ? $request->input('city') : '';
        $pincode = implode(',',$request->input('pincode'));
        $position = (!empty($request->input('position'))) ? $request->input('position') : '';
        
        
        $result1 = substr($city, 0, 2);
        $result2 = substr($name, 0, 2);
        $result3 = substr($phone,-4);
        $brand_admin_id = $result1.'-'.$result2.'-'.$result3;
        
        $insert = DB::table('brand_admin')->where('id','=',$id)->update([
            'company_id' => '',
            'brand_admin_id'=>$brand_admin_id,
            'name' => $name,
            'email'=>$email,
            'phone' => $phone,
            'position'=>$position,
            'state' => $state,
            'city'=>$city,
            'pincodes_managed' => $pincode,
            'age'=>$age,
            'gender' => $gender
            
        ]);
        return redirect()->route('brand-admin')->with('success','Brand Admin has been updated successfully.');
    }
    
    public function changebadminstatus1($id){
        $insert = DB::table('brand_admin')->where('id','=',$id)->update([
            'status' => 1
        ]);
        return redirect()->back()->with('success','Status has been updated successfully.');
    }

    public function changebadminstatus2($id){
        $insert = DB::table('brand_admin')->where('id','=',$id)->update([
            'status' => 2
        ]);
        return redirect()->back()->with('success','Status has been updated successfully.');
    }
}
