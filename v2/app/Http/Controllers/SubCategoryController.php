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
                ->leftjoin('super_categories','super_categories.id','=','sub_categories.sup_category_id')
                ->select('sub_categories.*','categories.name as cname','super_categories.name as sname')
                ->orderBy('sub_categories.id','desc')
                ->get();
        return view('subcategorylist',['users1'=>$users1]);
    }

    public function create()
    { 
        
        $supcat = DB::table('super_categories')
                        ->select('*')
                        ->where('status','=',1)
                        ->get();
                        
        $cat = DB::table('categories')
                        ->select('*')
                        ->where('status','=',1)
                        ->get();
                        
        return view('add_sub_category_form',['supcat'=>$supcat,'cat'=>$cat]);
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=>'required'
            // 'image'=>'required|image|mimes:jpeg,png,jpg,gif,svg'
        ]);
        
        $name = (!empty($request->input('name'))) ? $request->input('name') : '';
        $sup_category_id = (!empty($request->input('super_category_id'))) ? $request->input('super_category_id') : '';
        $category_id = (!empty($request->input('category_id'))) ? $request->input('category_id') : '';
        // $fileContents = $request->image;
        // $dt = Storage::disk('custom')->put('/',$fileContents);
        $insert = DB::table('sub_categories')->insert([
                // 'image' => $dt,
                'name' => $name,
                'category_id'=>$category_id,
                'sup_category_id'=>$sup_category_id
        ]);
        
        return redirect()->route('sub-category')->with('success','Sub category has been added successfully.');
    }
    public function edit($id)
    {
        $supcat = DB::table('super_categories')
                        ->select('*')
                        ->get();
                        
        $cat = DB::table('categories')
                        ->select('*')
                        ->get();
                        
        $subcat = DB::table('sub_categories')
                        ->where('id', '=',$id)
                        ->first();
                        
        return view('sub_category_form_edit',['supcat'=>$supcat,'cat'=>$cat,'subcat'=>$subcat]);
    }
    
    public function update(Request $request)
    {
        $id = (!empty($request->input('id'))) ? $request->input('id') : '';
        $name = (!empty($request->input('name'))) ? $request->input('name') : '';
        $category_id = (!empty($request->input('category_id'))) ? $request->input('category_id') : '';
         $sup_category_id = (!empty($request->input('super_category_id'))) ? $request->input('super_category_id') : '';
        $selctdt = DB::table('sub_categories')->select('sub_categories.*')->where('id','=',$request->input('id'))->first();
        // if(!empty($request->image)){
        //       $fileContents = $request->image;
        //       $dt = Storage::disk('custom')->put('/',$fileContents);
        // }
        // else
        // {
        //   $dt =(!empty($selctdt->image))? $selctdt->image : '';   
        // }
        $insert = DB::table('sub_categories')->where('id','=',$id)->update([
            // 'image' => $dt,
            'name' => $name,
            'category_id'=>$category_id,
            'sup_category_id'=>$sup_category_id
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
