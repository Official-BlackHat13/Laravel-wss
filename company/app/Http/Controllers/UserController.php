<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Storage;
use DB;

class UserController extends Controller
{
    public function index(){
        $users1 = DB::table('users')->select('users.*')->orderBy('users.id','desc')->get();
        return view('userslist',['users1'=>$users1]);
    }

    public function delete($id)
    {
        $insert = DB::table('users')->where('id','=',$id)->update([
            'is_deleted' => 1
        ]);
        return redirect()->route('users')->with('success','User has been deleted successfully.');  
    }

    public function edit($id)
    {
        $edituser = DB::table('users')
        ->select('*')
        ->where('id', '=',$id)
        ->first();
        return view('user_form_edit',['edituser'=>$edituser]);
    }
    
    public function update(Request $request)
    {
        $id = (!empty($request->input('id'))) ? $request->input('id') : '';
        $name = (!empty($request->input('name'))) ? $request->input('name'): '';
        $email = (!empty($request->input('email'))) ? $request->input('email'): '';
        $mobile = (!empty($request->input('mobile'))) ? $request->input('mobile'): '';
        $company_name = (!empty($request->input('company_name'))) ? $request->input('company_name'): '';
        $age = (!empty($request->input('age'))) ? $request->input('age'): '';
        $gender = (!empty($request->input('gender'))) ? $request->input('gender'): '';
        $insert = DB::table('users')->where('id','=',$id)->update([
            'name' => $name,
            'email'=>$email,
            'mobile'=>$mobile,
            'company_name' => $company_name,
            'age'=>$age,
            'gender'=>$gender
            
        ]);
        return redirect()->route('users')->with('success','User has been updated successfully.');
    }
    
    public function changeuserstatus1($id){
        $insert = DB::table('users')->where('id','=',$id)->update([
            'status' => 1
        ]);
        return redirect()->back()->with('success','Status has been updated successfully.');
    }

    public function changeuserstatus2($id){
        $insert = DB::table('users')->where('id','=',$id)->update([
            'status' => 2
        ]);
        return redirect()->back()->with('success','Status has been updated successfully.');
    }
}
