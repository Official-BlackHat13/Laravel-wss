<?php $gst = str_replace('/public','',url('/uploads/')); ?>
@extends('layouts.header')
@section('content')
<div class="main-content">
   <div class="section__content section__content--p30">
      <div class="container-fluid">
         <div class="row">
            <div class="col-lg-6">
               <div class="card">
                  <div class="card-header">Edit Location</div>
                  <form method="post" action="{{route('update-location')}}"  enctype="multipart/form-data">
                     @csrf
                     <div class="card-body">
                        <div class="row">
                           <div class="col-md-12">
                              <label>State:</label>
                              <input type="hidden" name="id" value="{{$loc->id}}">
                              <select type="text" class="form-control state-dropdown @error('state') is-invalid @enderror" name="state">
                                @foreach($state as $states)
                                    <option value="{{$states->name}}" <?php if($states->name==$loc->state){echo 'selected';} ?> data-id="{{$states->id}}">{{$states->name}}</option>
                                @endforeach
                              </select>
                                @error('state')
                                  <span class="invalid-feedback" role="alert">
                                       <strong>{{ $message }}</strong>
                                  </span>
                                @enderror
                           </div>
                        </div>
                        <br>
                        <div class="row">
                           <div class="col-md-12">
                                <label>City:</label>
                                <input type="text" name="city" class="form-control" value="{{$loc->city}}">
                           </div>
                        </div>
                        <br>
                        <div class="row">
                           <div class="col-md-12">
                              <label>Icon:</label>
                              <input type="file" class="form-control" name="image" >
                              <br>
                              <img src="{{$gst}}/{{ $loc->image }}" style="width:100px;height:60px;">
                                
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
$('.state-dropdown').on('change', function() {
var state_id = $(this).find(':selected').data('id');
// alert(state_id);
$(".city-dropdown").html('');
$.ajax({
url:"{{url('get-cities-by-state1')}}",
type: "POST",
data: {
state_id: state_id,
_token: '{{csrf_token()}}' 
},
dataType : 'json',
success: function(result){
$('.city-dropdown').html('<option value="">Select City</option>'); 
$.each(result.cities,function(key,value){
$(".city-dropdown").append('<option value="'+value.name+'" >'+value.name+'</option>');
});
}
});
});
});
</script>
@endsection