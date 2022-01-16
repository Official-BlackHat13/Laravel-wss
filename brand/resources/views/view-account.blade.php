<?php $gst = str_replace('/public','',url('/uploads/')); ?>
@extends('layouts.header')
@section('content')
<style>
.panel-heading {
  padding: 0;
	border:0;
}
.panel-title>a, .panel-title>a:active{
	display:block;
	padding:15px;
  color:#555;
  font-size:16px;
  font-weight:bold;
	text-transform:uppercase;
	letter-spacing:1px;
  word-spacing:3px;
	text-decoration:none;
}
.panel-default>.panel-heading {
    background-color: #f5f5f5;
    border-color: #ddd;
}
.panel-collapse{
    padding:10px;
}
.panel-default{
    margin-bottom:10px;
    border:1px solid #dbdbdb;
}
</style>
<div class="main-content">
   <div class="section__content section__content--p30">
      <div class="container-fluid">
         <div class="row">
            <div class="col-lg-12">
               <div class="card">
                  <div class="card-header">View Account</div>
                  <form method="post" action="#"  enctype="multipart/form-data">
                     @csrf
                     <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                              <label>Name:</label>
                              <input type="hidden" name="id" value="{{$edituser->id}}">
                              <input type="text" class="form-control" placeholder="Company Name" name="name" readonly value="{{$edituser->name }}">
                            </div>
                            <div class="col-md-6">
                              <label>Brand Name:</label>
                              <input type="text" class="form-control" placeholder="Brand Name" name="brand_name" readonly value="{{$edituser->brand_name }}">
                              
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                              <label>Short Name:</label>
                              <input type="text" class="form-control" placeholder="WSS-Lavie-01" name="short_name" readonly value="{{$edituser->company_id }}">
                              
                           </div>
                           <div class="col-md-6">
                              <label>Contact Person Name:</label>
                              <input type="text" class="form-control" placeholder="Contact Person Name" name="contact_name" readonly value="{{$edituser->contact_name }}">
                              
                            </div>
                        </div>
                        <br>
                        <div class="row">    
                            <div class="col-md-6">
                              <label>Contact Person Mobile:</label>
                              <input type="number" class="form-control" placeholder="Contact Person Mobile" name="contact_mobile" readonly value="{{$edituser->contact_mobile }}">
                              
                            </div>
                            <div class="col-md-6">
                              <label>Contact Person Email:</label>
                              <input type="text" class="form-control" placeholder="example@company.com" name="email" readonly value="{{$edituser->email }}">
                             
                           </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                               <label>Country:</label>
                              <select class="form-control country-dropdown @error('country') is-invalid @enderror" disabled="disabled" name="country"  required>
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
                           <div class="col-md-6">
                               <label>State:</label>
                               <select id="" class="form-control state-dropdown @error('state') is-invalid @enderror" disabled="disabled" name="state" required>
                                   <option value="{{$edituser->state}}">{{$edituser->state}}</option>
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
                            <div class="col-md-6">
                               <label>City:</label>
                                   <select id="" class="form-control city-dropdown @error('city') is-invalid @enderror" disabled="disabled" name="city" required>
                                       <option value="{{$edituser->city}}">{{$edituser->city}}</option>
                                   </select>
                                   @error('city')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                              <label>Address:</label>
                              <input type="text" class="form-control" placeholder="Enter Full Address" readonly name="address" value="{{$edituser->address}}">
                              
                           </div>
                        </div>
                        <br>
                        <div class="row"> 
                            <div class="col-md-6">
                              <label>Website:</label>
                              <input type="text" class="form-control" placeholder="company.com" name="website" readonly value="{{$edituser->website }}">
                            
                           </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Company Logo</label><br>
                                <!--<input type="file" name="image" class="form-control" disabled="disabled">-->
                                <!--<span class="row col-md-12" style="color:red;">Upload Size:- Less Then 1MB </span>-->
                                <!--<span class="row col-md-12" style="color:red;">Image Format:- jpeg,jpg,png allowed</span><br>-->
                                <img src="https://bniindiastore.com/bmongers/uploads/{{ $edituser->company_logo }}" style="width:100px;height:60px;">
                            </div>
                            <div class="col-md-6">
                                <label>About Company</label>
                                <textarea type="text" name="company_info" class="form-control" readonly>{{ $edituser->company_info }}</textarea>
                               
                            </div>
                        </div><br>
                        <div class="wrapper center-block">
                          <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                          @foreach($supcat as $supcats)    
                          <div class="panel panel-default">
                            <div class="panel-heading active" role="tab" id="heading{{$supcats->name}}">
                              <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$supcats->name}}" aria-expanded="true" aria-controls="collapse{{$supcats->name}}">
                                  {{$supcats->name}}
                                </a>
                              </h4>
                            </div>
                            <div id="collapse{{$supcats->name}}" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading{{$supcats->name}}">
                              <div class="panel-body">
                                <?php $cat = DB::table('categories')->select('categories.*')->where('super_category_id','=',$supcats->id)->where('status','=',1)->get(); ?>  
                                    @foreach($cat as $cats)
                                        <div class="categorydiv">
                                            <?php $data= explode(',',$edituser->category_id); ?>
                                            <input type="checkbox" class="cbb checkbox-parent" name="category[]" disabled value="{{$cats->id}}" <?php if(in_array($cats->id, $data)){echo 'checked';} ?>> {{$cats->name}} <br>
                                            <?php $subcat = DB::table('sub_categories')->select('sub_categories.*')->where('category_id','=',$cats->id)->where('status','=',1)->get(); ?> 
                                            <div class="sbcategorydiv" style="margin-left:20px;">
                                                @foreach($subcat as $sbcat)
                                                 <?php $data= explode(',',$edituser->subcategory_id);?>
                                                    <input type="checkbox" class="checkbox-child"  name="sub_category[]" value="{{$sbcat->id}}" disabled <?php if(in_array($sbcat->id, $data)){echo 'checked';} ?>> {{$sbcat->name}} <br>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                              </div>
                            </div>
                          </div>
                          @endforeach
                        </div>
                        </div>
                     </div>
                     <!--<div class="card-footer">-->
                     <!--   <button type="submit" class="btn btn-primary btn-sm">-->
                     <!--   <i class="fa fa-dot-circle-o"></i> Submit-->
                     <!--   </button>-->
                     <!--   <button type="reset" class="btn btn-danger btn-sm">-->
                     <!--   <i class="fa fa-ban"></i> Reset-->
                     <!--   </button>-->
                     <!--</div>-->
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
$('.panel-collapse').on('show.bs.collapse', function () {
    $(this).siblings('.panel-heading').addClass('active');
  });

  $('.panel-collapse').on('hide.bs.collapse', function () {
    $(this).siblings('.panel-heading').removeClass('active');
  });
  
$('.checkbox-parent').change(function() {
  // Traverse the DOM to get associated child checkbox
  var $child = $(this).closest('div').find('.checkbox-child');
  
  // Update child state based on checked status
  $child.prop('disabled', !this.checked);
});
</script>
@endsection