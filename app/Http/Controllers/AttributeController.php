<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Storage;
use DB;

class AttributeController extends Controller
{
    public function index(){
        $users1 = DB::table('attribute')
                ->select('attribute.*')
                ->orderBy('attribute.id','desc')
                ->get();
        return view('attributelist',['users1'=>$users1]);
    }

    public function create()
    {                 
        return view('add_attribute_form');
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=>'required'
            // 'keyword'=>'required',
        ]);
        
        $name = (!empty($request->input('name'))) ? $request->input('name') : '';
        // $keyword = (!empty($request->input('keyword'))) ? $request->input('keyword') : '';
        
        $insert = DB::table('attribute')->insert([
                'name' => $name
                // 'value'=>$keyword
        ]);
        
        return redirect()->route('attributes')->with('success','Attribute has been added successfully.');
    }
    public function edit($id)
    {
        $attr = DB::table('attribute')
                        ->select('*')
                        ->where('id','=',$id)
                        ->first();
                        
        return view('attribute_form_edit',['attr'=>$attr]);
    }
    
    public function update(Request $request)
    {
        $id = (!empty($request->input('id'))) ? $request->input('id') : '';
        $name = (!empty($request->input('name'))) ? $request->input('name') : '';
        // $keyword = (!empty($request->input('keyword'))) ? $request->input('keyword') : '';
        
        $insert = DB::table('attribute')->where('id','=',$id)->update([
            'name' => $name
            // 'value'=>$keyword
        ]);
        
        return redirect()->route('attributes')->with('success','Attribute has been updated successfully.');
    }
    public function delete($id)
    {
        $insert = DB::table('attribute')->where('id','=',$id)->delete();
        return redirect()->back()->with('success','Attribute has been deleted successfully.');   
    }
    
    public function deleteMultiple(Request $request){
        $ids = $request->ids;
        DB::table('attribute')->whereIn('id',explode(",",$ids))->delete();
        return redirect()->back()->with('success','Selected Attributes has been deleted successfully.');  
    }
    
    public function changeatstatus1($id){
        $insert = DB::table('attribute')->where('id','=',$id)->update([
            'status' => 1
        ]);
        return redirect()->back()->with('success','Status has been updated successfully.');
    }
    public function changeatstatus2($id){
        $insert = DB::table('attribute')->where('id','=',$id)->update([
            'status' => 2
        ]);
        return redirect()->back()->with('success','Status has been updated successfully.');
    }
    
}
