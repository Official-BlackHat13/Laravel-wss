<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Storage;
use DB;
use Illuminate\Support\Facades\Hash;
use auth;

class StreamController extends Controller
{
    public function index(){
        $uid=auth::user()->id;
        $brand_id= DB::table('brand_admin')->select('brand_admin.brand_admin_id')->where('id','=',$uid)->first();
        $brand_admin_id=$brand_id->brand_admin_id;
        $users1 = DB::table('store_stream')->select('store_stream.*')->where("brand_admin_id", "like","%".$brand_admin_id."%")->orderBy('store_stream.id','desc')->get();
        return view('streamlist',['users1'=>$users1,]);
    }
    
    public function create()
    {
        $store_id= DB::table('store_admin')->select('store_admin.store_admin_id')->where('status','=',1)->get();
        $city= DB::table('cities')->select('cities.*')->where('status','=',1)->get();
        return view('add_live_stream_form',['store'=>$store_id,'city'=>$city]);
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'store_admin_id'=>'required',
            'title'=>'required',
            'update_description'=>'required',
            'image'=>'required|image|mimes:jpeg,png,jpg',
            'location'=>'required',
            'city'=>'required',
            'date'=>'required',
            'time'=>'required'
        ]);
        $title = (!empty($request->input('title'))) ? $request->input('title') : '';
        $description = (!empty($request->input('update_description'))) ? $request->input('update_description') : '';
        $store_admin_id = (!empty($request->input('store_admin_id'))) ? $request->input('store_admin_id') : '';
        $fileContents = $request->image;
        $dt = Storage::disk('custom')->put('/',$fileContents);
        
        $location = (!empty($request->input('location'))) ? $request->input('location') : '';
        $city = (!empty($request->input('city'))) ? $request->input('city') : '';
        $date = (!empty($request->input('date'))) ? $request->input('date') : '';
        $time = (!empty($request->input('time'))) ? $request->input('time') : '';
        
        $uid=auth::user()->id;
        $brand_id= DB::table('brand_admin')->select('brand_admin.brand_admin_id')->where('id','=',$uid)->first();
        $brand_admin_id=$brand_id->brand_admin_id;
        
        $insert = DB::table('store_stream')->insert([
            'brand_admin_id' => $brand_admin_id,
            'store_admin_id'=>$store_admin_id,
            'title' => $title,
            'description'=>$description,
            'image' => $dt,
            'location'=>$location,
            'city'=>$city,
            'date'=>$date,
            'time'=>$time
        ]);
        
        return redirect()->route('live-stream')->with('success','Live stream data has been added successfully.');
    }
    
    public function delete($id)
    {
        $insert = DB::table('store_stream')->where('id','=',$id)->delete();
        return redirect()->route('store-updates')->with('success','Live stream data has been deleted successfully.');  
    }
    
    public function deleteMultiple(Request $request){
        $ids = $request->ids;
        DB::table('store_stream')->whereIn('id',explode(",",$ids))->delete();
        return redirect()->back()->with('success','Selected banners has been deleted successfully.');  
    }

    public function edit($id)
    {
        $edituser = DB::table('store_stream')
                    ->select('*')
                    ->where('id', '=',$id)
                    ->first();
        $store_id= DB::table('store_admin')->select('store_admin.store_admin_id')->where('status','=',1)->get();
        $city= DB::table('cities')->select('cities.*')->where('status','=',1)->get();  
        return view('live_stream_form_edit',['edituser'=>$edituser,'store'=>$store_id,'city'=>$city]);
    }
    
    public function update(Request $request)
    {
        $id = (!empty($request->input('id'))) ? $request->input('id') : '';
        $title = (!empty($request->input('title'))) ? $request->input('title') : '';
        $description = (!empty($request->input('update_description'))) ? $request->input('update_description') : '';
        $store_admin_id = (!empty($request->input('store_admin_id'))) ? $request->input('store_admin_id') : '';
        $location = (!empty($request->input('location'))) ? $request->input('location') : '';
        $city = (!empty($request->input('city'))) ? $request->input('city') : '';
        $date = (!empty($request->input('date'))) ? $request->input('date') : '';
        $time = (!empty($request->input('time'))) ? $request->input('time') : '';
        $selctdt = DB::table('store_stream')->select('store_stream.*')->where('id','=',$request->input('id'))->first();
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
        
        // DB::enableQueryLog();
        $insert = DB::table('store_stream')->where('id','=',$id)->update([
            'brand_admin_id' => $brand_admin_id,
            'store_admin_id'=>$store_admin_id,
            'title' => $title,
            'description'=>$description,
            'image' => $dt,
            'location'=>$location,
            'city'=>$city,
            'date'=>$date,
            'time'=>$time
            
        ]);
        
        // $qwe=DB::getQueryLog();
        // print_r($qwe);exit;
        return redirect()->route('live-stream')->with('success','Live stream data has been updated successfully.');
    }
    
    public function changeststatus1($id){
        $insert = DB::table('store_stream')->where('id','=',$id)->update([
            'status' => 1
        ]);
        return redirect()->back()->with('success','Status has been updated successfully.');
    }

    public function changeststatus2($id){
        $insert = DB::table('store_stream')->where('id','=',$id)->update([
            'status' => 2
        ]);
        return redirect()->back()->with('success','Status has been updated successfully.');
    }
}
