<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Storage;
use DB;

class WinnerBannerController extends Controller
{
    public function index(){
        $users1 = DB::table('winner_banner')->select('winner_banner.*')->orderBy('winner_banner.id','desc')->get();
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
        
        $type=(!empty($request->input('type'))) ? $request->input('type') : '';
        if($type == 1){
            $company_admin_id= '';
            $brand_admin_id= '';
            $store_admin_id= '';
        }else{
            $company_admin_id=(!empty($request->input('company_id'))) ? $request->input('company_id') : '';
            $brand_admin_id=(!empty($request->input('brand_admin_id'))) ? $request->input('brand_admin_id') : '';
            $store_admin_id=(!empty($request->input('store_admin_id'))) ? $request->input('store_admin_id') : '';
        }
        $fileContents = $request->image;
        $dt = Storage::disk('custom')->put('/',$fileContents);
        $insert = DB::table('winner_banner')->insert([
                'type'=>$type,
                'company_id'=>$company_admin_id,
                'brand_admin_id'=>$brand_admin_id,
                'store_admin_id'=>$store_admin_id,
                'image' => $dt
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
        
        $type=(!empty($request->input('type'))) ? $request->input('type') : '';
        if($type == 1){
            $company_admin_id= '';
            $brand_admin_id= '';
            $store_admin_id= '';
        }else{
            $company_admin_id=(!empty($request->input('company_id'))) ? $request->input('company_id') : '';
            $brand_admin_id=(!empty($request->input('brand_admin_id'))) ? $request->input('brand_admin_id') : '';
            $store_admin_id=(!empty($request->input('store_admin_id'))) ? $request->input('store_admin_id') : '';
        }
        $selctdt = DB::table('winner_banner')->select('winner_banner.*')->where('id','=',$id)->first();
         if(!empty($request->image)){
              $fileContents = $request->image;
              $dt = Storage::disk('custom')->put('/',$fileContents);
        }
        else
        {
           $dt =(!empty($selctdt->image))? $selctdt->image : '';   
        }
        $insert = DB::table('winner_banner')->where('id','=',$id)->update([
                'type'=>$type,
                'company_id'=>$company_admin_id,
                'brand_admin_id'=>$brand_admin_id,
                'store_admin_id'=>$store_admin_id,
                'image' => $dt
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
