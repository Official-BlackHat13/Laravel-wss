@extends('layouts.header')
@section('content')
<div class="main-content">
   <div class="section__content section__content--p30">
      <div class="container-fluid">
         <div class="row">
            <div class="col-lg-12">
               <div class="card">
                  <div class="card-header">Add Promo Form</div>
                  <form method="post" action="{{route('storepromo')}}"  enctype="multipart/form-data">
                     @csrf
                     <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                              <label>City:</label>
                              <select class="form-control" name="city">
                                @foreach($city as $cts)
                                    <option value="{{$cts->city}}" {{old ('city') == $cts->city ? 'selected' : ''}}>{{$cts->city}}</option>
                                @endforeach
                              </select>
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
                                 <option value="M" {{old ('gender') == 'M' ? 'selected' : ''}}>Male</option>
                                 <option value="F" {{old ('gender') == 'F' ? 'selected' : ''}}>Female</option>
                                 <option value="O" {{old ('gender') == 'O' ? 'selected' : ''}}>Other</option>
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
                            <div class="col-md-6">
                                 <label>Age</label>
                                 <input type="text" placeholder="Enter Age" class="form-control @error('age') is-invalid @enderror" name="age" value="<?php echo $startdate = (!empty(old('age')))? old('age') : ' ' ?>">
                                 @error('age')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                             </div>
                             <div class="col-md-6">
                                 <label>Category</label>
                                 <select class="form-control" name="main_category">
                                    @foreach($category as $cts)
                                        <option value="{{$cts->name}}" {{old ('company_id') == $coun->company_id ? 'selected' : ''}}>{{$cts->name}}</option>
                                    @endforeach
                                  </select>
                             </div>
                        </div><br>
                        
                        <div class="row">
                             <div class="col-md-6">
                                 <label>Promo Name</label>
                                 <input type="text" placeholder="Enter Promo Name" class="form-control @error('promo_name') is-invalid @enderror" name="promo_name" value="<?php echo $startdate = (!empty(old('promo_name')))? old('promo_name') : ' ' ?>">
                                 @error('promo_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                             </div>
                             <div class="col-md-6">
                                 <label>Headline</label>
                                 <input type="text" placeholder="Enter Headline" class="form-control @error('headline') is-invalid @enderror" name="headline" value="<?php echo $startdate = (!empty(old('headline')))? old('headline') : ' ' ?>">
                                 @error('headline')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                             </div>
                        </div><br>
                        <div class="row">
                             <div class="col-md-6">
                                 <label>Attach Image</label>
                                 <input type="file"  class="form-control @error('image') is-invalid @enderror" name="image">
                                 @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                             </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                              <label>Start Date:</label>
                              <input type="date" class="form-control @error('start_date') is-invalid @enderror" name="start_date" value="<?php echo $startdate = (!empty(old('start_date')))? old('start_date') : ' ' ?>">
                              @error('start_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                           </div> 
                           <div class="col-md-6">
                              <label>End Date:</label>
                              <input type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date" value="<?php echo $startdate = (!empty(old('end_date')))? old('end_date') : ' ' ?>">
                              @error('end_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
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