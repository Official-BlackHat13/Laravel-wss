<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Storage;
use DB;

class LocationController extends Controller
{
    public function index(){
        $users1 = DB::table('banner_cities')
                ->select('*')
                ->orderBy('banner_cities.id','desc')
                ->get();
                
        return view('locationlist',['users1'=>$users1]);
    }

    public function create()
    { 
        $states = DB::table('states')->select('*')->where("country_id",101)->get();
        return view('add_location_form',['state'=>$states]);
    }
    
    public function getCity(Request $request)
    {
        $data['cities'] =  DB::table('cities')->where("state_id",$request->state_id)->get(["name", "id"]);
        return response()->json($data);
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'city'=>'required',
            'state'=>'required',
            'image'=>'required|image|mimes:jpeg,png,jpg,gif,svg'
            // 'pincode'=>'required'
        ]);
        
        $fileContents = $request->image;
        $dt = Storage::disk('custom')->put('/',$fileContents);
        $name = (!empty($request->input('city'))) ? $request->input('city') : '';
        $state = (!empty($request->input('state'))) ? $request->input('state') : '';
        // $pincodes = explode(',', $pincode);
        
        $insert = DB::table('banner_cities')->insertGetId([
                'state'=>$state,
                'city' => $name,
                'image'=>$dt
        ]);
        
        // foreach ($pincodes as $key => $value) {
        //     $insertcr = DB::table('cities_pincode')->insert(['pincode' => $value,
        //         'city_id'=>$insert
        //     ]); 
        // }
        
        return redirect()->route('location')->with('success','Location has been added successfully.');
    }
    
    public function edit($id)
    {
        $loc = DB::table('banner_cities')
                        ->where('id', '=',$id)
                        ->first();
        $states = DB::table('states')->select('*')->where("country_id",101)->get();
        
        // $pin =  DB::table('cities_pincode')
        //                 ->select('cities_pincode.pincode')
        //                 ->where('city_id', '=',$id)
        //                 ->get();
                        
        // foreach($pin as $key=>$value){
        //     $pidss[] =$value->pincode;
        // }
        // if(!empty($pidss)){
        //     $str = implode(',', $pidss);
        // }else{
        //     $str='';
        // }
                        
        return view('location_form_edit',['loc'=>$loc,'state'=>$states]);
    }
    
    public function update(Request $request)
    {
        $id = (!empty($request->input('id'))) ? $request->input('id') : '';
        $name = (!empty($request->input('city'))) ? $request->input('city') : '';
        $state = (!empty($request->input('state'))) ? $request->input('state') : '';
        // $pincodes = explode(',', $pincode);
        $selctdt = DB::table('banner_cities')->select('banner_cities.*')->where('id','=',$request->input('id'))->first();
         if(!empty($request->image)){
              $fileContents = $request->image;
              $dt = Storage::disk('custom')->put('/',$fileContents);
        }
        else
        {
           $dt =(!empty($selctdt->image))? $selctdt->image : '';   
        }
        $insert = DB::table('banner_cities')->where('id','=',$id)->update([
            'city' => $name,
            'state'=>$state,
            'image'=>$dt
        ]);
        
        // $del= DB::table('cities_pincode')->where('city_id','=',$id)->delete();
        // foreach ($pincodes as $key => $value) {
        //     $insertcr = DB::table('cities_pincode')->insert(['pincode' => $value,
        //         'city_id'=>$id
        //     ]); 
        // }
        
        return redirect()->route('location')->with('success','Location has been updated successfully.');
    }
    
    public function delete($id)
    {
        $insert = DB::table('banner_cities')->where('id','=',$id)->delete();
        return redirect()->back()->with('success','Location has been deleted successfully.');   
    }
    
    public function changelocstatus1($id){
        $insert = DB::table('banner_cities')->where('id','=',$id)->update([
            'status' => 1
        ]);
        return redirect()->back()->with('success','Status has been updated successfully.');
    }
    
    public function changelocstatus2($id){
        $insert = DB::table('banner_cities')->where('id','=',$id)->update([
            'status' => 2
        ]);
        return redirect()->back()->with('success','Status has been updated successfully.');
    }
    
    public function deleteMultiple(Request $request){
        $ids = $request->ids;
        DB::table('banner_cities')->whereIn('id',explode(",",$ids))->delete();
        return redirect()->back()->with('success','Selected locations has been deleted successfully.');  
    }
}
