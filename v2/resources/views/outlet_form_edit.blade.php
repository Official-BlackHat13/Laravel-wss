@extends('layouts.header')
@section('content')
<div class="main-content">
   <div class="section__content section__content--p30">
      <div class="container-fluid">
         <div class="row">
            <div class="col-lg-12">
               <div class="card">
                  <div class="card-header">Edit Outlet Form</div>
                  <form method="post" action="{{route('update-outlet')}}"  enctype="multipart/form-data">
                     @csrf
                     <div class="card-body">
                        <div class="row">
                           <div class="col-md-6">
                              <label>Company:</label>
                              <input type="hidden" name="id" value="{{$edituser->id}}">
                              <select class="form-control" name="company_id">
                                @foreach($company as $coun)
                                    <option value="{{$coun->company_id}}" <?php if($edituser->company_id==$coun->company_id){echo 'selected';} ?>>{{$coun->company_id}}</option>
                                @endforeach
                              </select>
                           </div>
                           <div class="col-md-6">
                              <label>Brand:</label>
                              <select class="form-control" name="brand_admin_id">
                                @foreach($brand as $brands)
                                    <option value="{{$brands->brand_admin_id}}" <?php if($edituser->brand_admin_id==$brands->brand_admin_id){echo 'selected';} ?>>{{$brands->brand_admin_id}}</option>
                                @endforeach
                              </select>
                           </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                              <label>Country:</label>
                              <select class="form-control country-dropdown @error('country') is-invalid @enderror" name="country" id="" >
                                <option value="">Select Country</option>
                                @foreach($country as $countrys)
                                    <option value="{{$countrys->name}}" data-id="{{$countrys->id}}" <?php if($countrys->name==$edituser->country){echo 'selected';} ?>>{{$countrys->name}}</option>
                                @endforeach
                              </select>
                               
                           </div>
                           <div class="col-md-6">
                               <label>State:</label>
                               <select id="" class="form-control state-dropdown @error('state') is-invalid @enderror" name="state">
                                   <option value="{{$edituser->state}}">{{$edituser->state}}</option>
                               </select>
                               
                           </div>
                        </div>
                        <br>
                        <div class="row">
                           <div class="col-md-6">
                               <label>City:</label>
                                   <select id="" class="form-control city-dropdown @error('city') is-invalid @enderror" name="city">
                                       <option value="{{$edituser->city}}">{{$edituser->city}}</option>
                                   </select>
                                  
                            </div>
                           <div class="col-md-6">
                             <label>Outlet Location:</label>
                             <input type="text" class="form-control @error('outlet_location') is-invalid @enderror" name="outlet_location" value="{{$edituser->outlet_location}}">
                              
                           </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                             <label>Outlet Pincode:</label>
                             <select class="form-control" name="outlet_pincode">
                                @foreach($pin as $pins)
                                    <option value="{{$pins->pincode}}" <?php if($pins->pincode==$edituser->outlet_pincode){echo 'selected';} ?>>{{$pins->pincode}}</option>
                                @endforeach
                              </select>
                           </div>
                            <div class="col-md-6">
                             <label>Pincode Served:</label>
                             <select class="form-control js-example-basic-multiple @error('pincode') is-invalid @enderror" name="pincode[]" multiple>
                                @foreach($dis_explodes as $dis)             
                                    <option value="{{$dis}}" selected>{{$dis}}</option>
                                @endforeach
                                @foreach($pin as $pins)
                                    <option value="{{$pins->pincode}}">{{$pins->pincode}}</option>
                                @endforeach
                              </select>
                              @error('pincode')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div> <br>
                        <div class="row">
                            <div class="col-md-6">
                             <label>Radius Served (In KM):</label>
                             <input type="text" class="form-control @error('radius') is-invalid @enderror" name="radius" value="{{$edituser->radius}}">
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