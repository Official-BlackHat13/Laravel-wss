<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Storage;
use DB;

class SuperCategoryController extends Controller
{
    public function index(){
        $users1 = DB::table('super_categories')->select('super_categories.*')->orderBy('super_categories.id','desc')->get();
        return view('supercatlist',['users1'=>$users1]);
    }

    public function create()
    { 
        return view('add_super_category_form');
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=>'required'
        ]);
        $name = (!empty($request->input('name'))) ? $request->input('name') : '';
       
        $insert = DB::table('super_categories')->insert([
                'name' => $name
        ]);
        return redirect()->route('super-category')->with('success','Super category has been added successfully.');
    }
    public function edit($id)
    {
        $scat = DB::table('super_categories')
                        ->where('id', '=',$id)
                        ->first();
        return view('super_category_form_edit',['scat'=>$scat]);
    }
    
    public function update(Request $request)
    {
        $id = (!empty($request->input('id'))) ? $request->input('id') : '';
        $name = (!empty($request->input('name'))) ? $request->input('name') : '';
        $insert = DB::table('super_categories')->where('id','=',$id)->update([
            'name' => $name
        ]);
        return redirect()->route('super-category')->with('success','Super category has been updated successfully.');
    }
    public function delete($id)
    {
        $insert = DB::table('super_categories')->where('id','=',$id)->delete();
        return redirect()->back()->with('success','Super category has been deleted successfully.');   
    }
    
    public function deleteMultiple(Request $request){
        $ids = $request->ids;
        DB::table('super_categories')->whereIn('id',explode(",",$ids))->delete();
        return redirect()->back()->with('success','Selected banners has been deleted successfully.');  
    }
    
    
    public function changescatstatus1($id){
        $insert = DB::table('super_categories')->where('id','=',$id)->update([
            'status' => 1
        ]);
        return redirect()->back()->with('success','Status has been updated successfully.');
    }
    public function changescatstatus2($id){
        $insert = DB::table('super_categories')->where('id','=',$id)->update([
            'status' => 2
        ]);
        return redirect()->back()->with('success','Status has been updated successfully.');
    }
}
