<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Storage;
use DB;
use auth;

class WinnerBannerController extends Controller
{
    public function index(){
        $uid=auth::user()->id;
        $com_id= DB::table('brand_admin')->select('brand_admin.brand_admin_id')->where('id','=',$uid)->first();
        $brand_id=$com_id->brand_admin_id;
        $users1 = DB::table('winner_banner')->select('winner_banner.*')->where('brand_admin_id','=',$brand_id)->orderBy('winner_banner.id','desc')->get();
        return view('winnerbannerlist',['users1'=>$users1]);
    }

    public function create()
    {
        $company = DB::table('company_admin')->select('company_admin.company_id')->where('status','=',1)->get();
        $brand = DB::table('brand_admin')->select('brand_admin.brand_admin_id')->where('status','=',1)->get();
        $store = DB::table('store_admin')->select('store_admin.store_admin_id')->where('status','=',1)->get();
        return view('add_winner_banner_from',['company'=>$company,'brand'=>$brand,'store'=>$store]);
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'image'=>'required|image|mimes:jpeg,png,jpg,gif,svg'
        ]);
        
        $store_admin_id=(!empty($request->input('store_admin_id'))) ? $request->input('store_admin_id') : '';
        
        if ($files = $request->file('image')) {
                $destinationPath = public_path('../../uploads/'); 
                $profileImage =$files->getClientOriginalName();
                $files->move($destinationPath, $profileImage);
        }
        $uid=auth::user()->id;
        $com_id= DB::table('brand_admin')->select('brand_admin.brand_admin_id','company_id')->where('id','=',$uid)->first();
        $brand_admin_id=$com_id->brand_admin_id;
        $company_id=$com_id->company_id;
        $insert = DB::table('winner_banner')->insert([
                'type'=>2,
                'company_id'=>$company_id,
                'brand_admin_id'=>$brand_admin_id,
                'store_admin_id'=>$store_admin_id,
                'image' => $profileImage
        ]);
        return redirect()->route('winner-banner')->with('success','Banner has been added successfully.');
    }
    public function edit($id)
    {
        $editbanner = DB::table('winner_banner')
                        ->where('id', '=',$id)
                        ->first();
                        
        $company = DB::table('company_admin')->select('company_admin.company_id')->where('status','=',1)->get();
        $brand = DB::table('brand_admin')->select('brand_admin.brand_admin_id')->where('status','=',1)->get();
        $store = DB::table('store_admin')->select('store_admin.store_admin_id')->where('status','=',1)->get();
        return view('winner_banner_from_edit',['editbanner'=>$editbanner,'company'=>$company,'brand'=>$brand,'store'=>$store]);
    }
    
    public function update(Request $request)
    {
        $id = (!empty($request->input('id'))) ? $request->input('id') : '';
        $store_admin_id=(!empty($request->input('store_admin_id'))) ? $request->input('store_admin_id') : '';
        $uid=auth::user()->id;
        $com_id= DB::table('brand_admin')->select('brand_admin.brand_admin_id','company_id')->where('id','=',$uid)->first();
        $brand_admin_id=$com_id->brand_admin_id;
        $company_id=$com_id->company_id;
        $selctdt = DB::table('winner_banner')->select('winner_banner.*')->where('id','=',$id)->first();
        if ($files = $request->file('image')) {
                $destinationPath = public_path('../../uploads/'); 
                $profileImage =$files->getClientOriginalName();
                $files->move($destinationPath, $profileImage);
        }
        else
        {
           $profileImage =(!empty($selctdt->image))? $selctdt->image : '';   
        }
        $insert = DB::table('winner_banner')->where('id','=',$id)->update([
                'store_admin_id'=>$store_admin_id,
                'company_id'=>$company_id,
                'brand_admin_id'=>$brand_admin_id,
                'image' => $profileImage,
                'type'=>2
        ]);
        return redirect()->route('winner-banner')->with('success','Banner has been updated successfully.');
    }
    public function delete($id)
    {
        $insert = DB::table('winner_banner')->where('id','=',$id)->delete();
        return redirect()->back()->with('success','Banner has been deleted successfully.');   
    }
    
    public function deleteMultiple(Request $request){
        $ids = $request->ids;
        DB::table('winner_banner')->whereIn('id',explode(",",$ids))->delete();
        return redirect()->back()->with('success','Selected banners has been deleted successfully.');  
    }
    
    public function changewbstatus1($id){
        $insert = DB::table('winner_banner')->where('id','=',$id)->update([
            'status' => 1
        ]);
        return redirect()->back()->with('success','Status has been updated successfully.');
    }
    public function changewbstatus2($id){
        $insert = DB::table('winner_banner')->where('id','=',$id)->update([
            'status' => 2
        ]);
        return redirect()->back()->with('success','Status has been updated successfully.');
    }
}
