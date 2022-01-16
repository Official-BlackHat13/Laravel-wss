<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Storage;
use DB;
use auth;
use Illuminate\Support\Facades\Hash;

class BrandAdminController extends Controller
{
    
    public function index(){
        $uid=auth::user()->id;
        $com_id= DB::table('company_admin')->select('company_admin.company_id')->where('id','=',$uid)->first();
        $company_id=$com_id->company_id;
        $users1 = DB::table('brand_admin')->select('brand_admin.*')->where("company_id", "like","%".$company_id."%")->orderBy('id','desc')->get();
        return view('brandadminlist',['users1'=>$users1]);
    }
    
    public function create()
    {
        $company = DB::table('company_admin')->select('company_admin.name','company_admin.company_id')->where('status','=',1)->get();
        $country = DB::table('countries')->select('countries.*')->get();
        $pin = DB::table('cities_pincode')->select('cities_pincode.*')->get();
        return view('add_brand_admin_form',['company'=>$company,'country'=>$country,'pin'=>$pin]);
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
            'position'=>'required',
            'role'=>'required',
            'image'=>'required|image|mimes:jpeg,png,jpg',
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
        $pincode = implode(',',$request->input('pincode'));
        $position = (!empty($request->input('position'))) ? $request->input('position') : '';
        $role = implode(',',$request->input('role'));
        
        if ($files = $request->file('image')) {
                $destinationPath = public_path('../../uploads/'); 
                $profileImage =$files->getClientOriginalName();
                $files->move($destinationPath, $profileImage);
        }
        
        // print_r($pincode);print_r($role);exit;
        $result1 = substr($city, 0, 2);
        $result2 = substr($name, 0, 2);
        $result3 = substr($phone,-4);
        $brand_admin_id = $result1.'-'.$result2.'-'.$result3;
        
        $uid=auth::user()->id;
        $com_id= DB::table('company_admin')->select('company_admin.company_id')->where('id','=',$uid)->first();
        $company_id=$com_id->company_id;
        
        $insert = DB::table('brand_admin')->insert([
            'company_id' => $company_id,
            'brand_admin_id'=>$brand_admin_id,
            'name' => $name,
            'email'=>$email,
            'phone' => $phone,
            'position'=>$position,
            'state' => $state,
            'country' => $country,
            'city'=>$city,
            'image'=>$profileImage,
            'pincodes_managed' =>$pincode,
            'age'=>$age,
            'gender' => $gender,
            'password'=>Hash::make($password),
            'role'=>$role
            
        ]);
        return redirect()->route('brand-admin')->with('success','Brand admin has been added successfully.');
    }
    
    public function delete($id)
    {
        $insert = DB::table('brand_admin')->where('id','=',$id)->delete();
        return redirect()->route('brand-admin')->with('success','Brand admin has been deleted successfully.');  
    }
    
    public function deleteMultiple(Request $request){
        $ids = $request->ids;
        DB::table('brand_admin')->whereIn('id',explode(",",$ids))->delete();
        return redirect()->back()->with('success','Selected banners has been deleted successfully.');  
    }

    public function edit($id)
    {
        $edituser = DB::table('brand_admin')
                    ->select('*')
                    ->where('id', '=',$id)
                    ->first();
        $company = DB::table('company_admin')->select('company_admin.name','company_admin.company_id')->where('status','=',1)->get();
        $country = DB::table('countries')->select('countries.*')->get(); 
        $pin = DB::table('cities_pincode')->select('cities_pincode.*')->get();
        $dis_explode=explode(",",$edituser->pincodes_managed);
        return view('brand_admin_form_edit',['edituser'=>$edituser,'pin'=>$pin,'country'=>$country,'company'=>$company,'dis_explodes'=>$dis_explode]);
    }
    
    public function update(Request $request)
    {
        $id = (!empty($request->input('id'))) ? $request->input('id') : '';
        $name = (!empty($request->input('name'))) ? $request->input('name') : '';
        $email = (!empty($request->input('email'))) ? $request->input('email') : '';
        $password = (!empty($request->input('password'))) ? $request->input('password') : '';
        $phone = (!empty($request->input('phone'))) ? $request->input('phone') : '';
        $age = (!empty($request->input('age'))) ? $request->input('age') : '';
        $gender = (!empty($request->input('gender'))) ? $request->input('gender') : '';
        $country = (!empty($request->input('country'))) ? $request->input('country') : '';
        $state = (!empty($request->input('state'))) ? $request->input('state') : '';
        $city = (!empty($request->input('city'))) ? $request->input('city') : '';
        $pincode = implode(',',$request->input('pincode'));
        $position = (!empty($request->input('position'))) ? $request->input('position') : '';
        $role = implode(',',$request->input('role'));
        $selctdt = DB::table('brand_admin')->select('brand_admin.*')->where('id','=',$request->input('id'))->first();
        if ($files = $request->file('image')) {
                $destinationPath = public_path('../../uploads/'); 
                $profileImage =$files->getClientOriginalName();
                $files->move($destinationPath, $profileImage);
        }else{
            $profileImage =(!empty($selctdt->image))? $selctdt->image : '';  
        }
        $result1 = substr($city, 0, 2);
        $result2 = substr($name, 0, 2);
        $result3 = substr($phone,-4);
        $brand_admin_id = $result1.'-'.$result2.'-'.$result3;
        
        $uid=auth::user()->id;
        $com_id= DB::table('company_admin')->select('company_admin.company_id')->where('id','=',$uid)->first();
        $company_id=$com_id->company_id;
        
        $insert = DB::table('brand_admin')->where('id','=',$id)->update([
            'company_id' => $company_id,
            'brand_admin_id'=>$brand_admin_id,
            'name' => $name,
            'email'=>$email,
            'phone' => $phone,
            'position'=>$position,
            'state' => $state,
            'country' => $country,
            'city'=>$city,
            'image'=>$profileImage,
            'pincodes_managed' =>$pincode,
            'age'=>$age,
            'gender' => $gender,
            'role'=>$role
            
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
