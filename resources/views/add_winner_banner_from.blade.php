@extends('layouts.header')
@section('content')
<div class="main-content">
   <div class="section__content section__content--p30">
      <div class="container-fluid">
         <div class="row">
            <div class="col-lg-6">
               <div class="card">
                  <div class="card-header">Add Winner Banner</div>
                  <form method="post" action="{{route('postdtwb')}}"  enctype="multipart/form-data">
                     @csrf
                     <div class="card-body">
                        <div class="row">
                           <div class="col-md-12">
                              <label>For:</label>
                              <select class="form-control" name="type" id="user_type">
                                    <option value="1" {{old ('type') == '1' ? 'selected' : ''}}>User</option>
                                    <option value="2" {{old ('type') == '2' ? 'selected' : ''}}>Store</option>
                              </select>
                           </div>
                        </div>
                        <div class="store_detail" <?php  if(old ('type') == '2'){ ?> style="display:block;" <?php }else{ ?> style="display:none;" <?php } ?>>
                            <br>
                            <div class="row">
                               <div class="col-md-12">
                                  <label>Company Id:</label>
                                  <select class="form-control" name="company_id">
                                        @foreach($company as $companys)
                                            <option value="{{$companys->company_id}}" {{old ('company_id') == $companys->company_id ? 'selected' : ''}}>{{$companys->company_id}}</option>
                                        @endforeach
                                  </select>
                               </div>
                            </div>
                            <br>
                            <div class="row">
                               <div class="col-md-12">
                                  <label>Brand Id:</label>
                                   <select class="form-control" name="brand_admin_id">
                                    @foreach($brand as $brands)
                                        <option value="{{$brands->brand_admin_id}}" {{old ('brand_admin_id') == $brands->brand_admin_id ? 'selected' : ''}}>{{$brands->brand_admin_id}}</option>
                                    @endforeach
                                  </select>
                               </div>
                            </div>
                            <br>
                            <div class="row">
                               <div class="col-md-12">
                                  <label>Store Id:</label>
                                  <select class="form-control" name="store_admin_id">
                                    @foreach($store as $stores)
                                        <option value="{{$stores->store_admin_id}}" {{old ('store_admin_id') == $stores->store_admin_id ? 'selected' : ''}}>{{$stores->store_admin_id}}</option>
                                    @endforeach
                                  </select>
                               </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                           <div class="col-md-12">
                              <label>image:</label>
                              <input type="file" class="form-control @error('image') is-invalid @enderror" name="image">
                                @error('image')
                                  <span class="invalid-feedback" role="alert">
                                       <strong>{{ $message }}</strong>
                                  </span>
                                @enderror
                           </div>
                           <br>
                            <span class="row col-md-12" style="color:red;margin-left:0px;">Upload Size:- Less then 2MB </span><br>
                            <span class="row col-md-12" style="color:red;margin-left:0px;">Image Format:- jpeg,jpg,png allowed</span><br>
                            <span class="row col-md-12" style="color:red;margin-left:0px;">Image Size:-  590 W* 1080 H (PX)</span>
                        </div>
                        <br>
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
$(document).ready(function() {
    $('#user_type').on('change', function() {
        var curr = this.value;
        if(curr==2){
            $(".store_detail").css('display','block');
        }else{
            $(".store_detail").css('display','none');
        }
    });
});
</script>
@endsection
