@extends('layouts.header')
@section('content')
<div class="main-content">
   <div class="section__content section__content--p30">
      <div class="container-fluid">
         <div class="row">
            <div class="col-lg-12">
               <div class="card">
                  <div class="card-header">Edit Brand Admin</div>
                  <form method="post" action="{{route('update-brand-admin')}}"  enctype="multipart/form-data">
                     @csrf
                     <div class="card-body">
                        <div class="row">
                           <div class="col-md-6">
                              <label>Name:</label>
                              <input type="hidden" class="form-control m-input" name="id" value="{{$edituser->id}}">
                              <input type="text" class="form-control @error('name') is-invalid @enderror"name="name" value="{{$edituser->name}}">
                           </div>
                           <div class="col-md-6">
                               <label>Country:</label>
                              <select class="form-control country-dropdown @error('country') is-invalid @enderror" name="country">
                                <option value="">Select Country</option>
                                @foreach($country as $countrys)
                                    <option value="{{$countrys->name}}" data-id="{{$countrys->id}}" <?php if($countrys->name==$edituser->country){echo 'selected';} ?>>{{$countrys->name}}</option>
                                @endforeach
                              </select>
                                @error('country')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                           </div>
                        </div>
                        <br>
                        <div class="row">
                           <div class="col-md-6">
                               <label>State:</label>
                               <select class="form-control state-dropdown @error('state') is-invalid @enderror" name="state">
                                   <option value="{{$edituser->state}}">{{$edituser->state}}</option>
                               </select>
                               
                           </div>
                           <div class="col-md-6">
                              <label>City:</label>
                              <select class="form-control city-dropdown @error('city') is-invalid @enderror" name="city">
                                  <option value="{{$edituser->city}}">{{$edituser->city}}</option>
                              </select>      
                           </div>
                        </div><br>
                        <div class="row">
                            <div class="col-md-6">
                              <label>Pincode Managed:</label>
                             <select class="form-control js-example-basic-multiple @error('pincode') is-invalid @enderror" name="pincode[]" multiple>
                                @foreach($dis_explodes as $dis)             
                                    <option value="{{$dis}}" selected>{{$dis}}</option>
                                @endforeach
                                @foreach($pin as $pins)
                                    <option value="{{$pins->pincode}}">{{$pins->pincode}}</option>
                                @endforeach
                              </select>
                              
                           </div>
                           <div class="col-md-6">
                               <label>Brand Logo:</label>
                               <input type="file" class="form-control @error('image') is-invalid @enderror" name="image">
                            <span class="row col-md-12" style="color:red;">Upload Size:- Less Then 1MB </span>
                            <span class="row col-md-12" style="color:red;">Image Format:- jpeg,jpg,png allowed</span>
                           </div>
                        </div>
                        <br>
                        <h4>Brand Admin Details</h4><br>
                        <div class="row"> 
                            <div class="col-md-6">
                              <label>Email:</label>
                              <input type="text" class="form-control @error('email') is-invalid @enderror" placeholder="example@gmail.com" name="email" value="{{$edituser->email}}">
                              
                           </div>
                           <div class="col-md-6">
                              <label>Mobile:</label>
                              <input type="number" class="form-control @error('phone') is-invalid @enderror" placeholder="9876543210" name="phone" value="{{$edituser->phone}}">
                              
                           </div>
                        </div><br>
                        <div class="row">
                           <div class="col-md-6">
                              <label>Age:</label>
                              <input type="text" class="form-control @error('age') is-invalid @enderror" placeholder="Eg:29" name="age" value="{{$edituser->age}}">
                             
                           </div>
                           <div class="col-md-6">
                               <label>Gender:</label>
                              <select class="form-control" name="gender">
                                    <option value="M" <?php if($edituser->gender == 'M'){echo 'selected';} ?>>Male</option>
                                    <option value="F" <?php if($edituser->gender == 'F'){echo 'selected';} ?>>Female</option>
                                    <option value="O" <?php if($edituser->gender == 'O'){echo 'selected';} ?>>Other</option>
                              </select>
                           </div>
                        </div>
                        <br>
                        <div class="row">
                           <div class="col-md-6">
                              <label>Position:</label>
                              <input type="text" name="position" class="form-control @error('position') is-invalid @enderror" placeholder="Brand Head" value="{{$edituser->position}}">
                            </div>
                            <div class="col-md-6">
                              <label>Role:</label><br>
                               <?php $data= explode(',',$edituser->role);?>
                              <input type="checkbox" name="role[]" class="@error('role') is-invalid @enderror" value="1" <?php if(in_array("1", $data)){echo 'checked';} ?>> Handle Inventory <br>
                              <input type="checkbox" name="role[]" class="@error('role') is-invalid @enderror" value="2" <?php if(in_array("2", $data)){echo 'checked';} ?>> Staff Updates <br>
                              <input type="checkbox" name="role[]" class="@error('role') is-invalid @enderror" value="3" <?php if(in_array("3", $data)){echo 'checked';} ?>> Store <br>
                              <input type="checkbox" name="role[]" class="@error('role') is-invalid @enderror" value="4" <?php if(in_array("4", $data)){echo 'checked';} ?>> Commercials  <br>
                              <input type="checkbox" name="role[]" class="@error('role') is-invalid @enderror" value="5" <?php if(in_array("5", $data)){echo 'checked';} ?>> Coupon/Voucher  <br>
                              <input type="checkbox" name="role[]" class="@error('role') is-invalid @enderror" value="6" <?php if(in_array("6", $data)){echo 'checked';} ?>> Live Stream <br>
                              <input type="checkbox" name="role[]" class="@error('role') is-invalid @enderror" value="7" <?php if(in_array("7", $data)){echo 'checked';} ?>> Training & Awards 
                            </div>
                        </div>
                        <div id="room_fileds"></div><br>
                        <!--<div class="btn btn-primary" id="brandadd"  onclick="add_fields();"> Add More Brand</div>-->
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
var branchfield = 1;
    function add_fields(){
        branchfield++;
       var objTo = document.getElementById('room_fileds')
       var divtest = document.createElement("div");
       divtest.innerHTML = '<div style="margin-top:15px"><h4 style="margin-left:1px;margin-top:15px">Brand ' + branchfield + ' :</h4><br> <div class="row"><div class="col-md-6"><label>Name:</label><input type="text" class="form-control" placeholder="Pepsi" name="name[]"></div><div class="col-md-6"><label>Email:</label><input type="email" placeholder="example@gmail.com" class="form-control" name="email[]"></div></div><br><div class="row"><div class="col-md-6"><label>Mobile:</label><input type="number" placeholder="9876543210" class="form-control" name="phone[]"></div><div class="col-md-6"><label>Age:</label><input type="text" class="form-control" placeholder="29" name="age[]"></div></div><br><div class="row"><div class="col-md-6"><label>Gender:</label><select class="form-control" name="gender[]"><option value="M">Male</option><option value="F">Female</option></select></div><div class="col-md-6"><label>Country:</label><select class="form-control country-dropdown" name="country[]"><option value="">Select Country</option>@foreach($country as $countrys)<option value="{{$countrys->id}}">{{$countrys->name}}</option>@endforeach</select></div></div><br><div class="row"><div class="col-md-6"><label>State:</label><select  class="form-control state-dropdown" name="state[]"></select></div><div class="col-md-6"><label>City:</label><select class="form-control city-dropdown " name="city[]"></select></div></div><br><div class="row"><div class="col-md-6"><label>Pincode Managed:</label><select class="form-control js-example-basic-multiple" name="pincode[]" multiple>@foreach($pin as $pins)<option value="{{$pins->pincode}}">{{$pins->pincode}}</option>@endforeach</select></div><div class="col-md-6"><label>Position:</label><input type="text" name="position[]" placeholder="Brand Head" class="form-control"></div></div><br><div class="row"><div class="col-md-6"><label>Password:</label><input type="password" name="password[]" placeholder="Enter Password" class="form-control"></div><div class="col-md-6"><label>Role:</label><br><input type="checkbox" name="role[]"  value="1"> Handle Inventory <br><input type="checkbox" name="role[]"  value="2"> Handle Store Interaction <br><input type="checkbox" name="role[]"  value="3"> Create Store </div></div></div>';
   	objTo.appendChild(divtest)						
    } 
    
        
</script>
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
$('.state-dropdown').html('<option value="">Select State</option>'); 
$.each(result.states,function(key,value){
$(".state-dropdown").append('<option value="'+value.name+'" data-id="'+value.id+'">'+value.name+'</option>');
});
$('.city-dropdown').html('<option value="">Select State First</option>'); 
}
});
});    
$('.state-dropdown').on('change', function() {
var state_id = $(this).find(':selected').data('id');
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