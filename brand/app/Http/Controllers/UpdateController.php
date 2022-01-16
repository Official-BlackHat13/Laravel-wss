<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Storage;
use DB;
use Illuminate\Support\Facades\Hash;
use auth;

class UpdateController extends Controller
{
    public function index(){
        $uid=auth::user()->id;
        $brand_id= DB::table('brand_admin')->select('brand_admin.brand_admin_id')->where('id','=',$uid)->first();
        $brand_admin_id=$brand_id->brand_admin_id;
        $users1 = DB::table('store_updates')->select('store_updates.*')->where("brand_admin_id", "like","%".$brand_admin_id."%")->orderBy('store_updates.id','desc')->get();
        return view('storeupdatelist',['users1'=>$users1,]);
    }
    
    public function create()
    {
        $store_id= DB::table('store_admin')->select('store_admin.store_admin_id')->get();
        return view('add_store_update_form',['store'=>$store_id]);
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'store_admin_id'=>'required',
            'title'=>'required',
            'update_description'=>'required',
            'image'=>'required|image|mimes:jpeg,png,jpg'
        ]);
        $title = (!empty($request->input('title'))) ? $request->input('title') : '';
        $description = (!empty($request->input('update_description'))) ? $request->input('update_description') : '';
        $store_admin_id = (!empty($request->input('store_admin_id'))) ? $request->input('store_admin_id') : '';
        $fileContents = $request->image;
        $dt = Storage::disk('custom')->put('/',$fileContents);
        
        $uid=auth::user()->id;
        $brand_id= DB::table('brand_admin')->select('brand_admin.brand_admin_id')->where('id','=',$uid)->first();
        $brand_admin_id=$brand_id->brand_admin_id;
        
        $insert = DB::table('store_updates')->insert([
            'brand_admin_id' => $brand_admin_id,
            'store_admin_id'=>$store_admin_id,
            'title' => $title,
            'description'=>$description,
            'image' => $dt
        ]);
        return redirect()->route('store-updates')->with('success','Store updates data has been added successfully.');
    }
    
    public function delete($id)
    {
        $insert = DB::table('store_updates')->where('id','=',$id)->delete();
        return redirect()->route('store-updates')->with('success','Store updates data has been deleted successfully.');  
    }
    
    public function deleteMultiple(Request $request){
        $ids = $request->ids;
        DB::table('store_updates')->whereIn('id',explode(",",$ids))->delete();
        return redirect()->back()->with('success','Selected banners has been deleted successfully.');  
    }

    public function edit($id)
    {
        $edituser = DB::table('store_updates')
                    ->select('*')
                    ->where('id', '=',$id)
                    ->first();
                    
        $store_id= DB::table('store_admin')->select('store_admin.store_admin_id')->get(); 
        return view('store_update_form_edit',['edituser'=>$edituser,'store'=>$store_id]);
    }
    
    public function update(Request $request)
    {
        $id = (!empty($request->input('id'))) ? $request->input('id') : '';
        $title = (!empty($request->input('title'))) ? $request->input('title') : '';
        $description = (!empty($request->input('update_description'))) ? $request->input('update_description') : '';
        $store_admin_id = (!empty($request->input('store_admin_id'))) ? $request->input('store_admin_id') : '';
        
        $selctdt = DB::table('store_updates')->select('store_updates.*')->where('id','=',$request->input('id'))->first();
         if(!empty($request->image)){
              $fileContents = $request->image;
              $dt = Storage::disk('custom')->put('/',$fileContents);
        }
        else
        {
           $dt =(!empty($selctdt->image))? $selctdt->image : '';   
        }
        
        $uid=auth::user()->id;
        $brand_id= DB::table('brand_admin')->select('brand_admin.brand_admin_id')->where('id','=',$uid)->first();
        $brand_admin_id=$brand_id->brand_admin_id;
        
        $insert = DB::table('store_updates')->where('id','=',$id)->update([
            'brand_admin_id' => $brand_admin_id,
            'store_admin_id'=>$store_admin_id,
            'title' => $title,
            'description'=>$description,
            'image' => $dt
            
        ]);
        return redirect()->route('store-updates')->with('success','Store updates data has been updated successfully.');
    }
    
    public function changestupstatus1($id){
        $insert = DB::table('store_updates')->where('id','=',$id)->update([
            'status' => 1
        ]);
        return redirect()->back()->with('success','Status has been updated successfully.');
    }

    public function changestupstatus2($id){
        $insert = DB::table('store_updates')->where('id','=',$id)->update([
            'status' => 2
        ]);
        return redirect()->back()->with('success','Status has been updated successfully.');
    }
}
