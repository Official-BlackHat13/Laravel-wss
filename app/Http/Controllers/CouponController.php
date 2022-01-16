<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Storage;
use DB;

class CouponController extends Controller
{
    public function getcouponsDetails(){
        $users1 = DB::table('discounts')->select('discounts.*')->orderBy('discounts.id','desc')->get();
        return view('couponlist',['users1'=>$users1]);
    }

    public function create()
    {
        return view('add_coupons_form');
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'coupon_code'=>'required',
            'expiry_date'=>'required',
            'discount_type'=>'required',
            'discount_amount'=>'required',
            'max_discount'=>'required',
            'min_subtotal'=>'required'
        ]);
        $coupon_code = (!empty($request->input('coupon_code'))) ? $request->input('coupon_code') : '';
        $expiry_date = (!empty($request->input('expiry_date'))) ? $request->input('expiry_date') : '';
        $discount_type = (!empty($request->input('discount_type'))) ? $request->input('discount_type') : '';
        $discount_amount = (!empty($request->input('discount_amount'))) ? $request->input('discount_amount') : '';
        $max_discount = (!empty($request->input('max_discount'))) ? $request->input('max_discount') : '';
        $min_subtotal = (!empty($request->input('min_subtotal'))) ? $request->input('min_subtotal') : '';
        $insert = DB::table('discounts')->insert([
            'coupon_code' => $coupon_code,
            'discount_type'=>$discount_type,
            'min_subtotal' => $min_subtotal,
            'discount_amount'=>$discount_amount,
            'expiry_date' => $expiry_date,
            'max_discount'=>$max_discount
        ]);
        return redirect()->route('coupons')->with('success','Coupon has been added successfully.');
    }
    public function edit($id)
    {
        $editcoupons = DB::table('discounts')
                        ->where('id', '=',$id)
                        ->first();
        
        return view('coupons_form_edit',['editcoupons'=>$editcoupons]);
    }
    
    public function update(Request $request)
    {
        $id = (!empty($request->input('id'))) ? $request->input('id') : '';
        $coupon_code = (!empty($request->input('coupon_code'))) ? $request->input('coupon_code') : '';
        $expiry_date = (!empty($request->input('expiry_date'))) ? $request->input('expiry_date') : '';
        $discount_type = (!empty($request->input('discount_type'))) ? $request->input('discount_type') : '';
        $discount_amount = (!empty($request->input('discount_amount'))) ? $request->input('discount_amount') : '';
        $max_discount = (!empty($request->input('max_discount'))) ? $request->input('max_discount') : '';
        $min_subtotal = (!empty($request->input('min_subtotal'))) ? $request->input('min_subtotal') : '';
        
        $insert = DB::table('discounts')->where('id','=',$id)->update([
            'coupon_code' => $coupon_code,
            'discount_type'=>$discount_type,
            'min_subtotal' => $min_subtotal,
            'discount_amount'=>$discount_amount,
            'expiry_date' => $expiry_date,
            'max_discount'=>$max_discount
        ]);
        return redirect()->route('coupons')->with('success','Coupon has been updated successfully.');
    }
    public function delete($id)
    {
        $insert = DB::table('discounts')->where('id','=',$id)->delete();
        return redirect()->back()->with('success','Coupon has been deleted successfully.');   
    }
    
    public function deleteMultiple(Request $request){
        $ids = $request->ids;
        DB::table('discounts')->whereIn('id',explode(",",$ids))->delete();
        return redirect()->back()->with('success','Selected banners has been deleted successfully.');  
    }
    
    public function changecouponsstatus1($id){
        $insert = DB::table('discounts')->where('id','=',$id)->update([
            'status' => 1
        ]);
        return redirect()->back()->with('success','Status has been updated successfully.');
    }
    public function changecouponsstatus2($id){
        $insert = DB::table('discounts')->where('id','=',$id)->update([
            'status' => 2
        ]);
        return redirect()->back()->with('success','Status has been updated successfully.');
    }
}
