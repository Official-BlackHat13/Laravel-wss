@extends('layouts.header')
@section('content')
<div class="main-content">
   <div class="section__content section__content--p30">
      <div class="container-fluid">
         <div class="row">
            <div class="col-lg-12">
               <div class="card">
                  <div class="card-header">Add Store Admin</div>
                  <form method="post" action="{{route('postdtsad')}}"  enctype="multipart/form-data">
                     @csrf
                     <div class="card-body">
                         <div class="row">
                           <div class="col-md-6">
                              <label>Company:</label>
                              <select class="form-control" name="company_id">
                                @foreach($company as $coun)
                                    <option value="{{$coun->company_id}}"  {{old ('company_id') == $coun->company_id ? 'selected' : ''}}>{{$coun->company_id}}</option>
                                @endforeach
                              </select>
                           </div>
                           <div class="col-md-6">
                              <label>Brand:</label>
                              <select class="form-control" name="brand_admin_id">
                                @foreach($brand as $brands)
                                    <option value="{{$brands->brand_admin_id}}"  {{old ('brand_admin_id') == $brands->brand_admin_id ? 'selected' : ''}}>{{$brands->brand_admin_id}}</option>
                                @endforeach
                              </select>
                           </div>
                        </div>
                        <br>
                        <div class="row">
                           <div class="col-md-6">
                              <label>Name:</label>
                              <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Ashish" name="name" value="{{ old('name', isset($basicOrgInfo) ? $basicOrgInfo->name : '') }}">
                              @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                           </div>
                        
                           <div class="col-md-6">
                              <label>Email:</label>
                              <input type="text" class="form-control @error('email') is-invalid @enderror" placeholder="example@gmail.com" name="email" value="{{ old('email', isset($basicOrgInfo) ? $basicOrgInfo->email : '') }}">
                              @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                           </div>
                        </div>
                        <br>
                        <div class="row">
                           <div class="col-md-6">
                              <label>Mobile:</label>
                              <input type="number" class="form-control @error('phone') is-invalid @enderror" placeholder="9876543210" name="phone" value="{{ old('phone', isset($basicOrgInfo) ? $basicOrgInfo->phone : '') }}">
                              @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                           </div>
                        
                           <div class="col-md-6">
                              <label>Age:</label>
                              <input type="text" class="form-control @error('age') is-invalid @enderror" placeholder="29" name="age" value="{{ old('age', isset($basicOrgInfo) ? $basicOrgInfo->age : '') }}">
                              @error('age')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                           </div>
                        </div>
                        <br>
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
                              <label>Country:</label>
                              <select class="form-control country-dropdown @error('country') is-invalid @enderror" name="country" required>
                                <option value="">Select Country</option>
                                @foreach($country as $countrys)
                                    <option value="{{$countrys->name}}" data-id="{{$countrys->id}}">{{$countrys->name}}</option>
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
                               <select id="" class="form-control state-dropdown @error('state') is-invalid @enderror" name="state" required></select>
                               @error('state')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                           </div>
                           <div class="col-md-6">
                               <label>City:</label>
                                   <select id="" class="form-control city-dropdown @error('city') is-invalid @enderror" name="city" required></select>
                                   @error('city')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                              <label>Position:</label>
                              <input type="text" name="position" class="form-control @error('position') is-invalid @enderror" placeholder="Store Head" value="{{ old('position', isset($basicOrgInfo) ? $basicOrgInfo->position : '') }}">
                               @error('position')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                              <label>Password:</label>
                              <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter Password" value="{{ old('password', isset($basicOrgInfo) ? $basicOrgInfo->password : '') }}">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                              <label>Role:</label><br>
                              <input type="checkbox" name="role[]" class="@error('role') is-invalid @enderror" value="1">  Inventory & Order Processing <br>
                              <input type="checkbox" name="role[]" class="@error('role') is-invalid @enderror" value="2"> Sales Expert 
                              @error('role')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
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