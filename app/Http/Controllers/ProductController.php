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
        
        $users1 = DB::table('product')
                ->leftjoin('categories','categories.id','=','product.category_id')
                ->leftjoin('sub_categories','sub_categories.id','=','product.subcategory_id')
                ->leftjoin('super_categories','super_categories.id','categories.super_category_id')
                ->select('product.*','super_categories.name as supercatname','categories.name as catname','sub_categories.name as subcatname')
                ->orderBy('product.id','desc')->get();
        return view('productlist',['users1'=>$users1]);
    }
    
    public function create()
    {
        $supcat = DB::table('super_categories')->select('super_categories.*')->where('status','=',1)->get();
        $cat = DB::table('categories')->select('categories.*')->where('status','=',1)->get();
        $subcat = DB::table('sub_categories')->select('sub_categories.*')->where('status','=',1)->get();
        $company = DB::table('company_admin')->select('company_admin.company_id')->where('status','=',1)->get();
        $brand = DB::table('brand_admin')->select('brand_admin.brand_admin_id')->where('status','=',1)->get();
        $store = DB::table('store_admin')->select('store_admin.store_admin_id')->where('status','=',1)->get();
        $color = DB::table('color')->select('color.*')->where('status','=',1)->get();
        $size = DB::table('size')->select('size.*')->where('status','=',1)->get();
        $uid=auth::user()->id;
        $com_id= DB::table('company_admin')->select('company_admin.*')->where('id','=',$uid)->first();
        
        return view('add_product_form',['supcat'=>$supcat,'cat'=>$cat,'subcat'=>$subcat,'company'=>$company,'brand'=>$brand,'store'=>$store,'color'=>$color,'size'=>$size,'company_detail'=>$com_id]);
    }
    public function store(Request $request)
    {
        // print_r('hii');exit;
        $this->validate($request, [
            'product_name'=>'required',
            'sku'=>'required',
            'price'=>'required',
            'image' => 'required',
            'image.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            // 'quantity'=>'required',
            'product_description'=>'required'
        ]);
        $product_name = (!empty($request->input('product_name'))) ? $request->input('product_name') : '';
        $company_id = (!empty($request->input('company_id'))) ? $request->input('company_id') : '';
        $brand_admin_id = (!empty($request->input('brand_admin_id'))) ? $request->input('brand_admin_id') : '';
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
        
        if($files = $request->file('product_images'))
        {
            $photos=request()->file('product_images');
            
            $uploadcount = 0;
            
            foreach ($photos as $photo)
            {
                $destinationPath = public_path('../uploads/');
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
        
        $company = DB::table('company_admin')->select('company_admin.company_id')->where('status','=',1)->get();            
        $supcat = DB::table('super_categories')->select('super_categories.*')->where('status','=',1)->get();
        $cat = DB::table('categories')->select('categories.*')->where('status','=',1)->get();
        $subcat = DB::table('sub_categories')->select('sub_categories.*')->where('status','=',1)->get();
        $brand = DB::table('brand_admin')->select('brand_admin.brand_admin_id')->where('status','=',1)->get();
        $store = DB::table('store_admin')->select('store_admin.store_admin_id')->where('status','=',1)->get();
        $color = DB::table('color')->select('color.*')->where('status','=',1)->get();
        $size = DB::table('size')->select('size.*')->where('status','=',1)->get();
        
        // $product_color = DB::table('product_color')->leftjoin('color','color.id','=','product_color.color_id')
        //                 ->select('product_color.color_id','color.Name')
        //                 ->where('product_id','=',$id)->get();
                        
        // $product_size = DB::table('product_size')
        //                 ->leftjoin('size','size.id','=','product_size.size_id')
        //                 ->select('product_size.size_id','size.Size')
        //                 ->where('product_id','=',$id)->get();
                        
        // $product_imgs = DB::table('product_gallery')
        //                 ->select('id','product_gallery.product_image')
        //                 ->where('product_id','=',$id)->get(); 
                        
        $uid=auth::user()->id;
        $com_id= DB::table('company_admin')->select('company_admin.*')->where('id','=',$uid)->first();
        
        return view('product_form_edit',['edituser'=>$edituser,'supcat'=>$supcat,'cat'=>$cat,'subcat'=>$subcat,'company'=>$company,'brand'=>$brand,'store'=>$store,'color'=>$color,'size'=>$size,'company_detail'=>$com_id]);
    }
    
    public function update(Request $request)
    {
        $id = (!empty($request->input('id'))) ? $request->input('id') : '';
        $product_name = (!empty($request->input('product_name'))) ? $request->input('product_name') : '';
        $company_id = (!empty($request->input('company_id'))) ? $request->input('company_id') : '';
        $brand_admin_id = (!empty($request->input('brand_admin_id'))) ? $request->input('brand_admin_id') : '';
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
        
        $color_id = (!empty($request->input('color_id'))) ? $request->input('color_id') : '';
        $size_id =  (!empty($request->input('size_id'))) ? $request->input('size_id'): '';
        
        if(!empty($color_id)){
            $color=implode(',', $color_id);
        }else{
            $color='';
        }
        if(!empty($size_id)){
            $size=implode(',', $size_id);
        }else{
            $size='';
        }
        
        $selctdt = DB::table('product')
                        ->select('images')
                        ->where('id','=',$id)->first();
                       
        // print_r($selctdt->images);exit;                
        if($files = $request->file('product_images'))
        {
            $photos=request()->file('product_images');
            $uploadcount = 0;
            foreach ($photos as $photo)
            {
                $destinationPath = public_path('../uploads/');
                $filename =  $photo->getClientOriginalName();
                $photo->move($destinationPath,$filename);
                $uploadcount ++;
                $data[] = $filename;
            }
            $filename=json_encode($data);
        }else{         
            $filename =(!empty($selctdt->images))? $selctdt->images :'';               
        }
        // print_r($filename);exit; 
        
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
            'specifications' => $specification,
            'images'=>$filename,
            'product_color'=>$color,
            'product_size'=>$size
        ]);
        
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
