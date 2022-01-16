<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Storage;
use DB;

class PerformanceController extends Controller
{
    public function index(){
        $users1 = DB::table('banner_cities')
                    ->select('banner_cities.*')
                    ->get();
        return view('userstaffinteraction',['users1'=>$users1]);
    }
    
    public function staffindex(){
        $users1 = DB::table('banner_cities')
                    ->select('banner_cities.*')
                    ->get();
        return view('staffperformance',['users1'=>$users1]);
    }
    
    public function salesindex(){
        $users1 = DB::table('banner_cities')
                    ->select('banner_cities.*')
                    ->get();
        return view('salesperformance',['users1'=>$users1]);
    }
}
