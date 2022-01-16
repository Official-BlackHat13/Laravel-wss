<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Storage;
use DB;

class BannerController extends Controller
{
    public function getbannerDetails(){
        $users1 = DB::table('banner')->select('banner.*')->orderBy('banner.id','desc')->get();
        return view('bannerlist',['users1'=>$users1]);
    }

    public function create()
    {
        $locationlist=DB::table('banner_cities')
                        ->select('id','city')
                        ->get();
        //  print_r($locationlist);exit;               
        return view('add_banner_from',['locationlist'=>$locationlist]);
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'image'=>'required|image|mimes:jpeg,png,jpg,gif,svg',
            'location'=>'required'
        ]);
        $location = (!empty($request->input('location'))) ? $request->input('location') : '';
        $fileContents = $request->image;
        $dt = Storage::disk('custom')->put('/',$fileContents);
        $insert = DB::table('banner')->insert([
                'image' => $dt,
                'location'=>$location
        ]);
        return redirect()->route('banner')->with('success','Banner has been added successfully.');
    }
    public function edit($id)
    {
        $editbanner = DB::table('banner')
                        ->where('id', '=',$id)
                        ->first();
                        
        $locationlist=DB::table('banner_cities')
                        ->select('*')
                        ->get();
        
        return view('banner_from_edit',['editbanner'=>$editbanner,'locationlist'=>$locationlist]);
    }
    
    public function update(Request $request)
    {
        $id = (!empty($request->input('id'))) ? $request->input('id') : '';
        $location = (!empty($request->input('location'))) ? $request->input('location') : '';
        $selctdt = DB::table('banner')->select('banner.*')->where('id','=',$request->input('id'))->first();
         if(!empty($request->image)){
              $fileContents = $request->image;
              $dt = Storage::disk('custom')->put('/',$fileContents);
        }
        else
        {
           $dt =(!empty($selctdt->image))? $selctdt->image : '';   
        }
        $insert = DB::table('banner')->where('id','=',$id)->update([
            'image' => $dt,
            'location'=>$location
        ]);
        return redirect()->route('banner')->with('success','Banner has been updated successfully.');
    }
    public function delete($id)
    {
        $insert = DB::table('banner')->where('id','=',$id)->delete();
        return redirect()->back()->with('success','Banner has been deleted successfully.');   
    }
    
    public function deleteMultiple(Request $request){
        $ids = $request->ids;
        DB::table('banner')->whereIn('id',explode(",",$ids))->delete();
        return redirect()->back()->with('success','Selected banners has been deleted successfully.');  
    }
    
    public function changebannerstatus1($id){
        $insert = DB::table('banner')->where('id','=',$id)->update([
            'status' => 1
        ]);
        return redirect()->back()->with('success','Status has been updated successfully.');
    }
    public function changebannerstatus2($id){
        $insert = DB::table('banner')->where('id','=',$id)->update([
            'status' => 2
        ]);
        return redirect()->back()->with('success','Status has been updated successfully.');
    }
}
