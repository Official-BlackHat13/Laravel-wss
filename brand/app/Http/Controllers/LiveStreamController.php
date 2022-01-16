<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Storage;
use DB;
use auth;

class LiveStreamController extends Controller
{

    public function index1(){
        $uid=auth::user()->id;
        $brand_admin=DB::table('brand_admin')->select('company_id')->where('id','=',$uid)->first();
        $users1 = DB::table('store_stream')->select('store_stream.*')->where('company_id','=',$brand_admin->company_id)->orderBy('store_stream.id','desc')->get();
        return view('streamlist',['users1'=>$users1]);
    }
    
    public function create()
    {         
        $company = DB::table('company_admin')->select('company_admin.company_id')->where('status','=',1)->get();
        $store = DB::table('store_admin')->select('store_admin.store_admin_id')->where('status','=',1)->get();
        $city = DB::table('banner_cities')->select('banner_cities.*')->where('status','=',1)->get();
        $cat = DB::table('sub_categories')->select('sub_categories.*')->where('status','=',1)->get();
        return view('add_live_stream_form',['company'=>$company,'store'=>$store,'city'=>$city,'category'=>$cat]);
    }
    
    public function storelive(Request $request){
        $this->validate($request, [
            'start_date'=>'required',
            'end_date'=>'required',
            'age'=>'required',
            'headline'=>'required',
            'video_name'=>'required',
            'main_category'=>'required'
            
        ]);
        
        $city = (!empty($request->input('city'))) ? $request->input('city') : '';
        $company_id=(!empty($request->input('company_id'))) ? $request->input('company_id') : '';
        $age = (!empty($request->input('age'))) ? $request->input('age') : '';
        $category = (!empty($request->input('main_category'))) ? $request->input('main_category') : '';
        $store_id=(!empty($request->input('store_id'))) ? $request->input('store_id') : '';
        $start_date= (!empty($request->input('start_date'))) ? $request->input('start_date') : '';
        $end_date= (!empty($request->input('end_date'))) ? $request->input('end_date') : '';
        $gender = (!empty($request->input('gender'))) ? $request->input('gender') : '';
        $video_name = (!empty($request->input('video_name'))) ? $request->input('video_name') : '';
        $headline = (!empty($request->input('headline'))) ? $request->input('headline') : '';
       
        
        $insert = DB::table('store_stream')->insert([
            'company_id'=>$company_id,
            'store_admin_id' => $store_id,
            'city'=>$city,
            'gender' => $gender,
            'age'=>$age,
            'category'=>$category,
            'video_name'=>$video_name,
            'headline'=>$headline,
            'start_date'=>$start_date,
            'end_date'=>$end_date
        ]);
        return redirect()->route('live-stream')->with('success','Live stream has been added successfully.');
    }
    
     public function editlive($id)
    {
        $edituser = DB::table('store_stream')
                    ->select('*')
                    ->where('id', '=',$id)
                    ->first();
        $company = DB::table('company_admin')->select('company_admin.company_id')->where('status','=',1)->get();
        $store = DB::table('store_admin')->select('store_admin.store_admin_id')->where('status','=',1)->get();
        $city = DB::table('banner_cities')->select('banner_cities.*')->where('status','=',1)->get(); 
        $cat = DB::table('sub_categories')->select('sub_categories.*')->where('status','=',1)->get();
        return view('live_stream_form_edit',['edituser'=>$edituser,'company'=>$company,'store'=>$store,'city'=>$city,'category'=>$cat]);
    }
    
    public function updatelive(Request $request){
        $id = (!empty($request->input('id'))) ? $request->input('id') : '';
        $city = (!empty($request->input('city'))) ? $request->input('city') : '';
        $company_id=(!empty($request->input('company_id'))) ? $request->input('company_id') : '';
        $age = (!empty($request->input('age'))) ? $request->input('age') : '';
        $category = (!empty($request->input('main_category'))) ? $request->input('main_category') : '';
        $store_id=(!empty($request->input('store_id'))) ? $request->input('store_id') : '';
        $start_date= (!empty($request->input('start_date'))) ? $request->input('start_date') : '';
        $end_date= (!empty($request->input('end_date'))) ? $request->input('end_date') : '';
        $gender = (!empty($request->input('gender'))) ? $request->input('gender') : '';
        $video_name = (!empty($request->input('video_name'))) ? $request->input('video_name') : '';
        $headline = (!empty($request->input('headline'))) ? $request->input('headline') : '';
        
        $selctdt = DB::table('store_stream')->select('store_stream.*')->where('id','=',$request->input('id'))->first();
        if ($files = $request->file('image')) {
                $destinationPath = public_path('../../uploads/'); 
                $profileImage =$files->getClientOriginalName();
                $files->move($destinationPath, $profileImage);
        }
        else
        {
           $profileImage =(!empty($selctdt->image))? $selctdt->image : '';   
        }
        
        $insert = DB::table('store_stream')->where('id','=',$id)->update([
            'company_id'=>$company_id,
            'store_admin_id' => $store_id,
            'city'=>$city,
            'gender' => $gender,
            'age'=>$age,
            'category'=>$category,
            'video_name'=>$video_name,
            'headline'=>$headline,
            'start_date'=>$start_date,
            'end_date'=>$end_date
        ]);
        return redirect()->route('live-stream')->with('success','Stream has been Updated successfully.');
    }
    
    public function deletelive($id)
    {
        $insert = DB::table('store_stream')->where('id','=',$id)->delete();
        return redirect()->back()->with('success','Stream has been deleted successfully.');  
    }
    
    public function deleteMultiplelive(Request $request){
        $ids = $request->ids;
        DB::table('store_stream')->whereIn('id',explode(",",$ids))->delete();
        return redirect()->back()->with('success','Selected Streams has been deleted successfully.');  
    }
    
    public function changelivestatus1($id){
        $insert = DB::table('store_stream')->where('id','=',$id)->update([
            'status' => 1
        ]);
        return redirect()->back()->with('success','Status has been updated successfully.');
    }

    public function changelivestatus2($id){
        $insert = DB::table('store_stream')->where('id','=',$id)->update([
            'status' => 2
        ]);
        return redirect()->back()->with('success','Status has been updated successfully.');
    }
    
    
    public function index(){
        $uid=auth::user()->id;
        $brand_admin=DB::table('brand_admin')->select('company_id')->where('id','=',$uid)->first();
        $users1 = DB::table('promo')->select('promo.*')->where('company_id','=',$brand_admin->company_id)->orderBy('promo.id','desc')->get();
        return view('promolist',['users1'=>$users1]);
    }
    
     public function create1()
    {         
        $company = DB::table('company_admin')->select('company_admin.company_id')->where('status','=',1)->get();
        $store = DB::table('store_admin')->select('store_admin.store_admin_id')->where('status','=',1)->get();
        $city = DB::table('banner_cities')->select('banner_cities.*')->where('status','=',1)->get();
        $cat = DB::table('sub_categories')->select('sub_categories.*')->where('status','=',1)->get();
        return view('add_promo_form',['company'=>$company,'store'=>$store,'city'=>$city,'category'=>$cat]);
    }
    
    public function storepromo(Request $request){
        $this->validate($request, [
            'start_date'=>'required',
            'end_date'=>'required',
            'age'=>'required',
            'headline'=>'required',
            'promo_name'=>'required',
            'main_category'=>'required',
            'image'=>'required',
            'image.*' => 'image|mimes:jpeg,png,jpg|max:2048'
            
        ]);
        $city = (!empty($request->input('city'))) ? $request->input('city') : '';
        $company_id=(!empty($request->input('company_id'))) ? $request->input('company_id') : '';
        $age = (!empty($request->input('age'))) ? $request->input('age') : '';
        $category = (!empty($request->input('main_category'))) ? $request->input('main_category') : '';
        $store_id=(!empty($request->input('store_id'))) ? $request->input('store_id') : '';
        $start_date= (!empty($request->input('start_date'))) ? $request->input('start_date') : '';
        $end_date= (!empty($request->input('end_date'))) ? $request->input('end_date') : '';
        $gender = (!empty($request->input('gender'))) ? $request->input('gender') : '';
        $promo_name = (!empty($request->input('promo_name'))) ? $request->input('promo_name') : '';
        $headline = (!empty($request->input('headline'))) ? $request->input('headline') : '';
        
        if ($files = $request->file('image')) {
                $destinationPath = public_path('../../uploads/'); 
                $profileImage =$files->getClientOriginalName();
                $files->move($destinationPath, $profileImage);
        }
        
        $insert = DB::table('promo')->insert([
            'company_id'=>$company_id,
            'store_admin_id' => $store_id,
            'city'=>$city,
            'gender' => $gender,
            'age'=>$age,
            'category'=>$category,
            'promo_name'=>$promo_name,
            'headline'=>$headline,
            'start_date'=>$start_date,
            'end_date'=>$end_date,
            'image'=>$profileImage
        ]);
        return redirect()->route('promos')->with('success','Promo has been added successfully.');
    }
    
    public function edit($id)
    {
        $edituser = DB::table('promo')
                    ->select('*')
                    ->where('id', '=',$id)
                    ->first();
        $company = DB::table('company_admin')->select('company_admin.company_id')->where('status','=',1)->get();
        $store = DB::table('store_admin')->select('store_admin.store_admin_id')->where('status','=',1)->get();
        $city = DB::table('banner_cities')->select('banner_cities.*')->where('status','=',1)->get();    
        $cat = DB::table('sub_categories')->select('sub_categories.*')->where('status','=',1)->get();
        return view('promo_form_edit',['edituser'=>$edituser,'company'=>$company,'store'=>$store,'city'=>$city,'category'=>$cat]);
    }
    
    public function update(Request $request){
        $id = (!empty($request->input('id'))) ? $request->input('id') : '';
        $city = (!empty($request->input('city'))) ? $request->input('city') : '';
        $company_id=(!empty($request->input('company_id'))) ? $request->input('company_id') : '';
        $age = (!empty($request->input('age'))) ? $request->input('age') : '';
        $category = (!empty($request->input('main_category'))) ? $request->input('main_category') : '';
        $store_id=(!empty($request->input('store_id'))) ? $request->input('store_id') : '';
        $start_date= (!empty($request->input('start_date'))) ? $request->input('start_date') : '';
        $end_date= (!empty($request->input('end_date'))) ? $request->input('end_date') : '';
        $gender = (!empty($request->input('gender'))) ? $request->input('gender') : '';
        $promo_name = (!empty($request->input('promo_name'))) ? $request->input('promo_name') : '';
        $headline = (!empty($request->input('headline'))) ? $request->input('headline') : '';
        
        $selctdt = DB::table('promo')->select('promo.*')->where('id','=',$request->input('id'))->first();
        if ($files = $request->file('image')) {
                $destinationPath = public_path('../../uploads/'); 
                $profileImage =$files->getClientOriginalName();
                $files->move($destinationPath, $profileImage);
        }
        else
        {
           $profileImage =(!empty($selctdt->image))? $selctdt->image : '';   
        }
        
        $insert = DB::table('promo')->where('id','=',$id)->update([
            'company_id'=>$company_id,
            'store_admin_id' => $store_id,
            'city'=>$city,
            'gender' => $gender,
            'age'=>$age,
            'category'=>$category,
            'promo_name'=>$promo_name,
            'headline'=>$headline,
            'start_date'=>$start_date,
            'end_date'=>$end_date,
            'image'=>$profileImage
        ]);
        return redirect()->route('promos')->with('success','Promo has been updated successfully.');
    }
    
    public function delete($id)
    {
        $insert = DB::table('promo')->where('id','=',$id)->delete();
        return redirect()->back()->with('success','Promo has been deleted successfully.');  
    }
    
    public function deleteMultiple(Request $request){
        $ids = $request->ids;
        DB::table('promo')->whereIn('id',explode(",",$ids))->delete();
        return redirect()->back()->with('success','Selected promos has been deleted successfully.');  
    }
    
    public function changepromostatus1($id){
        $insert = DB::table('promo')->where('id','=',$id)->update([
            'status' => 1
        ]);
        return redirect()->back()->with('success','Status has been updated successfully.');
    }

    public function changepromostatus2($id){
        $insert = DB::table('promo')->where('id','=',$id)->update([
            'status' => 2
        ]);
        return redirect()->back()->with('success','Status has been updated successfully.');
    }
    
    public function staff(){
        $uid=auth::user()->id;
        $brand_admin=DB::table('brand_admin')->select('company_id')->where('id','=',$uid)->first();
        $users1 = DB::table('staff_live_update')->select('staff_live_update.*')->where('company_id','=',$brand_admin->company_id)->orderBy('staff_live_update.id','desc')->get();
        return view('staffupdatelist',['users1'=>$users1]);
    }
    
    public function createstaff()
    {         
        $company = DB::table('company_admin')->select('company_admin.company_id')->where('status','=',1)->get();
        $store = DB::table('store_admin')->select('store_admin.store_admin_id')->where('status','=',1)->get();
        $city = DB::table('banner_cities')->select('banner_cities.*')->where('status','=',1)->get();
        $cat = DB::table('sub_categories')->select('sub_categories.*')->where('status','=',1)->get();
        return view('add_staff_update_form',['company'=>$company,'store'=>$store,'city'=>$city,'category'=>$cat]);
    }
    
    public function storestaff(Request $request){
        $this->validate($request, [
            'start_date'=>'required',
            'end_date'=>'required',
            'age'=>'required',
            'purpose'=>'required',
            'video_name'=>'required',
            'main_category'=>'required',
            'url'=>'required'
            
        ]);
        $city = (!empty($request->input('city'))) ? $request->input('city') : '';
        $company_id=(!empty($request->input('company_id'))) ? $request->input('company_id') : '';
        $age = (!empty($request->input('age'))) ? $request->input('age') : '';
        $category = (!empty($request->input('main_category'))) ? $request->input('main_category') : '';
        $store_id=(!empty($request->input('store_id'))) ? $request->input('store_id') : '';
        $start_date= (!empty($request->input('start_date'))) ? $request->input('start_date') : '';
        $end_date= (!empty($request->input('end_date'))) ? $request->input('end_date') : '';
        $gender = (!empty($request->input('gender'))) ? $request->input('gender') : '';
        $video_name = (!empty($request->input('video_name'))) ? $request->input('video_name') : '';
        $purpose = (!empty($request->input('purpose'))) ? $request->input('purpose') : '';
        $url = (!empty($request->input('url'))) ? $request->input('url') : '';
        
        $insert = DB::table('staff_live_update')->insert([
            'company_id'=>$company_id,
            'store_admin_id' => $store_id,
            'city'=>$city,
            'gender' => $gender,
            'age'=>$age,
            'category'=>$category,
            'video_name'=>$video_name,
            'purpose'=>$purpose,
            'start_date'=>$start_date,
            'end_date'=>$end_date,
            'url'=>$url
        ]);
        return redirect()->route('staff-updates')->with('success','Staff Update has been added successfully.');
    }
    
    public function editstaff($id)
    {
        $edituser = DB::table('staff_live_update')
                    ->select('*')
                    ->where('id', '=',$id)
                    ->first();
        $company = DB::table('company_admin')->select('company_admin.company_id')->where('status','=',1)->get();
        $store = DB::table('store_admin')->select('store_admin.store_admin_id')->where('status','=',1)->get();
        $city = DB::table('banner_cities')->select('banner_cities.*')->where('status','=',1)->get();     
        $cat = DB::table('sub_categories')->select('sub_categories.*')->where('status','=',1)->get();
        return view('staff_update_form_edit',['edituser'=>$edituser,'company'=>$company,'store'=>$store,'city'=>$city,'category'=>$cat]);
    }
    
    public function updatestaff(Request $request){
        $id = (!empty($request->input('id'))) ? $request->input('id') : '';
        $city = (!empty($request->input('city'))) ? $request->input('city') : '';
        $company_id=(!empty($request->input('company_id'))) ? $request->input('company_id') : '';
        $age = (!empty($request->input('age'))) ? $request->input('age') : '';
        $category = (!empty($request->input('main_category'))) ? $request->input('main_category') : '';
        $store_id=(!empty($request->input('store_id'))) ? $request->input('store_id') : '';
        $start_date= (!empty($request->input('start_date'))) ? $request->input('start_date') : '';
        $end_date= (!empty($request->input('end_date'))) ? $request->input('end_date') : '';
        $gender = (!empty($request->input('gender'))) ? $request->input('gender') : '';
        $video_name = (!empty($request->input('video_name'))) ? $request->input('video_name') : '';
        $purpose = (!empty($request->input('purpose'))) ? $request->input('purpose') : '';
        $url = (!empty($request->input('url'))) ? $request->input('url') : '';
        
        $insert = DB::table('staff_live_update')->where('id','=',$id)->update([
            'company_id'=>$company_id,
            'store_admin_id' => $store_id,
            'city'=>$city,
            'gender' => $gender,
            'age'=>$age,
            'category'=>$category,
            'video_name'=>$video_name,
            'purpose'=>$purpose,
            'start_date'=>$start_date,
            'end_date'=>$end_date,
            'url'=>$url
        ]);
        return redirect()->route('staff-updates')->with('success','Staff has been Updated successfully.');
    }
    
    public function deletestaff($id)
    {
        $insert = DB::table('staff_live_update')->where('id','=',$id)->delete();
        return redirect()->back()->with('success','Promo has been deleted successfully.');  
    }
    
    public function deleteMultiplestaff(Request $request){
        $ids = $request->ids;
        DB::table('staff_live_update')->whereIn('id',explode(",",$ids))->delete();
        return redirect()->back()->with('success','Selected staff updates has been deleted successfully.');  
    }
    
    public function changestaffstatus1($id){
        $insert = DB::table('staff_live_update')->where('id','=',$id)->update([
            'status' => 1
        ]);
        return redirect()->back()->with('success','Status has been updated successfully.');
    }

    public function changestaffstatus2($id){
        $insert = DB::table('staff_live_update')->where('id','=',$id)->update([
            'status' => 2
        ]);
        return redirect()->back()->with('success','Status has been updated successfully.');
    }
}
