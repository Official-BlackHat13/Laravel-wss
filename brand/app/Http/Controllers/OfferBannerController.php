<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Storage;
use DB;
use auth;

class OfferBannerController extends Controller
{
    public function index(){
        $uid=auth::user()->id;
        $com_id= DB::table('brand_admin')->select('brand_admin.company_id')->where('id','=',$uid)->first();
        $company_id=$com_id->company_id;
        
        $users1 = DB::table('offer_banner')->select('offer_banner.*')->where('company_id','=',$company_id)->orderBy('offer_banner.id','desc')->get();
        return view('offerbannerlist',['users1'=>$users1]);
    }

    public function create()
    {
        $locationlist=DB::table('banner_cities')
                        ->select('id','city')
                        ->get();
                        
        return view('add_offer_banner_from',['locationlist'=>$locationlist]);
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'image'=>'required|image|mimes:jpeg,png,jpg',
            'expiry_date'=>'required',
            'discount_amount'=>'required',
            'max_discount'=>'required',
            'min_subtotal'=>'required'
            
        ]);
        $uid=auth::user()->id;
        $com_id= DB::table('brand_admin')->select('brand_admin.company_id')->where('id','=',$uid)->first();
        $company_id=$com_id->company_id;
        
        $location = (!empty($request->input('location'))) ? $request->input('location') : '';
        $code = (!empty($request->input('coupon_code'))) ? $request->input('coupon_code') : '';
        $expiry_date = (!empty($request->input('expiry_date'))) ? $request->input('expiry_date') : '';
        $discount_amount = (!empty($request->input('discount_amount'))) ? $request->input('discount_amount') : '';
        $max_discount = (!empty($request->input('max_discount'))) ? $request->input('max_discount') : '';
        $min_subtotal = (!empty($request->input('min_subtotal'))) ? $request->input('min_subtotal') : '';
        if ($files = $request->file('image')) {
                $destinationPath = public_path('../../uploads/'); 
                $profileImage =$files->getClientOriginalName();
                $files->move($destinationPath, $profileImage);
        }
        $insert = DB::table('offer_banner')->insert([
                'company_id'=>$company_id,
                'image' => $profileImage,
                'location'=>$location,
                'coupon_code'=>$code,
                'min_subtotal' => $min_subtotal,
                'discount_amount'=>$discount_amount,
                'expiry_date' => $expiry_date,
                'max_discount'=>$max_discount,
                'type'=>2
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
                        
        return view('offer_banner_from_edit',['editbanner'=>$editbanner,'locationlist'=>$locationlist]);
    }
    
    public function update(Request $request)
    {
        $id = (!empty($request->input('id'))) ? $request->input('id') : '';
        
        $uid=auth::user()->id;
        $com_id= DB::table('brand_admin')->select('brand_admin.company_id')->where('id','=',$uid)->first();
        $company_id=$com_id->company_id;
        
        $location = (!empty($request->input('location'))) ? $request->input('location') : '';
        $code = (!empty($request->input('coupon_code'))) ? $request->input('coupon_code') : '';
        $expiry_date = (!empty($request->input('expiry_date'))) ? $request->input('expiry_date') : '';
        $discount_amount = (!empty($request->input('discount_amount'))) ? $request->input('discount_amount') : '';
        $max_discount = (!empty($request->input('max_discount'))) ? $request->input('max_discount') : '';
        $min_subtotal = (!empty($request->input('min_subtotal'))) ? $request->input('min_subtotal') : '';
        $selctdt = DB::table('offer_banner')->select('offer_banner.*')->where('id','=',$request->input('id'))->first();
        if ($files = $request->file('image')) {
                $destinationPath = public_path('../../uploads/'); 
                $profileImage =$files->getClientOriginalName();
                $files->move($destinationPath, $profileImage);
        }
        else
        {
           $profileImage =(!empty($selctdt->image))? $selctdt->image : '';   
        }
        $insert = DB::table('offer_banner')->where('id','=',$id)->update([
                'company_id'=>$company_id,
                'image' => $profileImage,
                'location'=>$location,
                'coupon_code'=>$code,
                'min_subtotal' => $min_subtotal,
                'discount_amount'=>$discount_amount,
                'expiry_date' => $expiry_date,
                'max_discount'=>$max_discount,
                'type'=>2
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
