<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Storage;
use DB;
use auth;
use Illuminate\Support\Facades\Hash;

class ProductController extends Controller
{
    public function index(){
        $uid=auth::user()->id;
        $brand_id= DB::table('brand_admin')->select('brand_admin.brand_admin_id')->where('id','=',$uid)->first();
        $brand_admin_id=$brand_id->brand_admin_id;
        
        $users1 = DB::table('product')
                ->leftjoin('categories','categories.id','=','product.category_id')
                ->leftjoin('sub_categories','sub_categories.id','=','product.subcategory_id')
                ->leftjoin('super_categories','super_categories.id','categories.super_category_id')
                ->select('product.*','super_categories.name as supercatname','categories.name as catname','sub_categories.name as subcatname')
                ->where("brand_admin_id", "like","%".$brand_admin_id."%")
                ->orderBy('product.id','desc')->get();
        return view('productlist',['users1'=>$users1]);
    }
    
    public function create()
    {
        $uid=auth::user()->id;
        $brand_id= DB::table('brand_admin')->select('brand_admin.brand_admin_id','brand_admin.company_id')->where('id','=',$uid)->first();
        $company_id=$brand_id->company_id;
        $com_id= DB::table('company_admin')->select('company_admin.*')->where("company_id", "like","%".$company_id."%")->first();
        
        $supcat = DB::table('super_categories')->select('super_categories.*')->where('status','=',1)->get();
        $cat = DB::table('categories')->select('categories.*')->where('status','=',1)->get();
        $subcat = DB::table('sub_categories')->select('sub_categories.*')->where('status','=',1)->get();
        $store = DB::table('store_admin')->select('store_admin.store_admin_id')->where('status','=',1)->get();
        $color = DB::table('color')->select('color.*')->where('status','=',1)->get();
        $size = DB::table('size')->select('size.*')->where('status','=',1)->get();
        
        return view('add_product_form',['supcat'=>$supcat,'cat'=>$cat,'subcat'=>$subcat,'store'=>$store,'color'=>$color,'size'=>$size,'company_detail'=>$com_id]);
    }
    public function store(Request $request)
    {
        $uid=auth::user()->id;
        $brand_id= DB::table('brand_admin')->select('brand_admin.brand_admin_id','brand_admin.company_id')->where('id','=',$uid)->first();
        $brand_admin_id=$brand_id->brand_admin_id;
        $company_id=$brand_id->company_id;
        
        
        $this->validate($request, [
            'product_name'=>'required',
            'sku'=>'required',
            'price'=>'required',
            // 'quantity'=>'required',
            'image' => 'required',
            'image.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'product_description'=>'required'
        ]);
        $product_name = (!empty($request->input('product_name'))) ? $request->input('product_name') : '';
        $store_admin_id = (!empty($request->input('store_admin_id'))) ? $request->input('store_admin_id') : '';
        $sku = (!empty($request->input('sku'))) ? $request->input('sku') : '';
        $super_category_id = (!empty($request->input('super_category_id'))) ? $request->input('super_category_id') : '';
        $category_id = (!empty($request->input('category_id'))) ? $request->input('category_id') : '';
        $subcategory_id = (!empty($request->input('subcategory_id'))) ? $request->input('subcategory_id') : '';
        $price = (!empty($request->input('price'))) ? $request->input('price') : '';
        // $quantity = (!empty($request->input('quantity'))) ? $request->input('quantity') : '';
        $offers = (!empty($request->input('offers'))) ? $request->input('offers') : '';
        $description = (!empty($request->input('product_description'))) ? $request->input('product_description') : '';
        
        $shape = (!empty($request->input('shape'))) ? $request->input('shape') : '';
        $type = (!empty($request->input('type'))) ? $request->input('type') : '';
        $material = (!empty($request->input('frame_material'))) ? $request->input('frame_material') : '';
        $frame = (!empty($request->input('frame_fit'))) ? $request->input('frame_fit') : '';
        $color_id = (!empty($request->input('color_id'))) ? $request->input('color_id') : '';
        $size_id =  (!empty($request->input('size_id'))) ? $request->input('size_id'): '';
        
        if(!empty($color_id)){
            $color=implode(',', $color_id);
        }else{
            $color='';
        }
        if(!empty($size_id)){
            $color=implode(',', $size_id);
        }else{
            $size='';
        }
        
        if($files = $request->file('image'))
        {
            $photos=request()->file('image');
            
            $uploadcount = 0;
            
            foreach ($photos as $photo)
            {
                $destinationPath = public_path('../../uploads/');
                $filename =  $photo->getClientOriginalName();
                $photo->move($destinationPath,$filename);
                $uploadcount ++;
                $data[] = $filename;
            }
            $filename=json_encode($data);
        }
        
        $insert = DB::table('product')->insertGetId([
            'company_id'=>$company_id,
            'brand_admin_id' => $brand_admin_id,
            'store_admin_id'=>$store_admin_id,
            'brand_sku' => $sku,
            'product_name'=>$product_name,
            'super_category_id' => $super_category_id,
            'category_id'=>$category_id,
            'subcategory_id' => $subcategory_id,
            'price' => $price,
            'Attribute1' => $description,
            // 'quantity' => $quantity,
            'offers'=>$offers,
            'images'=>$filename,
            'color'=>$color,
            'size'=>$size,
            'Attribute2'=>$shape,
            'Attribute3' => $type,
            'Attribute4'=>$material,
            'Attribute5'=>$frame
        ]);
        
        return redirect()->route('product')->with('success','Product has been added successfully.');
    }
    
    public function delete($id)
    {
        $insert = DB::table('product')->where('id','=',$id)->delete();
        return redirect()->route('product')->with('success','Product has been deleted successfully.');  
    }
    
    public function deleteMultiple(Request $request){
        $ids = $request->ids;
        DB::table('product')->whereIn('id',explode(",",$ids))->delete();
        return redirect()->back()->with('success','Selected banners has been deleted successfully.');  
    }

    public function edit($id)
    {
        $edituser = DB::table('product')
                    ->select('*')
                    ->where('id', '=',$id)
                    ->first();
        
        $uid=auth::user()->id;
        $brand_id= DB::table('brand_admin')->select('brand_admin.brand_admin_id','brand_admin.company_id')->where('id','=',$uid)->first();
        $company_id=$brand_id->company_id;
        $com_id= DB::table('company_admin')->select('company_admin.*')->where("company_id", "like","%".$company_id."%")->first();
        
        $supcat = DB::table('super_categories')->select('super_categories.*')->where('status','=',1)->get();
        $cat = DB::table('categories')->select('categories.*')->where('status','=',1)->get();
        $subcat = DB::table('sub_categories')->select('sub_categories.*')->where('status','=',1)->get();
        $store = DB::table('store_admin')->select('store_admin.store_admin_id')->where('status','=',1)->get();
        $color = DB::table('color')->select('color.*')->where('status','=',1)->get();
        $size = DB::table('size')->select('size.*')->where('status','=',1)->get();
        
        $product_color = DB::table('product_color')->leftjoin('color','color.id','=','product_color.color_id')
                        ->select('product_color.color_id','color.Name')
                        ->where('product_id','=',$id)->get();
                        
        $product_size = DB::table('product_size')
                        ->leftjoin('size','size.id','=','product_size.size_id')
                        ->select('product_size.size_id','size.Size')
                        ->where('product_id','=',$id)->get();
                        
        $product_imgs = DB::table('product_gallery')
                        ->select('id','product_gallery.product_image')
                        ->where('product_id','=',$id)->get();                
        
        return view('product_form_edit',['edituser'=>$edituser,'supcat'=>$supcat,'cat'=>$cat,'subcat'=>$subcat,'store'=>$store,'color'=>$color,'size'=>$size,'product_color'=>$product_color,'product_size'=>$product_size,'product_imgs'=>$product_imgs,'company_detail'=>$com_id]);
    }
    
    public function update(Request $request)
    {
        $uid=auth::user()->id;
        $brand_id= DB::table('brand_admin')->select('brand_admin.brand_admin_id','brand_admin.company_id')->where('id','=',$uid)->first();
        $brand_admin_id=$brand_id->brand_admin_id;
        $company_id=$brand_id->company_id;
        
        $id = (!empty($request->input('id'))) ? $request->input('id') : '';
        $product_name = (!empty($request->input('product_name'))) ? $request->input('product_name') : '';
        $store_admin_id = (!empty($request->input('store_admin_id'))) ? $request->input('store_admin_id') : '';
        $sku = (!empty($request->input('sku'))) ? $request->input('sku') : '';
        $super_category_id = (!empty($request->input('super_category_id'))) ? $request->input('super_category_id') : '';
        $category_id = (!empty($request->input('category_id'))) ? $request->input('category_id') : '';
        $subcategory_id = (!empty($request->input('subcategory_id'))) ? $request->input('subcategory_id') : '';
        $search_keywords = (!empty($request->input('search_keywords'))) ? $request->input('search_keywords') : '';
        $price = (!empty($request->input('price'))) ? $request->input('price') : '';
        $dimension = (!empty($request->input('dimension'))) ? $request->input('dimension') : '';
        $weight = (!empty($request->input('weight'))) ? $request->input('weight') : '';
        $height = (!empty($request->input('height'))) ? $request->input('height') : '';
        $width = (!empty($request->input('width'))) ? $request->input('width') : '';
        $length = (!empty($request->input('length'))) ? $request->input('length') : '';
        $offered_price = (!empty($request->input('offered_price'))) ? $request->input('offered_price') : '';
        $quantity = (!empty($request->input('quantity'))) ? $request->input('quantity') : '';
        $offers = (!empty($request->input('offers'))) ? $request->input('offers') : '';
        $specification = (!empty($request->input('specification'))) ? $request->input('specification') : '';
        $description = (!empty($request->input('product_description'))) ? $request->input('product_description') : '';
        
        $insert = DB::table('product')->where('id','=',$id)->update([
            'company_id'=>$company_id,
            'brand_admin_id' => $brand_admin_id,
            'store_admin_id'=>$store_admin_id,
            'brand_sku' => $sku,
            'product_name'=>$product_name,
            'super_category_id' => $super_category_id,
            'category_id'=>$category_id,
            'subcategory_id' => $subcategory_id,
            'search_keywords'=>$search_keywords,
            'price' => $price,
            'dimension'=>$dimension,
            'weight' => $weight,
            'height'=>$height,
            'width'=>$width,
            'length'=>$length,
            'description' => $description,
            'offered_price'=>$offered_price,
            'quantity' => $quantity,
            'offers'=>$offers,
            'specifications' => $specification
        ]);
        
        
        if ($files = $request->file('image')) {
            $del = DB::table('product_gallery')->where('product_id','=',$id)->delete();
            $destinationPath = public_path('../uploads/'); 
            foreach($files as $img) {      
                    $profileImage =$img->getClientOriginalName();
                    $img->move($destinationPath, $profileImage);
                $insertprd= DB::table('product_gallery')->insert(['product_image' => $profileImage,
                    'product_id'=>$id
                ]);
         }
        }
        else{
            
        }
        
        $color_id = (!empty($request->input('color_id'))) ? $request->input('color_id') : '';
        $size_id =  (!empty($request->input('size_id'))) ? $request->input('size_id'): '';
        
        $del = DB::table('product_color')->where('product_id','=',$id)->delete();
        foreach ($color_id as $key => $value) {
            $insertcr = DB::table('product_color')->insert(['color_id' => $value,
                'product_id'=>$id
            ]); 
        }
        
        $del1 = DB::table('product_size')->where('product_id','=',$id)->delete();
        foreach ($size_id as $key => $value) {
            $insertse = DB::table('product_size')->insert(['size_id' => $value,
                'product_id'=>$id
            ]); 
        }
        return redirect()->route('product')->with('success','Product has been updated successfully.');
    }
    
    public function delete_img($id)
    {
        $insert = DB::table('product_gallery')->where('id','=',$id)->delete();
        return redirect()->back()->with('success','Image has been deleted successfully.');  
    }
    
    public function changeprdstatus1($id){
        $insert = DB::table('product')->where('id','=',$id)->update([
            'status' => 1
        ]);
        return redirect()->back()->with('success','Status has been updated successfully.');
    }

    public function changeprdstatus2($id){
        $insert = DB::table('product')->where('id','=',$id)->update([
            'status' => 2
        ]);
        return redirect()->back()->with('success','Status has been updated successfully.');
    }
}
