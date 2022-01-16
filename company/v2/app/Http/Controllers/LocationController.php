<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Storage;
use DB;

class LocationController extends Controller
{
    public function index(){
        $users1 = DB::table('cities')
                ->select('*')
                ->orderBy('cities.id','desc')
                ->get();
        return view('locationlist',['users1'=>$users1]);
    }

    public function create()
    { 
        return view('add_location_form');
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=>'required',
            'pincode'=>'required'
        ]);
        
        $name = (!empty($request->input('name'))) ? $request->input('name') : '';
        $pincode = (!empty($request->input('pincode'))) ? $request->input('pincode') : '';
        $pincodes = explode(',', $pincode);
        
        $insert = DB::table('cities')->insertGetId([
                'city' => $name
        ]);
        
        foreach ($pincodes as $key => $value) {
            $insertcr = DB::table('cities_pincode')->insert(['pincode' => $value,
                'city_id'=>$insert
            ]); 
        }
        
        return redirect()->route('location')->with('success','Location has been added successfully.');
    }
    
    public function edit($id)
    {
        $loc = DB::table('cities')
                        ->where('id', '=',$id)
                        ->first();
                        
        $pin =  DB::table('cities_pincode')
                        ->select('cities_pincode.pincode')
                        ->where('city_id', '=',$id)
                        ->get();
                        
        foreach($pin as $key=>$value){
            $pidss[] =$value->pincode;
        }
        if(!empty($pidss)){
            $str = implode(',', $pidss);
        }else{
            $str='';
        }
                        
        return view('location_form_edit',['loc'=>$loc,'pin'=>$str]);
    }
    
    public function update(Request $request)
    {
        $id = (!empty($request->input('id'))) ? $request->input('id') : '';
        $name = (!empty($request->input('name'))) ? $request->input('name') : '';
        $pincode = (!empty($request->input('pincode'))) ? $request->input('pincode') : '';
        $pincodes = explode(',', $pincode);
        
        $insert = DB::table('cities')->where('id','=',$id)->update([
            'city' => $name
        ]);
        
        $del= DB::table('cities_pincode')->where('city_id','=',$id)->delete();
        foreach ($pincodes as $key => $value) {
            $insertcr = DB::table('cities_pincode')->insert(['pincode' => $value,
                'city_id'=>$id
            ]); 
        }
        
        return redirect()->route('location')->with('success','Location has been updated successfully.');
    }
    
    public function delete($id)
    {
        $insert = DB::table('cities')->where('id','=',$id)->delete();
        return redirect()->back()->with('success','Location has been deleted successfully.');   
    }
    
    public function deleteMultiple(Request $request){
        $ids = $request->ids;
        DB::table('cities')->whereIn('id',explode(",",$ids))->delete();
        return redirect()->back()->with('success','Selected banners has been deleted successfully.');  
    }
    
    public function changelocstatus1($id){
        $insert = DB::table('cities')->where('id','=',$id)->update([
            'status' => 1
        ]);
        return redirect()->back()->with('success','Status has been updated successfully.');
    }
    public function changelocstatus2($id){
        $insert = DB::table('cities')->where('id','=',$id)->update([
            'status' => 2
        ]);
        return redirect()->back()->with('success','Status has been updated successfully.');
    }
}
