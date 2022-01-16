<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Storage;
use DB;
use auth;
class AdsController extends Controller
{
    public function index(){
        $uid=auth::user()->id;
        $brand_id= DB::table('brand_admin')->select('brand_admin.brand_admin_id')->where('id','=',$uid)->first();
        $brand_admin_id=$brand_id->brand_admin_id;
        $users1 = DB::table('store_ads')->select('store_ads.*') ->where("brand_admin_id", "like","%".$brand_admin_id."%")->orderBy('store_ads.id','desc')->get();
        return view('adslist',['users1'=>$users1]);
    }

    public function create()
    {
        $store_id= DB::table('store_admin')->select('store_admin.store_admin_id')->get();
        return view('add_ads_from',['store'=>$store_id]);
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'image'=>'required|image|mimes:jpeg,png,jpg,gif,svg',
            'description'=>'required'
        ]);
        $uid=auth::user()->id;
        $brand_id= DB::table('brand_admin')->select('brand_admin.brand_admin_id')->where('id','=',$uid)->first();
        $brand_admin_id=$brand_id->brand_admin_id;
        
        $desc = (!empty($request->input('description'))) ? $request->input('description') : '';
        $store_admin_id = (!empty($request->input('store_admin_id'))) ? $request->input('store_admin_id') : '';
        $fileContents = $request->image;
        $dt = Storage::disk('custom')->put('/',$fileContents);
        $insert = DB::table('store_ads')->insert([
                'image' => $dt,
                'description'=>$desc,
                'brand_admin_id'=>$brand_admin_id,
                'store_admin_id'=>$store_admin_id
        ]);
        return redirect()->route('ads')->with('success','Ads has been added successfully.');
    }
    public function edit($id)
    {
        $editbanner = DB::table('store_ads')
                        ->where('id', '=',$id)
                        ->first();
                        
        $store_id= DB::table('store_admin')->select('store_admin.store_admin_id')->get();
        
        return view('ads_from_edit',['edituser'=>$editbanner,'store'=>$store_id]);
    }
    
    public function update(Request $request)
    {
        $id = (!empty($request->input('id'))) ? $request->input('id') : '';
        $desc= (!empty($request->input('description'))) ? $request->input('description') : '';
        $store_admin_id = (!empty($request->input('store_admin_id'))) ? $request->input('store_admin_id') : '';
        $selctdt = DB::table('store_ads')->select('store_ads.*')->where('id','=',$request->input('id'))->first();
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
        
        $insert = DB::table('store_ads')->where('id','=',$id)->update([
            'image' => $dt,
            'description'=>$desc,
            'brand_admin_id'=>$brand_admin_id,
            'store_admin_id'=>$store_admin_id
        ]);
        return redirect()->route('ads')->with('success','Ads has been updated successfully.');
    }
    
    public function delete($id)
    {
        $insert = DB::table('store_ads')->where('id','=',$id)->delete();
        return redirect()->back()->with('success','Banner has been deleted successfully.');   
    }
    
    public function deleteMultiple(Request $request){
        $ids = $request->ids;
        DB::table('store_ads')->whereIn('id',explode(",",$ids))->delete();
        return redirect()->back()->with('success','Selected banners has been deleted successfully.');  
    }
    
    public function changeadsstatus1($id){
        $insert = DB::table('store_ads')->where('id','=',$id)->update([
            'status' => 1
        ]);
        return redirect()->back()->with('success','Status has been updated successfully.');
    }
    public function changeadsstatus2($id){
        $insert = DB::table('store_ads')->where('id','=',$id)->update([
            'status' => 2
        ]);
        return redirect()->back()->with('success','Status has been updated successfully.');
    }
}
