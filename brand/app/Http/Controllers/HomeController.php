<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('dashboard');
    }

    public function dashboard(){
        return view('dashboard');
    }
    
    public function view_account(){
        $uid= auth::user()->id;
        
        $edituser = DB::table('company_admin')
                    ->select('*')
                    ->where('id', '=',$uid)
                    ->first();
        $country = DB::table('countries')->select('countries.*')->get(); 
        $pin = DB::table('cities_pincode')->select('cities_pincode.*')->get();
        $supcat = DB::table('super_categories')->select('super_categories.*')->get();
        $cat = DB::table('categories')->select('categories.*')->get();
        $subcat = DB::table('sub_categories')->select('sub_categories.*')->get();
        
        return view('view-account',['edituser'=>$edituser,'country'=>$country,'pin'=>$pin,'supcat'=>$supcat,'cat'=>$cat,'subcat'=>$subcat]);
    }
    
    public function change_password1(){
        return view('change_password');
    }
    
    public function change_password(Request $request){
        $this->validate($request, [
            'password'=>'required',
            'new_password'=>'required',
            'confirm_password'=>'required'
        ]);
        $uid=Auth::user()->id;  
        $pass = (!empty($request->input('password'))) ? $request->input('password'):'';
        $npass = (!empty($request->input('new_password'))) ? $request->input('new_password'):'';
        $cpass = (!empty($request->input('confirm_password'))) ? $request->input('confirm_password'):'';
        
        $user=DB::table('brand_admin')->select('brand_admin.*')->where('brand_admin.id','=',$uid)->first();
        if (Hash::check($pass, $user->password)) {
            if($npass==$cpass){
                $password=Hash::make($npass);
                $insert = DB::table('brand_admin')->where('id','=',$uid)->update([
                    'password'=>$password
                ]);
                return redirect()->route('dashboard');
            }else{
                return redirect()->back()->with('failed','New password and confirm password did not matched');
            }
        }
        else{
            return redirect()->back()->with('failed','Current password did not matched');
        }
    }
}
