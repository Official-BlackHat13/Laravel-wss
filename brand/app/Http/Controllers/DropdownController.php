<?php

namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use DB;
use Validator;
use Response;
use Redirect;
use App\Models\{Country, State, City};

class DropdownController extends Controller
{
    // public function index()
    // {
    //     $data['countries'] = Country::get(["name", "id"]);
    //     return view('add_company_form', $data);
    // }

    public function getState(Request $request)
    {
        // print_r($request->country_id);exit;
        $data['states'] = DB::table('states')->where("country_id",$request->country_id)->get(["name", "id"]);
        return response()->json($data);
    }

    public function getCity(Request $request)
    {
        $data['cities'] =  DB::table('cities')->where("state_id",$request->state_id)->get(["name", "id"]);
        return response()->json($data);
    }
    
    public function getCategory(Request $request)
    {
        $ids=$request->ids;
        $data['category'] =  DB::table('categories')->where('status',1)->whereIn('super_category_id',explode(",",$ids))->get(["name", "id"]);
        return response()->json($data);
    }
    
    public function getSubcat(Request $request)
    {
        $ids=$request->ids;
        $data['subcategory'] =  DB::table('sub_categories')->where('status',1)->whereIn('category_id',explode(",",$ids))->get(["name", "id"]);
        return response()->json($data);
    }
    public function getStore(Request $request){
        $uid=auth::user()->id;
        $com_id= DB::table('company_admin')->select('company_admin.company_id')->where('id','=',$uid)->first();
        $company_id=$com_id->company_id;
        $data['outlet'] = DB::table('outlets')->where("city",$request->city_id)->where("company_id",$company_id)->get(["outlet_location", "city","state","id"]);
        return response()->json($data);
    }
    
    public function getAdmin(Request $request){
        $data= DB::table('outlets')->select('store_admin_id')->where("id",$request->outlet_id)->get();
        foreach($data as $pids => $value){
            $pidss = explode(',',$value->store_admin_id);
        }
        $data['admin']=$request->outlet_id;
        $data['admin'] = DB::table('store_admin')->whereIn('id',$pidss)->get(['name', 'store_admin_id','my_score']);
        return response()->json($data);
    }
    
    public function getAdminData(Request $request){
        $data['video'] = DB::table('live_shop_requests')->where('store_admin_id','=',$request->admin_id)->where('outlet_id','=',$request->outlet_id)->where('type','=',1)->count();
        $data['audio'] = DB::table('live_shop_requests')->where('store_admin_id','=',$request->admin_id)->where('outlet_id','=',$request->outlet_id)->where('type','=',2)->count();
        $data['user'] = DB::table('live_shop_requests')->where('store_admin_id','=',$request->admin_id)->where('outlet_id','=',$request->outlet_id)->count(DB::raw('DISTINCT user_id'));
        $data['rating'] = DB::table('live_shop_requests')->where('store_admin_id','=',$request->admin_id)->where('outlet_id','=',$request->outlet_id)->avg('rating');
        $datas= DB::table('store_admin')->select('store_admin.my_score')->where("store_admin_id",$request->admin_id)->first();
        $data['points']=$datas->my_score;
        return response()->json($data);
    }
    
    public function getAdminSales(Request $request){
        
    }
}