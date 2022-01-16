@extends('layouts.header')
@section('content')
<style>
    .gallery img{
        width:200px;
        margin-right:10px;
    }
</style>
<div class="main-content">
   <div class="section__content section__content--p30">
      <div class="container-fluid">
         <div class="row">
            <div class="col-lg-12">
               <div class="card">
                  <div class="card-header">Add Product</div>
                  <form method="post" action="{{route('postdtprd')}}"  accept-charset="utf-8" enctype="multipart/form-data">
                     @csrf
                     <div class="card-body">
                        
                        <div class="row">
                           <div class="col-md-6">
                              <label>Store Id:</label>
                              <select class="form-control" name="store_admin_id">
                                @foreach($store as $stores)
                                    <option value="{{$stores->store_admin_id}}" {{old ('store_admin_id') == $stores->store_admin_id ? 'selected' : ''}}>{{$stores->store_admin_id}}</option>
                                @endforeach
                              </select>
                           </div>
                        
                           <div class="col-md-6">
                              <label>SKU:</label>
                              <input type="text" class="form-control @error('sku') is-invalid @enderror" name="sku" value="<?php echo $startdate = (!empty(old('sku')))? old('sku') : ' ' ?>">
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
                                    <option value="{{$supcats->id}}" {{old ('super_category_id') == $supcats->id ? 'selected' : ''}}>{{$supcats->name}}</option>
                                @endforeach
                              </select>
                           </div>
                        
                           <div class="col-md-6">
                              <label>Category:</label>
                               <select class="form-control" name="category_id">
                                @foreach($cat as $cats)
                                    <option value="{{$cats->id}}" {{old ('category_id') == $cats->id ? 'selected' : ''}}>{{$cats->name}}</option>
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
                                    <option value="{{$subcats->id}}" {{old ('subcategory_id') == $subcats->id ? 'selected' : ''}}>{{$subcats->name}}</option>
                                @endforeach
                              </select>
                           </div>
                           <div class="col-md-6">
                              <label>Product Name:</label>
                               <input type="text" class="form-control @error('product_name') is-invalid @enderror" name="product_name" value="<?php echo $startdate = (!empty(old('product_name')))? old('product_name') : ' ' ?>"> 
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
                              <label>Price:</label>
                               <input type="number" class="form-control @error('price') is-invalid @enderror" name="price" value="<?php echo $startdate = (!empty(old('price')))? old('price') : ' ' ?>"> 
                                @error('price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                           </div>
                           <div class="col-md-6">
                              <label>Offers:</label>
                               <input type="number" class="form-control" name="offers" value="<?php echo $startdate = (!empty(old('offers')))? old('offers') : ' ' ?>"> 
                           </div>
                           <!--<div class="col-md-6">-->
                           <!--   <label>Quantity:</label>-->
                           <!--   <input type="number" class="form-control @error('quantity') is-invalid @enderror" name="quantity" value="<?php echo $startdate = (!empty(old('quantity')))? old('quantity') : ' ' ?>"> -->
                           <!-- @error('quantity')-->
                           <!--     <span class="invalid-feedback" role="alert">-->
                           <!--         <strong>{{ $message }}</strong>-->
                           <!--     </span>-->
                           <!--     @enderror-->
                           <!--</div>-->
                        </div>
                        <br>
                        <div class="row">
                           
                        </div>
                        <br>
                        <div class="row">
                           <div class="col-md-12">
                              <label>Description:</label>
                              <textarea type="text" class="form-control @error('product_description') is-invalid @enderror" name="product_description"><?php echo $startdate = (!empty(old('product_description')))? old('product_description') : ' ' ?></textarea>
                           @error('product_description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                           </div>
                        </div><br>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Image/Images</label>
                                <input type="file" class="form-control  @error('image') is-invalid @enderror" id="gallery-photo-add" name="image[]" multiple/>
                                @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div><br>
                            <span class="row col-md-12" style="color:red;margin-left:15px;">Upload Size:- 5MB (Upto 5 Images)</span><br>
                            <span class="row col-md-12" style="color:red;margin-left:15px;">Image Format:- jpeg,jpg,png allowed</span><br>
                            <span class="row col-md-12" style="color:red;margin-left:15px;">Image Size:-  590 W* 1080 H (PX)</span>
                        </div>
                        <br>
                        <div class="row gallery"></div><br>
                        <div class="row">
                           <div class="col-md-6">
                              <label>Shape:</label>
                              <?php 
                              $data=DB::table('specifications')->select('specifications.value')->where('name','=','Shape')->first();
                              $data1=explode(',',$data->value);
                              ?>
                              <select class="form-control" name="shape">
                                <option value="">Select Any One</option>
                                @foreach($data1 as $dt)
                                    <option value="{{$dt}}" {{old ('shape') == $dt ? 'selected' : ''}}>{{$dt}}</option>
                                @endforeach
                              </select>    
                           </div>
                           <div class="col-md-6">
                              <label>Lens Type:</label>
                               <?php 
                              $data=DB::table('specifications')->select('specifications.value')->where('name','=','Lens Type')->first();
                              $data1=explode(',',$data->value);
                              ?>
                              <select class="form-control" name="type">
                                <option value="">Select Any One</option>
                                @foreach($data1 as $dt)
                                    <option value="{{$dt}}" {{old ('type') == $dt ? 'selected' : ''}}>{{$dt}}</option>
                                @endforeach
                              </select> 
                           </div>
                        </div>
                        <br>
                        <div class="row">
                           <div class="col-md-6">
                              <label>Frame Material:</label>
                              <?php 
                              $data=DB::table('specifications')->select('specifications.value')->where('name','=','Frame Material')->first();
                              $data1=explode(',',$data->value);
                              ?>
                              <select class="form-control" name="frame_material">
                                <option value="">Select Any One</option>
                                @foreach($data1 as $dt)
                                    <option value="{{$dt}}" {{old ('frame_material') == $dt ? 'selected' : ''}}>{{$dt}}</option>
                                @endforeach
                              </select> 
                           </div>
                           <div class="col-md-6">
                              <label>Frame Fit:</label>
                               <?php 
                              $data=DB::table('specifications')->select('specifications.value')->where('name','=','Frame Fit')->first();
                              $data1=explode(',',$data->value);
                              ?>
                              <select class="form-control" name="frame_fit">
                                <option value="">Select Any One</option>
                                @foreach($data1 as $dt)
                                    <option value="{{$dt}}" {{old ('frame_fit') == $dt ? 'selected' : ''}}>{{$dt}}</option>
                                @endforeach
                              </select>  
                           </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                              <label>Made In:</label>
                               <input type="text" class="form-control" name="made_in" value="<?php echo $startdate = (!empty(old('made_in')))? old('made_in') : ' ' ?>"> 
                           </div>
                        </div>
                        <br>
                        <div class="row">
                           <div class="col-md-6">
                              <label>Color:</label>
                              <select class="form-control js-example-basic-multiple" name="color_id[]" multiple>
                                @foreach($color as $colors)
                                    <option value="{{$colors->id}}">{{$colors->Name}}</option>
                                @endforeach
                              </select>
                           </div>
                           <div class="col-md-6">
                              <label>Size:</label>
                               <select class="form-control js-example-basic-multiple" name="size_id[]" multiple>
                                @foreach($size as $sizes)
                                    <option value="{{$sizes->id}}">{{$sizes->Size}}</option>
                                @endforeach
                              </select>
                           </div>
                        </div><br>
                        
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
@endsection('content')
@section('script')
    <script>
        $(function() {
            // Multiple images preview in browser
            var imagesPreview = function(input, placeToInsertImagePreview) {
                if (input.files) {
                    var filesAmount = input.files.length;
                    for (i = 0; i < filesAmount; i++) {
                        var reader = new FileReader();
                        reader.onload = function(event) {
                            $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                        }
                        reader.readAsDataURL(input.files[i]);
                    }
                }
            };
            $('#gallery-photo-add').on('change', function() {
                imagesPreview(this, 'div.gallery');
            });
        });
    </script>
@endsection