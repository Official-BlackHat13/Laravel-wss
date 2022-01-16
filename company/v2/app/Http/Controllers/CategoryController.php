<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Storage;
use DB;

class CategoryController extends Controller
{
    public function index(){
        $users1 = DB::table('categories')
                ->leftjoin('super_categories','super_categories.id','=','categories.super_category_id')
                ->select('categories.*','super_categories.name as sname')
                ->orderBy('categories.id','desc')
                ->get();
        return view('categorylist',['users1'=>$users1]);
    }

    public function create()
    { 
        $scat = DB::table('super_categories')
                        ->select('*')
                        ->get();
                        
        return view('add_category_form',['scat'=>$scat]);
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=>'required'
        ]);
        
        $name = (!empty($request->input('name'))) ? $request->input('name') : '';
        $super_cat_id = (!empty($request->input('super_cat_id'))) ? $request->input('super_cat_id') : '';
        $insert = DB::table('categories')->insert([
                'name' => $name,
                'super_category_id'=>$super_cat_id
        ]);
        
        return redirect()->route('category')->with('success','Category has been added successfully.');
    }
    public function edit($id)
    {
        $scat = DB::table('super_categories')
                        ->select('*')
                        ->get();
                        
        $cat = DB::table('categories')
                        ->where('id', '=',$id)
                        ->first();
                        
        return view('category_form_edit',['cat'=>$cat,'scat'=>$scat]);
    }
    
    public function update(Request $request)
    {
        $id = (!empty($request->input('id'))) ? $request->input('id') : '';
        $name = (!empty($request->input('name'))) ? $request->input('name') : '';
        $super_cat_id = (!empty($request->input('super_cat_id'))) ? $request->input('super_cat_id') : '';
        
        $insert = DB::table('categories')->where('id','=',$id)->update([
            'name' => $name,
            'super_category_id'=>$super_cat_id
        ]);
        
        return redirect()->route('category')->with('success','Category has been updated successfully.');
    }
    public function delete($id)
    {
        $insert = DB::table('categories')->where('id','=',$id)->delete();
        return redirect()->back()->with('success','Category has been deleted successfully.');   
    }
    
    public function deleteMultiple(Request $request){
        $ids = $request->ids;
        DB::table('categories')->whereIn('id',explode(",",$ids))->delete();
        return redirect()->back()->with('success','Selected banners has been deleted successfully.');  
    }
    
    public function changecatstatus1($id){
        $insert = DB::table('categories')->where('id','=',$id)->update([
            'status' => 1
        ]);
        return redirect()->back()->with('success','Status has been updated successfully.');
    }
    public function changecatstatus2($id){
        $insert = DB::table('categories')->where('id','=',$id)->update([
            'status' => 2
        ]);
        return redirect()->back()->with('success','Status has been updated successfully.');
    }
}
