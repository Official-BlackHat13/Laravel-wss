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
                  <div class="card-header">Add Company</div>
                  <form method="post" action="{{route('postdtcom')}}"  enctype="multipart/form-data">
                     @csrf
                     <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                              <label>Name:</label>
                              <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Company Name" name="name" value="{{ old('name', isset($basicOrgInfo) ? $basicOrgInfo->name : '') }}">
                              @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                              <label>Brand Name:</label>
                              <input type="text" class="form-control @error('brand_name') is-invalid @enderror" placeholder="Brand Name" name="brand_name" value="{{ old('brand_name', isset($basicOrgInfo) ? $basicOrgInfo->brand_name : '') }}">
                              @error('brand_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                              <label>Short Name:</label>
                              <input type="text" class="form-control @error('short_name') is-invalid @enderror" placeholder="WSS-Lavie-01" name="short_name" value="{{ old('short_name', isset($basicOrgInfo) ? $basicOrgInfo->short_name : '') }}">
                              @error('short_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                           </div>
                           <div class="col-md-6">
                              <label>Contact Person Name:</label>
                              <input type="text" class="form-control @error('contact_name') is-invalid @enderror" placeholder="Contact Person Name" name="contact_name" value="{{ old('contact_name', isset($basicOrgInfo) ? $basicOrgInfo->contact_name : '') }}">
                              @error('contact_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <br>
                        <div class="row">    
                            <div class="col-md-6">
                              <label>Contact Person Mobile:</label>
                              <input type="number" class="form-control @error('contact_mobile') is-invalid @enderror" placeholder="Contact Person Mobile" name="contact_mobile" value="{{ old('contact_mobile', isset($basicOrgInfo) ? $basicOrgInfo->contact_mobile : '') }}">
                              @error('contact_mobile')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                              <label>Contact Person Email:</label>
                              <input type="text" class="form-control @error('email') is-invalid @enderror" placeholder="example@company.com" name="email" value="{{ old('email', isset($basicOrgInfo) ? $basicOrgInfo->email : '') }}">
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
                               <label>Country:</label>
                              <select class="form-control country-dropdown @error('country') is-invalid @enderror" name="country"  required>
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
                           <div class="col-md-6">
                               <label>State:</label>
                               <select id="" class="form-control state-dropdown @error('state') is-invalid @enderror" name="state" required></select>
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
                                   <select id="" class="form-control city-dropdown @error('city') is-invalid @enderror" name="city" required>
                                       
                                   </select>
                                   @error('city')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                              <label>Address:</label>
                              <input type="text" class="form-control @error('address') is-invalid @enderror" placeholder="Enter Full Address" name="address" value="{{ old('address', isset($basicOrgInfo) ? $basicOrgInfo->address : '') }}">
                              @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                           </div>
                        </div>
                        <br>
                        <div class="row"> 
                            <div class="col-md-6">
                              <label>Website:</label>
                              <input type="text" class="form-control @error('website') is-invalid @enderror" placeholder="company.com" name="website" value="{{ old('website', isset($basicOrgInfo) ? $basicOrgInfo->website : '') }}">
                              @error('website')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                           </div>
                            <div class="col-md-6">
                              <label>Pincode:</label>
                             <select class="form-control js-example-basic-multiple @error('pincode') is-invalid @enderror" placeholder="302012" name="pincode">
                                @foreach($pin as $pins)
                                    <option value="{{$pins->pincode}}" {{old ('pincode') == $pins->pincode ? 'selected' : ''}}>{{$pins->pincode}}</option>
                                @endforeach
                              </select>
                              @error('pincode')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                           </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                              <label>Radius(In KM):</label>
                              <input type="text" name="radius" placeholder="5" class="form-control @error('radius') is-invalid @enderror" value="{{ old('radius', isset($basicOrgInfo) ? $basicOrgInfo->radius : '') }}">
                              @error('radius')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                              <label>Password:</label>
                              <input type="password" name="password" placeholder="Enter Password" class="form-control @error('password') is-invalid @enderror" value="{{ old('password', isset($basicOrgInfo) ? $basicOrgInfo->password : '') }}">
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
                                <label>Company Logo</label>
                                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            <span class="row col-md-12" style="color:red;">Upload Size:- Less Then 1MB </span>
                            <span class="row col-md-12" style="color:red;">Image Format:- jpeg,jpg,png allowed</span>
                            </div>
                            <div class="col-md-6">
                                <label>About Company</label>
                                <textarea type="text" name="company_info" class="form-control @error('company_info') is-invalid @enderror">{{ old('company_info', isset($basicOrgInfo) ? $basicOrgInfo->company_info : '') }}</textarea>
                                @error('company_info')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div><br>
                        <h4 style="margin-left:0px;">Pay Per Click Price</h4><br>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Quick Shop</label>
                                <input type="number" name="quick_shop" placeholder="Enter Quick Shop Price" class="form-control @error('quick_shop') is-invalid @enderror" value="{{ old('quick_shop', isset($basicOrgInfo) ? $basicOrgInfo->quick_shop : '') }}">
                                @error('quick_shop')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label>Video/Audio Call</label>
                                <input type="number" name="online_shop" placeholder="Enter Online Shop Price" class="form-control @error('online_shop') is-invalid @enderror" value="{{ old('online_shop', isset($basicOrgInfo) ? $basicOrgInfo->online_shop : '') }}">
                                @error('online_shop')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Click =  No of Clicks For Quick Shop</label>
                                <input type="number" class="form-control @error('quick_click') is-invalid @enderror" name="quick_click" value="{{ old('quick_click', isset($basicOrgInfo) ? $basicOrgInfo->quick_click : '') }}">
                                @error('quick_click')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label>Click = No of Clicks For Audio/Video Call</label>
                                <input type="number" class="form-control @error('online_click') is-invalid @enderror" name="online_click" value="{{ old('online_click', isset($basicOrgInfo) ? $basicOrgInfo->online_click : '') }}">
                                @error('online_click')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        </br>
                        <h4 style="margin-left:0px;">Per Click Point For User</h4><br>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Quick Shop</label>
                                <input type="number" name="quick_point" placeholder="Enter Quick Shop Point" class="form-control @error('quick_point') is-invalid @enderror" value="{{ old('quick_point', isset($basicOrgInfo) ? $basicOrgInfo->quick_point : '') }}">
                                @error('quick_point')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label>Video/Audio Call</label>
                                <input type="number" name="online_point" placeholder="Enter Online Shop Point" class="form-control @error('online_point') is-invalid @enderror" value="{{ old('online_point', isset($basicOrgInfo) ? $basicOrgInfo->online_point : '') }}">
                                @error('online_point')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div><br>
                        <h4 style="margin-left:0px;">Online Shop Time </h4><br>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Prepiad Video Minutes</label>
                                <input type="number" name="video_minutes" placeholder="Enter Video Call Minutes" class="form-control @error('video_minutes') is-invalid @enderror" value="{{ old('video_minutes', isset($basicOrgInfo) ? $basicOrgInfo->video_minutes : '') }}">
                                @error('video_minutes')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label>Prepiad Audio Minutes</label>
                                <input type="number" name="audio_minutes" placeholder="Enter Audio Call Minutes" class="form-control @error('audio_minutes') is-invalid @enderror" value="{{ old('audio_minutes', isset($basicOrgInfo) ? $basicOrgInfo->audio_minutes : '') }}">
                                @error('audio_minutes')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div><br>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <label>Commision on Sale %</label>
                                <input type="number" name="commision" class="form-control @error('commision') is-invalid @enderror" placeholder="Enter Commision On Sale in %" value="{{ old('commision', isset($basicOrgInfo) ? $basicOrgInfo->commision : '') }}">
                                @error('commision')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label>Daily S&M Per Store Price</label>
                                <input type="number" name="store_price" class="form-control @error('store_price') is-invalid @enderror" placeholder="Enter S&M Price" value="{{ old('store_price', isset($basicOrgInfo) ? $basicOrgInfo->store_price : '') }}">
                                @error('store_price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Reserve Video Calls</label>
                                <input type="number" name="reserve_video_minutes" placeholder="Enter Reserve Video Call Minutes" class="form-control @error('reserve_video_minutes') is-invalid @enderror" value="{{ old('reserve_video_minutes', isset($basicOrgInfo) ? $basicOrgInfo->reserve_video_minutes : '') }}">
                                @error('reserve_video_minutes')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label>Reserve Voice Calls</label>
                                <input type="number" name="reserve_audio_minutes" placeholder="Enter Reserve Voice Call Minutes" class="form-control @error('reserve_audio_minutes') is-invalid @enderror" value="{{ old('reserve_audio_minutes', isset($basicOrgInfo) ? $basicOrgInfo->reserve_audio_minutes : '') }}">
                                @error('reserve_audio_minutes')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-md-6">
                                <label>GSTIN</label>
                                <input type="text" name="gst_number" placeholder="Enter GST Number" class="form-control @error('gst_number') is-invalid @enderror" value="{{ old('gst_number', isset($basicOrgInfo) ? $basicOrgInfo->gst_number : '') }}">
                                <!--@error('reserve_audio_minutes')-->
                                <!--    <span class="invalid-feedback" role="alert">-->
                                <!--        <strong>{{ $message }}</strong>-->
                                <!--    </span>-->
                                <!--@enderror-->
                            </div>
                        </div><br>
                        <h4>Bank Details</h4><br>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Account Number</label>
                                <input type="number" name="acc_number" placeholder="Enter Account Number" class="form-control @error('acc_number') is-invalid @enderror" value="{{ old('acc_number', isset($basicOrgInfo) ? $basicOrgInfo->acc_number : '') }}">
                                <!--@error('acc_number')-->
                                <!--    <span class="invalid-feedback" role="alert">-->
                                <!--        <strong>{{ $message }}</strong>-->
                                <!--    </span>-->
                                <!--@enderror-->
                            </div>
                            <div class="col-md-6">
                                <label>Confirm Account Number</label>
                                <input type="number" name="cacc_number" placeholder="Confirm Account Number" class="form-control @error('cacc_number') is-invalid @enderror" value="{{ old('cacc_number', isset($basicOrgInfo) ? $basicOrgInfo->cacc_number : '') }}">
                                <!--@error('cacc_number')-->
                                <!--    <span class="invalid-feedback" role="alert">-->
                                <!--        <strong>{{ $message }}</strong>-->
                                <!--    </span>-->
                                <!--@enderror-->
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Beneficiary Name </label>
                                <input type="text" name="beneficiary_name" placeholder="Enter Beneficiary Name" class="form-control @error('beneficiary_name') is-invalid @enderror" value="{{ old('beneficiary_name', isset($basicOrgInfo) ? $basicOrgInfo->beneficiary_name : '') }}">
                                <!--@error('beneficiary_name')-->
                                <!--    <span class="invalid-feedback" role="alert">-->
                                <!--        <strong>{{ $message }}</strong>-->
                                <!--    </span>-->
                                <!--@enderror-->
                            </div>
                            <div class="col-md-6">
                                <label>IFSC Code </label>
                                <input type="text" name="ifsc_code" placeholder="Enter IFSC Code" class="form-control @error('ifsc_code') is-invalid @enderror" value="{{ old('ifsc_code', isset($basicOrgInfo) ? $basicOrgInfo->ifsc_code : '') }}">
                                <!--@error('ifsc_code')-->
                                <!--    <span class="invalid-feedback" role="alert">-->
                                <!--        <strong>{{ $message }}</strong>-->
                                <!--    </span>-->
                                <!--@enderror-->
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Bank Name </label>
                                <input type="text" name="bank_name" placeholder="Enter Bank Name" class="form-control @error('bank_name') is-invalid @enderror" value="{{ old('bank_name', isset($basicOrgInfo) ? $basicOrgInfo->bank_name : '') }}">
                                <!--@error('bank_name')-->
                                <!--    <span class="invalid-feedback" role="alert">-->
                                <!--        <strong>{{ $message }}</strong>-->
                                <!--    </span>-->
                                <!--@enderror-->
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
                                            <input type="checkbox" class="cbb checkbox-parent" name="category[]" value="{{$cats->id}}" {{ (is_array(old('category')) and in_array($cats->id, old('category'))) ? ' checked' : '' }}> {{$cats->name}} <br>
                                            <?php $subcat = DB::table('sub_categories')->select('sub_categories.*')->where('category_id','=',$cats->id)->where('status','=',1)->get(); ?> 
                                            <div class="sbcategorydiv" style="margin-left:20px;">
                                                @foreach($subcat as $sbcat)
                                                    <input type="checkbox" class="checkbox-child"  name="sub_category[]" value="{{$sbcat->id}}" disabled="" {{ (is_array(old('sub_category')) and in_array($sbcat->id, old('sub_category'))) ? ' checked' : '' }}> {{$sbcat->name}} <br>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                              </div>
                            </div>
                          </div>
                          @endforeach
                          <!--<div class="panel panel-default">-->
                          <!--  <div class="panel-heading" role="tab" id="headingFour">-->
                          <!--    <h4 class="panel-title">-->
                          <!--      <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">-->
                          <!--        Product Attribute-->
                          <!--      </a>-->
                          <!--    </h4>-->
                          <!--  </div>-->
                          <!--  <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">-->
                          <!--    <div class="panel-body">-->
                          <!--      <input type="checkbox" name="weight" value="Yes" {{ (is_array(old('weight')) and in_array("Yes", old('weight'))) ? ' checked' : '' }}> Weight <br>-->
                          <!--      <input type="checkbox" name="height" value="Yes" {{ (is_array(old('height')) and in_array("Yes", old('height'))) ? ' checked' : '' }}> Height <br>-->
                          <!--      <input type="checkbox" name="width" value="Yes" {{ (is_array(old('width')) and in_array("Yes", old('width'))) ? ' checked' : '' }}> Width <br>-->
                          <!--      <input type="checkbox" name="length" value="Yes" {{ (is_array(old('length')) and in_array("Yes", old('length'))) ? ' checked' : '' }}> Length <br>-->
                          <!--      <input type="checkbox" name="color" value="Yes" {{ (is_array(old('color')) and in_array("Yes", old('color'))) ? ' checked' : '' }}> Color   <br>-->
                          <!--      <input type="checkbox" name="size" value="Yes" {{ (is_array(old('size')) and in_array("Yes", old('size'))) ? ' checked' : '' }}> Size-->
                          <!--    </div>-->
                          <!--  </div>-->
                          <!--</div>-->
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
$(".state-dropdown").append('<option value="'+value.name+'" data-id="'+value.id+'" >'+value.name+'</option>');
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
<script>
$(".cb").on("click",function(e){
    var course = [];
    $(".cb").each(function(){
      if ($(this).is(":checked")) {
          course.push($(this).val());
      }
    });
    var ids = course.join(",");
    $(".categorydiv").html('');
    $.ajax({
    url:"{{url('get-category-by-super')}}",
    type: "POST",
    data: {
    ids: ids,
    _token: '{{csrf_token()}}' 
    },
    dataType : 'json',
    success: function(result){
        $('.categorydiv').html(''); 
        $.each(result.category,function(key,value){
        $(".categorydiv").append('<input type="checkbox" class="cbb" name="category[]" value="'+value.id+'">'+'&nbsp;' + value.name +'<br>');
        });
    }
});
});
</script>
<script>
$(".categorydiv").on("click",function(e){
    var course = [];
    $(".cbb").each(function(){
      if ($(this).is(":checked")) {
          course.push($(this).val());
      }
    });
    var ids = course.join(",");
    $(".subcategorydiv").html('');
    $.ajax({
    url:"{{url('get-sub-by-category')}}",
    type: "POST",
    data: {
    ids: ids,
    _token: '{{csrf_token()}}' 
    },
    dataType : 'json',
    success: function(result){
        $('.subcategorydiv').html(''); 
        $.each(result.subcategory,function(key,value){
        $(".subcategorydiv").append('<input type="checkbox" name="sub_category[]" value="'+value.id+'">'+'&nbsp;' + value.name +'<br>');
        });
    }
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