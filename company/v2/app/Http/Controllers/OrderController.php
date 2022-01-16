<?php

namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use DB;
use Validator;
use Response;
use Redirect;
use auth;
class OrderController extends Controller
{
    public function index()
    {
        $uid=auth::user()->id;
        $com_id= DB::table('company_admin')->select('company_admin.company_id')->where('id','=',$uid)->first();
        $company_id=$com_id->company_id;
        
        $users1 = DB::table('transactions')
                ->select('transactions.*','users.name as u_name','users.mobile','orders.address','product.product_name as p_name','color.Name as c_name','size.Size as s_name')
                ->leftjoin('users','users.id','=','transactions.user_id')
                ->leftjoin('orders','orders.order_id','=','transactions.order_id')
                ->leftjoin('product','product.id','=','transactions.product_id')
                ->leftjoin('color','color.id','=','transactions.color_id')
                ->leftjoin('size','size.id','=','transactions.size_id')
                ->where('transactions.company_id','=',$company_id)
                ->orderBy('transactions.id','desc')
                ->get();
        return view('orderlist',['users1'=>$users1]);
    
    }
    
    public function deleteorder($id){
        $insert = DB::table('transactions')->where('id','=',$id)->delete();
        return redirect()->route('orderdetails')->with('success','Order has been deleted successfully.');  
    }
    
    public function deleteMultiple(Request $request){
        $ids = $request->ids;
        DB::table('transactions')->whereIn('id',explode(",",$ids))->delete();
        return redirect()->back()->with('success','Selected Orders has been deleted successfully.');  
    }
    
    public function UpdateOrderStatus(Request $request) {
        $data = array('status' => $request->input('status'));
        if (DB::table('transactions')->where('id', $request->input('id'))->update($data)) {
            echo json_encode('Done');
        } else {
            echo json_encode('error');
        }
    }
    
}
