@extends('layouts.header')
@section('content')
<div class="main-content">
   <div class="section__content section__content--p30">
      <div class="container-fluid">
         <div class="row">
            <div class="col-lg-12">
               <div class="card">
                  <div class="card-header">Add Promo Form</div>
                  <form method="post" action="#"  enctype="multipart/form-data">
                     @csrf
                     <div class="card-body">
                         <div class="row">
                             <div class="col-md-8">
                                 <label>Attach Image</label>
                                 <input type="file"  class="form-control" name="image">
                             </div>
                        </div>
                        <br>
                        
                        <div class="row">
                             <div class="col-md-8">
                                 <label>Attach URL</label>
                                 <input type="text" placeholder="Attach URL" class="form-control" name="url">
                             </div>
                        </div><br>
                        
                         <div class="row">
                            <div class="col-md-6">
                              <label>Date:</label>
                              <input type="date" class="form-control" name="date">
                           </div>
                           <div class="col-md-6">
                              <label>City:</label>
                              <select class="form-control" name="city">
                                @foreach($city as $cts)
                                    <option value="{{$cts->city}}" {{old ('city') == $cts->city ? 'selected' : ''}}>{{$cts->city}}</option>
                                @endforeach
                              </select>
                           </div>
                        </div><br>
                        
                         <div class="row">
                            <div class="col-md-6">
                              <label>Time:</label>
                              <input type="time" class="form-control" name="time">
                           </div>
                           <div class="col-md-6">
                              <label>Store:</label>
                              <select class="form-control" name="store_id">
                                @foreach($store as $stores)
                                    <option value="{{$stores->store_admin_id}}" {{old ('store_id') == $stores->store_admin_id ? 'selected' : ''}}>{{$stores->store_admin_id}}</option>
                                @endforeach
                              </select>
                           </div>
                        </div><br>
                        
                        <div class="row">
                            <div class="col-md-6">
                              <label>Gender:</label>
                              <select class="form-control" name="gender">
                                 <option value="M">Male</option>
                                 <option value="F">Female</option>
                                 <option value="O">Other</option>
                              </select>
                           </div>
                           <div class="col-md-6">
                              <label>Company:</label>
                              <select class="form-control" name="company_id">
                                @foreach($company as $coun)
                                    <option value="{{$coun->company_id}}" {{old ('company_id') == $coun->company_id ? 'selected' : ''}}>{{$coun->company_id}}</option>
                                @endforeach
                              </select>
                           </div>
                        </div>
                        <br>
                        
                        <div class="row">
                             <div class="col-md-8">
                                 <label>Main Category/Promo</label>
                                 <input type="text" placeholder="Enter Promo Name" class="form-control" name="main_category">
                             </div>
                        </div><br>
                        
                        <div class="row">
                             <div class="col-md-8">
                                 <label>Headline</label>
                                 <input type="text" placeholder="Enter Headline" class="form-control" name="headline">
                             </div>
                        </div><br>
                        
                        <div class="row">
                             <div class="col-md-8">
                                 <label>Message</label>
                                 <textarea class="form-control" name="message" placeholder="Message"></textarea>
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