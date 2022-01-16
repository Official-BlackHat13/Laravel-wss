<?php $gst = str_replace('/public','',url('/uploads/')); ?>
@extends('layouts.header')
@section('content')
<div class="main-content">
   <div class="section__content section__content--p30">
      <div class="container-fluid">
         <div class="row">
            <div class="col-lg-12">
               <div class="card">
                  <div class="card-header">Edit Product</div>
                  <form method="post" action="{{route('update-product')}}"  enctype="multipart/form-data">
                     @csrf
                     <div class="card-body">
                        <div class="row">
                           <div class="col-md-6">
                              <label>Store Id:</label>
                              <select class="form-control" name="store_admin_id">
                                @foreach($store as $stores)
                                    <option value="{{$stores->store_admin_id}}" <?php if($edituser->store_admin_id == $stores->store_admin_id){echo 'selected';} ?>>{{$stores->store_admin_id}}</option>
                                @endforeach
                              </select>
                           </div>
                        
                           <div class="col-md-6">
                              <label>SKU:</label>
                              <input type="text" class="form-control @error('sku') is-invalid @enderror" name="sku" value="{{$edituser->brand_sku}}">
                              @error('sku')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                           </div>
                        </div>
                        <br>
                        <div class="row">
                           <div class="col-md-6">
                              <label>Super Category:</label>
                              <select class="form-control" name="super_category_id">
                                @foreach($supcat as $supcats)
                                    <option value="{{$supcats->id}}" <?php if($edituser->super_category_id == $supcats->id){echo 'selected';} ?>>{{$supcats->name}}</option>
                                @endforeach
                              </select>
                           </div>
                        
                           <div class="col-md-6">
                              <label>Category:</label>
                               <select class="form-control" name="category_id">
                                @foreach($cat as $cats)
                                    <option value="{{$cats->id}}" <?php if($edituser->category_id == $cats->id){echo 'selected';} ?>>{{$cats->name}}</option>
                                @endforeach
                              </select>
                           </div>
                        </div>
                        <br>
                        <div class="row">
                           <div class="col-md-6">
                              <label>Sub Category:</label>
                              <select class="form-control" name="subcategory_id">
                                @foreach($subcat as $subcats)
                                    <option value="{{$subcats->id}}" <?php if($edituser->subcategory_id == $subcats->id){echo 'selected';} ?>>{{$subcats->name}}</option>
                                @endforeach
                              </select>
                           </div>
                           <div class="col-md-6">
                              <label>Product Name:</label>
                               <input type="text" class="form-control @error('product_name') is-invalid @enderror" name="product_name" value="{{$edituser->product_name}}"> 
                               @error('product_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                           </div>
                        </div>
                        <br>
                        <div class="row">
                           <div class="col-md-6">
                              <label>Search Keyword:</label>
                              <input type="text" class="form-control @error('search_keywords') is-invalid @enderror" name="search_keywords" value="{{$edituser->search_keywords}}"> 
                            @error('search_keywords')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                           </div>
                           <div class="col-md-6">
                              <label>Price:</label>
                               <input type="number" class="form-control @error('price') is-invalid @enderror" name="price" value="{{$edituser->price}}"> 
                                @error('price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                           </div>
                        </div>
                        <br>
                        <div class="row">
                            <?php if($company_detail->dimension=='Yes'){ ?>
                           <div class="col-md-6">
                              <label>Dimension:</label>
                              <input type="text" class="form-control " name="dimension" value="{{$edituser->dimension}}"> 
                           </div>
                           <?php } ?>
                           <?php if($company_detail->weight=='Yes'){ ?>
                           <div class="col-md-6">
                              <label>Weight:</label>
                               <input type="text" class="form-control " name="weight" value="{{$edituser->weight}}">
                           </div>
                           <?php } ?>
                        </div>
                        <br>
                        <div class="row">
                            <?php if($company_detail->height=='Yes'){ ?>
                           <div class="col-md-6">
                              <label>Height:</label>
                              <input type="text" class="form-control " name="height" value="{{$edituser->height}}">
                           </div>
                           <?php } ?>
                           <?php if($company_detail->width=='Yes'){ ?>
                           <div class="col-md-6">
                              <label>Width:</label>
                               <input type="text" class="form-control " name="width" value="{{$edituser->width}}"> 
                           </div>
                           <?php } ?>
                        </div>
                        <br>
                        <div class="row">
                            <?php if($company_detail->length=='Yes'){ ?>
                           <div class="col-md-6">
                              <label>length:</label>
                              <input type="text" class="form-control " name="length" value="{{$edituser->length}}"> 
                           </div>
                           <?php } ?>
                           <div class="col-md-6">
                              <label>Offered Price:</label>
                               <input type="text" class="form-control " name="offered_price" value="{{$edituser->offered_price}}"> 
                           </div>
                        </div>
                        <br>
                        <div class="row">
                           <div class="col-md-6">
                              <label>Quantity:</label>
                              <input type="text" class="form-control @error('quantity') is-invalid @enderror" name="quantity" value="{{$edituser->quantity}}"> 
                            @error('quantity')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                           </div>
                           <div class="col-md-6">
                              <label>Offers:</label>
                               <input type="number" class="form-control" name="offers" value="{{$edituser->offers}}"> 
                           </div>
                        </div>
                        <br>
                        <div class="row">
                           <div class="col-md-12">
                              <label>Specification:</label>
                              <textarea type="text" class="form-control @error('specification') is-invalid @enderror" name="specification">{{$edituser->specifications}}</textarea>
                            @error('specification')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                           </div>
                        </div>
                        <br>
                        <div class="row">
                           <div class="col-md-12">
                              <label>Description:</label>
                              <textarea type="text" class="form-control @error('product_description') is-invalid @enderror" name="product_description">{{$edituser->description}}</textarea>
                           @error('product_description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                           </div>
                        </div><br>
                        <div class="row">
                            <?php if($company_detail->color=='Yes'){ ?>
                           <div class="col-md-6">
                              <label>Color:</label>
                              <select class="form-control js-example-basic-multiple" name="color_id[]" multiple>
                                  <?php //print_r($product_color);exit; ?>
                                @foreach($product_color as $product_colors)             
                                    <option value="{{$product_colors->color_id}}" selected>{{$product_colors->Name}}</option>
                                @endforeach  
                                @foreach($color as $colors)
                                    <option value="{{$colors->id}}">{{$colors->Name}}</option>
                                @endforeach
                              </select>
                           </div>
                        <?php } ?>
                        <?php if($company_detail->size=='Yes'){ ?>
                           <div class="col-md-6">
                              <label>Size:</label>
                               <select class="form-control js-example-basic-multiple" name="size_id[]" multiple>
                                @foreach($product_size as $product_sizes)             
                                    <option value="{{$product_sizes->size_id}}" selected>{{$product_sizes->Size}}</option>
                                @endforeach  
                                @foreach($size as $sizes)
                                    <option value="{{$sizes->id}}">{{$sizes->Size}}</option>
                                @endforeach
                              </select>
                           </div>
                           <?php } ?>
                        </div><br>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Image/Images</label>
                                <input type="file" class="form-control  @error('image') is-invalid @enderror" id="upload_file" name="image[]" multiple/>
                                @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12" style="display:block">
                                @foreach($product_imgs as $product_img)
                                    <img src="{{$gst}}/{{ $product_img->product_image }}"  style="width:100px;height:80px;">
                                    <a href="{{url('delete-prd-img/'.$product_img->id)}}"><i class="fas fa-trash" style="margin-right: 30px;"></i></a>
                                @endforeach
                            </div>
                        </div>
                     </div>
                     <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fa fa-dot-circle-o"></i> Submit
                        </button>
                        <button type="reset" class="btn btn-danger btn-sm">
                        <i class="fa fa-ban"></i> Reset
                        </button>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@section('script')
    <script>
        // document.getElementById('upload_file').onchange = function() { 
        // alert();
        //  var total_file=document.getElementById("upload_file").files.length;
        //  for(var i=0;i<total_file;i++)
        //  {
        //   $('#image_preview').append("<img src='"+URL.createObjectURL(event.target.files[i])+"'><br>");
        //  }
        // }
    </script>
@endsection