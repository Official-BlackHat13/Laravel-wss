<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Storage;
use DB;

class SpecificationController extends Controller
{
    public function index(){
        $users1 = DB::table('specifications')
                ->select('specifications.*')
                ->orderBy('specifications.id','desc')
                ->get();
        return view('specificationlist',['users1'=>$users1]);
    }

    public function create()
    {                 
        return view('add_specification_form');
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=>'required',
            'keyword'=>'required',
        ]);
        
        $name = (!empty($request->input('name'))) ? $request->input('name') : '';
        $keyword = (!empty($request->input('keyword'))) ? $request->input('keyword') : '';
        
        $insert = DB::table('specifications')->insert([
                'name' => $name,
                'value'=>$keyword
        ]);
        
        return redirect()->route('specifications')->with('success','Specifications has been added successfully.');
    }
    public function edit($id)
    {
        $spec = DB::table('specifications')
                        ->select('*')
                        ->where('id','=',$id)
                        ->first();
                        
        return view('specification_form_edit',['spec'=>$spec]);
    }
    
    public function update(Request $request)
    {
        $id = (!empty($request->input('id'))) ? $request->input('id') : '';
        $name = (!empty($request->input('name'))) ? $request->input('name') : '';
        $keyword = (!empty($request->input('keyword'))) ? $request->input('keyword') : '';
        
        $insert = DB::table('specifications')->where('id','=',$id)->update([
            'name' => $name,
                'value'=>$keyword
        ]);
        
        return redirect()->route('specifications')->with('success','Specifications has been updated successfully.');
    }
    public function delete($id)
    {
        $insert = DB::table('specifications')->where('id','=',$id)->delete();
        return redirect()->back()->with('success','Specifications has been deleted successfully.');   
    }
    
    public function deleteMultiple(Request $request){
        $ids = $request->ids;
        DB::table('specifications')->whereIn('id',explode(",",$ids))->delete();
        return redirect()->back()->with('success','Selected Specifications has been deleted successfully.');  
    }
    
    public function changecatstatus1($id){
        $insert = DB::table('specifications')->where('id','=',$id)->update([
            'status' => 1
        ]);
        return redirect()->back()->with('success','Status has been updated successfully.');
    }
    public function changecatstatus2($id){
        $insert = DB::table('specifications')->where('id','=',$id)->update([
            'status' => 2
        ]);
        return redirect()->back()->with('success','Status has been updated successfully.');
    }
    
    public function rest(){
        $users1 = DB::table('subcategory_restriction')
                ->rightjoin('sub_categories','sub_categories.id','=','subcategory_restriction.subcategory_id')
                ->select('subcategory_restriction.*','sub_categories.name as subname')
                ->orderBy('subcategory_restriction.id','desc')
                ->get();
        return view('specificationrestrictionlist',['users1'=>$users1]);
    }
    
    public function assign(){
        $users1 = DB::table('specifications')
                ->select('specifications.*')
                ->get();
        $users2 = DB::table('sub_categories')
                ->select('sub_categories.*')
                ->get();        
        return view('assign-specification',['users1'=>$users1,'users2'=>$users2]);
    }
    
    public function storespec(Request $request){
        $this->validate($request, [
            'subcategory_id'=>'required',
            'specification'=>'required',
        ]);
        $sub = (!empty($request->input('subcategory_id'))) ? $request->input('subcategory_id') : '';
        $spec = (!empty($request->input('specification'))) ? $request->input('specification') : '';
        $insertt = DB::table('subcategory_restriction')->where('subcategory_id','=',$sub)->first();
        if(!empty($insertt)){
            $insert = DB::table('subcategory_restriction')->where('subcategory_id','=',$sub)->update([
                    'subcategory_id' => $sub,
                    'restrictionspecification'=>implode(',',$spec)
            ]);
            
            return redirect()->route('specifications-restriction')->with('success','Specifications has been assigned successfully.');
        }else{
            $insert = DB::table('subcategory_restriction')->insert([
                    'subcategory_id' => $sub,
                    'restrictionspecification'=>implode(',',$spec)
            ]);
            return redirect()->route('specifications-restriction')->with('success','Specifications has been assigned successfully.');
        }
    }
    
    public function editres($id){
        $users1 = DB::table('specifications')
                ->select('specifications.*')
                ->get();
        $users2 = DB::table('sub_categories')
                ->select('sub_categories.*')
                ->get(); 
                
        $edituser = DB::table('subcategory_restriction')
                ->select('*')
                ->where('id','=',$id)
                ->first();  
                
        return view('edit-restriction',['users1'=>$users1,'users2'=>$users2,'edituser'=>$edituser]);        
    }
    
    public function updateres(Request $request){
        $id = (!empty($request->input('id'))) ? $request->input('id') : '';
        $sub = (!empty($request->input('subcategory_id'))) ? $request->input('subcategory_id') : '';
        $spec = (!empty($request->input('specification'))) ? $request->input('specification') : '';
        
        $insertt = DB::table('subcategory_restriction')->where('subcategory_id','=',$sub)->first();
        if(!empty($insertt)){
            return redirect()->route('specifications-restriction')->with('success','You have already gave restriction for this sub category');
        }else{
            $insert = DB::table('subcategory_restriction')->where('id','=',$id)->update([
                    'subcategory_id' => $sub,
                    'restrictionspecification'=>implode(',',$spec)
            ]);
            return redirect()->route('specifications-restriction')->with('success','Specifications has been assigned successfully.');
        }
    }
    
}
