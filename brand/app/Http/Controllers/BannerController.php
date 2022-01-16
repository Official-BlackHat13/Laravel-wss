<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Storage;
use DB;
use auth;

class BannerController extends Controller
{
    public function getbannerDetails(){
        $uid=auth::user()->id;
        $com_id= DB::table('brand_admin')->select('brand_admin.company_id')->where('id','=',$uid)->first();
        $company_id=$com_id->company_id;
        
        $users1 = DB::table('company_banner')->select('company_banner.*')->where('company_id','=',$company_id)->orderBy('company_banner.id','desc')->get();
        return view('bannerlist',['users1'=>$users1]);
    }

    public function create()
    {
        $locationlist=DB::table('banner_cities')
                        ->select('*')
                        ->where('status','=',1)
                        ->get();
                        
        return view('add_banner_from',['locationlist'=>$locationlist]);
    }
    public function store(Request $request)
    {
        $uid=auth::user()->id;
        $com_id= DB::table('brand_admin')->select('brand_admin.company_id')->where('id','=',$uid)->first();
        $company_id=$com_id->company_id;
        
        $this->validate($request, [
            'image'=>'required|image|mimes:jpeg,png,jpg',
            'location'=>'required'
        ]);
        
        $location = (!empty($request->input('location'))) ? $request->input('location') : '';
        if ($files = $request->file('image')) {
                $destinationPath = public_path('../../uploads/'); 
                $profileImage =$files->getClientOriginalName();
                $files->move($destinationPath, $profileImage);
        }
        $insert = DB::table('company_banner')->insert([
                'image' => $profileImage,
                'location'=>$location,
                'company_id'=>$company_id
        ]);
        return redirect()->route('banner')->with('success','Banner has been added successfully.');
    }
    public function edit($id)
    {
        $editbanner = DB::table('company_banner')
                        ->where('id', '=',$id)
                        ->first();
                        
        $locationlist=DB::table('banner_cities')
                        ->select('*')
                        ->where('status','=',1)
                        ->get();
        
        return view('banner_from_edit',['editbanner'=>$editbanner,'locationlist'=>$locationlist]);
    }
    
    public function update(Request $request)
    {
        $id = (!empty($request->input('id'))) ? $request->input('id') : '';
        $location = (!empty($request->input('location'))) ? $request->input('location') : '';
        $selctdt = DB::table('company_banner')->select('company_banner.*')->where('id','=',$request->input('id'))->first();
        if ($files = $request->file('image')) {
                $destinationPath = public_path('../../uploads/'); 
                $profileImage =$files->getClientOriginalName();
                $files->move($destinationPath, $profileImage);
        }
        else
        {
           $profileImage =(!empty($selctdt->image))? $selctdt->image : '';   
        }
        
        $uid=auth::user()->id;
        $com_id= DB::table('brand_admin')->select('brand_admin.company_id')->where('id','=',$uid)->first();
        $company_id=$com_id->company_id;
        
        $insert = DB::table('company_banner')->where('id','=',$id)->update([
            'image' => $profileImage,
            'location'=>$location,
            'company_id'=>$company_id
        ]);
        return redirect()->route('banner')->with('success','Banner has been updated successfully.');
    }
    public function delete($id)
    {
        $insert = DB::table('company_banner')->where('id','=',$id)->delete();
        return redirect()->back()->with('success','Banner has been deleted successfully.');   
    }
    
    public function deleteMultiple(Request $request){
        $ids = $request->ids;
        DB::table('company_banner')->whereIn('id',explode(",",$ids))->delete();
        return redirect()->back()->with('success','Selected banners has been deleted successfully.');  
    }
    
    public function changebannerstatus1($id){
        $insert = DB::table('company_banner')->where('id','=',$id)->update([
            'status' => 1
        ]);
        return redirect()->back()->with('success','Status has been updated successfully.');
    }
    public function changebannerstatus2($id){
        $insert = DB::table('company_banner')->where('id','=',$id)->update([
            'status' => 2
        ]);
        return redirect()->back()->with('success','Status has been updated successfully.');
    }
}
