<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Storage;
use DB;
use Illuminate\Support\Facades\Hash;
use auth;

class CommController extends Controller
{
    public function index(){
        $uid=auth::user()->id;
        $brand_id= DB::table('brand_admin')->select('brand_admin.company_id')->where('id','=',$uid)->first();
        
        $com_id= DB::table('company_admin')->select('company_admin.*')->where('company_id','=',$brand_id->company_id)->first();
        $company_id=$com_id->company_id;
        $users1 = DB::table('company_pay_per_click')->select(DB::raw("SUM(quick_shop_count) as quickshopcount"),DB::raw("SUM(live_shop_count) as liveshopcount"))->where("company_id", "like","%".$company_id."%")->first();
        return view('commercials',['users1'=>$users1,'company'=>$com_id]);
    }
}
