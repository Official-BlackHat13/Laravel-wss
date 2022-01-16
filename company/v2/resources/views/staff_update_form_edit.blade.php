<?php $gst = 'https://bniindiastore.com/bmongers/uploads/' ?>
@extends('layouts.header')
@section('content')
<div class="main-content">
   <div class="section__content section__content--p30">
      <div class="container-fluid">
         <div class="row">
            <div class="col-lg-12">
               <div class="card">
                  <div class="card-header">Edit Staff Update Form</div>
                  <form method="post" action="{{route('update-staff')}}"  enctype="multipart/form-data">
                     @csrf
                     <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                              <label>City:</label>
                              <input type="hidden" name="id" value="{{$edituser->id}}">
                              <select class="form-control" name="city">
                                @foreach($city as $cts)
                                    <option value="{{$cts->city}}" <?php if($edituser->city==$cts->city){echo 'selected';} ?>>{{$cts->city}}</option>
                                @endforeach
                              </select>
                           </div>
                        
                           <div class="col-md-6">
                              <label>Store:</label>
                              <select class="form-control" name="store_id">
                                @foreach($store as $stores)
                                    <option value="{{$stores->store_admin_id}}" <?php if($edituser->store_admin_id==$stores->store_admin_id){echo 'selected';} ?>>{{$stores->store_admin_id}}</option>
                                @endforeach
                              </select>
                           </div>
                        </div><br>
                        
                        <div class="row">
                            <div class="col-md-6">
                              <label>Gender:</label>
                              <select class="form-control" name="gender">
                                 <option value="M" <?php if($edituser->gender=='M'){echo 'selected';} ?>>Male</option>
                                 <option value="F" <?php if($edituser->gender=='F'){echo 'selected';} ?>>Female</option>
                                 <option value="O" <?php if($edituser->gender=='O'){echo 'selected';} ?>>Other</option>
                              </select>
                           </div>
                           <div class="col-md-6">
                              <label>Company:</label>
                              <select class="form-control" name="company_id">
                                @foreach($company as $coun)
                                    <option value="{{$coun->company_id}}" <?php if($edituser->company_id==$coun->company_id){echo 'selected';} ?>>{{$coun->company_id}}</option>
                                @endforeach
                              </select>
                           </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                 <label>Age</label>
                                 <input type="text" placeholder="Enter Age" class="form-control" name="age" value="{{$edituser->age}}">
                             </div>
                             <div class="col-md-6">
                                 <label>Category</label>
                                 <select class="form-control" name="main_category">
                                    @foreach($category as $cts)
                                        <option value="{{$cts->name}}" <?php if($edituser->category==$cts->name){echo 'selected';} ?>>{{$cts->name}}</option>
                                    @endforeach
                                  </select>
                             </div>
                        </div><br>
                        
                        <div class="row">
                             <div class="col-md-6">
                                 <label>Video Name</label>
                                 <input type="text" placeholder="Enter Video Name" class="form-control" name="video_name" value="{{$edituser->video_name}}">
                             </div>
                             <div class="col-md-6">
                                 <label>Purpose</label>
                                 <input type="text" placeholder="Enter Purpose" class="form-control" name="purpose" value="{{$edituser->purpose}}">
                             </div>
                        </div><br>
                        <div class="row">
                             <div class="col-md-6">
                                 <label>Url</label>
                                 <input type="text" placeholder="Enter Url" class="form-control" name="url" value="{{$edituser->url}}">
                             </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                              <label>Start Date:</label>
                              <input type="date" class="form-control" name="start_date" value="{{$edituser->start_date}}">
                           </div> 
                           <div class="col-md-6">
                              <label>End Date:</label>
                              <input type="date" class="form-control" name="end_date" value="{{$edituser->end_date}}">
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
$(document).ready(function() {
$('.country-dropdown').on('change', function() {
var country_id = $(this).find(':selected').data('id');
// alert(country_id);
$(".state-dropdown").html('');
$.ajax({
url:"{{url('get-states-by-country')}}",
type: "POST",
data: {
country_id: country_id,
_token: '{{csrf_token()}}' 
},
dataType : 'json',
success: function(result){
$('.state-dropdown').html('<option value="" >Select State</option>'); 
$.each(result.states,function(key,value){
$(".state-dropdown").append('<option value="'+value.name+'" data-id="'+value.id+'">'+value.name+'</option>');
});
$('.city-dropdown').html('<option value="">Select State First</option>'); 
}
});
});    
$('.state-dropdown').on('change', function() {
var state_id = $(this).find(':selected').data('id');
// alert(state_id);
$(".city-dropdown").html('');
$.ajax({
url:"{{url('get-cities-by-state')}}",
type: "POST",
data: {
state_id: state_id,
_token: '{{csrf_token()}}' 
},
dataType : 'json',
success: function(result){
$('.city-dropdown').html('<option value="">Select City</option>'); 
$.each(result.cities,function(key,value){
$(".city-dropdown").append('<option value="'+value.name+'">'+value.name+'</option>');
});
}
});
});
});
</script>
@endsection