<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Storage;
use DB;

class OfferBannerController extends Controller
{
    public function index(){
        $users1 = DB::table('offer_banner')->select('offer_banner.*')->orderBy('offer_banner.id','desc')->get();
        return view('offerbannerlist',['users1'=>$users1]);
    }

    public function create()
    {
        $locationlist=DB::table('banner_cities')
                        ->select('id','city')
                        ->get();
                        
        $company=DB::table('company_admin')
                        ->select('id','company_id','name')
                        ->where('status','=',1)
                        ->get();
                        
        return view('add_offer_banner_from',['locationlist'=>$locationlist,'company'=>$company]);
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'image'=>'required|image|mimes:jpeg,png,jpg,gif,svg'
        ]);
        $company_id = (!empty($request->input('company_id'))) ? $request->input('company_id') : '';
        $location = (!empty($request->input('location'))) ? $request->input('location') : '';
        $code = (!empty($request->input('coupon_code'))) ? $request->input('coupon_code') : '';
        $fileContents = $request->image;
        $dt = Storage::disk('custom')->put('/',$fileContents);
        $insert = DB::table('offer_banner')->insert([
                'company_id'=>$company_id,
                'image' => $dt,
                'location'=>$location,
                'coupon_code'=>$code
        ]);
        return redirect()->route('offer-banner')->with('success','Banner has been added successfully.');
    }
    public function edit($id)
    {
        $editbanner = DB::table('offer_banner')
                        ->where('id', '=',$id)
                        ->first();
                        
        $locationlist=DB::table('banner_cities')
                        ->select('*')
                        ->get();
                        
        $company=DB::table('company_admin')
                        ->select('id','company_id','name')
                        ->where('status','=',1)
                        ->get();
                        
        return view('offer_banner_from_edit',['editbanner'=>$editbanner,'locationlist'=>$locationlist,'company'=>$company]);
    }
    
    public function update(Request $request)
    {
        $id = (!empty($request->input('id'))) ? $request->input('id') : '';
        $company_id = (!empty($request->input('company_id'))) ? $request->input('company_id') : '';
        $location = (!empty($request->input('location'))) ? $request->input('location') : '';
        $code = (!empty($request->input('coupon_code'))) ? $request->input('coupon_code') : '';
        $selctdt = DB::table('offer_banner')->select('offer_banner.*')->where('id','=',$request->input('id'))->first();
         if(!empty($request->image)){
              $fileContents = $request->image;
              $dt = Storage::disk('custom')->put('/',$fileContents);
        }
        else
        {
           $dt =(!empty($selctdt->image))? $selctdt->image : '';   
        }
        $insert = DB::table('offer_banner')->where('id','=',$id)->update([
                'company_id'=>$company_id,
                'image' => $dt,
                'location'=>$location,
                'coupon_code'=>$code
        ]);
        return redirect()->route('offer-banner')->with('success','Banner has been updated successfully.');
    }
    public function delete($id)
    {
        $insert = DB::table('offer_banner')->where('id','=',$id)->delete();
        return redirect()->back()->with('success','Banner has been deleted successfully.');   
    }
    
    public function deleteMultiple(Request $request){
        $ids = $request->ids;
        DB::table('offer_banner')->whereIn('id',explode(",",$ids))->delete();
        return redirect()->back()->with('success','Selected banners has been deleted successfully.');  
    }
    
    public function changeobstatus1($id){
        $insert = DB::table('offer_banner')->where('id','=',$id)->update([
            'status' => 1
        ]);
        return redirect()->back()->with('success','Status has been updated successfully.');
    }
    public function changeobstatus2($id){
        $insert = DB::table('offer_banner')->where('id','=',$id)->update([
            'status' => 2
        ]);
        return redirect()->back()->with('success','Status has been updated successfully.');
    }
}
