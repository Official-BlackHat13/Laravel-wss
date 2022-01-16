@extends('layouts.header')
@section('content')
<div class="main-content">
   <div class="section__content section__content--p30">
      <div class="container-fluid">
         <div class="row">
            <div class="col-lg-12">
               <div class="card">
                  <div class="card-header">Edit Store Admin</div>
                  <form method="post" action="{{route('update-store-admin')}}"  enctype="multipart/form-data">
                     @csrf
                     <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                              <label>Name:</label>
                              <input type="hidden" name="id" value="{{$edituser->id}}">
                              <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Eg: Ashish" name="name" value="{{$edituser->name}}">
                            </div>
                            <div class="col-md-6">
                              <label>Email:</label>
                              <input type="text" class="form-control @error('email') is-invalid @enderror" placeholder="example@gmail.com" name="email" value="{{$edituser->email}}">
                           </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                              <label>Mobile:</label>
                              <input type="number" class="form-control @error('phone') is-invalid @enderror" placeholder="Eg: 9876543210" name="phone" value="{{$edituser->phone}}">
                            </div>
                            <div class="col-md-6">
                              <label>Age:</label>
                              <input type="text" class="form-control @error('age') is-invalid @enderror" placeholder="Eg: 29" name="age" value="{{$edituser->age}}">
                            </div>
                        </div>
                        <br>
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
                              <label>Country:</label>
                              <select class="form-control country-dropdown @error('country') is-invalid @enderror" name="country" id="" >
                                <option value="">Select Country</option>
                                @foreach($country as $countrys)
                                    <option value="{{$countrys->name}}" data-id="{{$countrys->id}}" <?php if($countrys->name==$edituser->country){echo 'selected';} ?>>{{$countrys->name}}</option>
                                @endforeach
                              </select>
                                
                           </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                               <label>State:</label>
                               <select id="" class="form-control state-dropdown @error('state') is-invalid @enderror" name="state">
                                   <option value="{{$edituser->state}}">{{$edituser->state}}</option>
                               </select>
                               
                           </div>
                           <div class="col-md-6">
                               <label>City:</label>
                                   <select id="" class="form-control city-dropdown @error('city') is-invalid @enderror" name="city">
                                       <option value="{{$edituser->city}}">{{$edituser->city}}</option>
                                   </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                              <label>Position:</label>
                              <input type="text" name="position" class="form-control @error('position') is-invalid @enderror" placeholder="Eg: Store Head" value="{{$edituser->position}}">
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