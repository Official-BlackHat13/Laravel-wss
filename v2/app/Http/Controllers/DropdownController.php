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
        $id=$request->id;
        $data['category'] =  DB::table('categories')->where('status',1)->where('super_category_id',$request->id)->get(["name", "id"]);
        return response()->json($data);
    }
    
    public function getSubcat(Request $request)
    {
        $id=$request->id;
        $data['subcategory'] =  DB::table('sub_categories')->where('status',1)->whereIn('category_id',$request->id)->get(["name", "id"]);
        return response()->json($data);
    }
}