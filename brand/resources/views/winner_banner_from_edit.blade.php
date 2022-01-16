<?php $gst = 'https://bniindiastore.com/bmongers/uploads/' ?>
@extends('layouts.header')
@section('content')
<div class="main-content">
   <div class="section__content section__content--p30">
      <div class="container-fluid">
         <div class="row">
            <div class="col-lg-6">
               <div class="card">
                  <div class="card-header">Edit Winner Banner</div>
                  <form method="post" action="{{route('update-winner-banner')}}"  enctype="multipart/form-data">
                     @csrf
                     <div class="card-body">
                        <div class="row">
                           <div class="col-md-12">
                              <input type="hidden" class="form-control m-input" name="id" value="{{$editbanner->id}}">
                              
                           </div>
                        </div>
                        <div class="store_detail">
                            <div class="row">
                               <div class="col-md-12">
                                  <label>Store Id:</label>
                                  <select class="form-control" name="store_admin_id">
                                    @foreach($store as $stores)
                                        <option value="{{$stores->store_admin_id}}" <?php if($editbanner->store_admin_id==$stores->store_admin_id){echo 'selected';} ?>>{{$stores->store_admin_id}}</option>
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
                                <br>
                              <img src="{{$gst}}/{{ $editbanner->image }}" style="width:100px;height:60px;">
                           </div>
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