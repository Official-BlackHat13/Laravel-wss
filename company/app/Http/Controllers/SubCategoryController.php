<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Storage;
use DB;

class SubCategoryController extends Controller
{
    public function index(){
        $users1 = DB::table('sub_categories')
                ->leftjoin('categories','categories.id','=','sub_categories.category_id')
                ->select('sub_categories.*','categories.name as cname')
                ->orderBy('sub_categories.id','desc')
                ->get();
        return view('subcategorylist',['users1'=>$users1]);
    }

    public function create()
    { 
        $cat = DB::table('categories')
                        ->select('*')
                        ->get();
                        
        return view('add_sub_category_form',['cat'=>$cat]);
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=>'required'
        ]);
        
        $name = (!empty($request->input('name'))) ? $request->input('name') : '';
        $category_id = (!empty($request->input('category_id'))) ? $request->input('category_id') : '';
        $insert = DB::table('sub_categories')->insert([
                'name' => $name,
                'category_id'=>$category_id
        ]);
        
        return redirect()->route('sub-category')->with('success','Sub category has been added successfully.');
    }
    public function edit($id)
    {
        $cat = DB::table('categories')
                        ->select('*')
                        ->get();
                        
        $subcat = DB::table('sub_categories')
                        ->where('id', '=',$id)
                        ->first();
                        
        return view('sub_category_form_edit',['cat'=>$cat,'subcat'=>$subcat]);
    }
    
    public function update(Request $request)
    {
        $id = (!empty($request->input('id'))) ? $request->input('id') : '';
        $name = (!empty($request->input('name'))) ? $request->input('name') : '';
        $category_id = (!empty($request->input('category_id'))) ? $request->input('category_id') : '';
        
        $insert = DB::table('sub_categories')->where('id','=',$id)->update([
            'name' => $name,
            'category_id'=>$category_id
        ]);
        
        return redirect()->route('sub-category')->with('success','Category has been updated successfully.');
    }
    public function delete($id)
    {
        $insert = DB::table('sub_categories')->where('id','=',$id)->delete();
        return redirect()->back()->with('success','Category has been deleted successfully.');   
    }
    
    public function deleteMultiple(Request $request){
        $ids = $request->ids;
        DB::table('sub_categories')->whereIn('id',explode(",",$ids))->delete();
        return redirect()->back()->with('success','Selected banners has been deleted successfully.');  
    }
    
    public function changesubcatstatus1($id){
        $insert = DB::table('sub_categories')->where('id','=',$id)->update([
            'status' => 1
        ]);
        return redirect()->back()->with('success','Status has been updated successfully.');
    }
    public function changesubcatstatus2($id){
        $insert = DB::table('sub_categories')->where('id','=',$id)->update([
            'status' => 2
        ]);
        return redirect()->back()->with('success','Status has been updated successfully.');
    }
}
