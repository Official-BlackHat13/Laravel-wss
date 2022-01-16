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
.tab {
  display: none;
}
.step {
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbbbbb;
  border: none;
  border-radius: 50%;
  display: inline-block;
  opacity: 0.5;
}
.step.active {
  opacity: 1;
}
.step.finish {
  background-color: #04AA6D;
}
</style>
<div class="main-content">
   <div class="section__content section__content--p30">
      <div class="container-fluid">
         <div class="row">
            <div class="col-lg-12">
               <div class="card">
                  <div class="card-header">Add Company</div>
                  <form id="regForm" method="post" action="{{route('postdtcom')}}"  enctype="multipart/form-data">
                     @csrf
                     <div class="card-body">
                        <div class="tab">
                            <h5>Company Details</h5> <br>
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
                            </div><br>
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
                        </div>
                        </div>
                         </div>
                        <div class="tab">
                            <h5>Account Commercials</h5> <br>
                            <div class="row">
                                <div class="col-md-6">
                                  <label>City:</label>
                                  <select class="form-control country-dropdown" name="store_city" required >
                                    <option value="">Select City</option>
                                    @foreach($store_city as $cty)
                                        <option value="{{$cty->city}}" data-id="{{$cty->id}}">{{$cty->city}}</option>
                                    @endforeach
                                  </select>
                                    @error('store_city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                               </div>
                            </div><br>
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
                               </div>
                            </div><br>
                            <h4>Bank Details</h4><br>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Account Number</label>
                                    <input type="number" name="acc_number" placeholder="Enter Account Number" class="form-control @error('acc_number') is-invalid @enderror" value="{{ old('acc_number', isset($basicOrgInfo) ? $basicOrgInfo->acc_number : '') }}">
                                </div>
                                <div class="col-md-6">
                                    <label>Confirm Account Number</label>
                                    <input type="number" name="cacc_number" placeholder="Confirm Account Number" class="form-control @error('cacc_number') is-invalid @enderror" value="{{ old('cacc_number', isset($basicOrgInfo) ? $basicOrgInfo->cacc_number : '') }}">
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Beneficiary Name </label>
                                    <input type="text" name="beneficiary_name" placeholder="Enter Beneficiary Name" class="form-control @error('beneficiary_name') is-invalid @enderror" value="{{ old('beneficiary_name', isset($basicOrgInfo) ? $basicOrgInfo->beneficiary_name : '') }}">
                               </div>
                                <div class="col-md-6">
                                    <label>IFSC Code </label>
                                    <input type="text" name="ifsc_code" placeholder="Enter IFSC Code" class="form-control @error('ifsc_code') is-invalid @enderror" value="{{ old('ifsc_code', isset($basicOrgInfo) ? $basicOrgInfo->ifsc_code : '') }}">
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Bank Name </label>
                                    <input type="text" name="bank_name" placeholder="Enter Bank Name" class="form-control @error('bank_name') is-invalid @enderror" value="{{ old('bank_name', isset($basicOrgInfo) ? $basicOrgInfo->bank_name : '') }}">
                                </div>
                            </div>
                        </div>
                        <div class="tab">
                            <h5>Outlets/Stores</h5> <br>
                            <!--<div class="row">-->
                            <!--    <div class="col-md-6">-->
                            <!--      <label>Country:</label>-->
                            <!--      <select class="form-control country-dropdown @error('country') is-invalid @enderror" name="country" required >-->
                            <!--        <option value="">Select Country</option>-->
                            <!--        @foreach($country as $countrys)-->
                            <!--            <option value="{{$countrys->name}}" data-id="{{$countrys->id}}">{{$countrys->name}}</option>-->
                            <!--        @endforeach-->
                            <!--      </select>-->
                            <!--        @error('country')-->
                            <!--        <span class="invalid-feedback" role="alert">-->
                            <!--            <strong>{{ $message }}</strong>-->
                            <!--        </span>-->
                            <!--        @enderror-->
                            <!--   </div>-->
                            <!--   <div class="col-md-6">-->
                            <!--       <label>State:</label>-->
                            <!--       <select id="" class="form-control state-dropdown @error('state') is-invalid @enderror" name="state" required></select>-->
                            <!--       @error('state')-->
                            <!--        <span class="invalid-feedback" role="alert">-->
                            <!--            <strong>{{ $message }}</strong>-->
                            <!--        </span>-->
                            <!--        @enderror-->
                            <!--   </div>-->
                            <!--</div>-->
                            <!--<br>-->
                            <!--<div class="row">-->
                               <!--<div class="col-md-6">-->
                               <!--    <label>City:</label>-->
                               <!--        <select id="" class="form-control city-dropdown @error('city') is-invalid @enderror" name="city" required></select>-->
                               <!--        @error('city')-->
                               <!--     <span class="invalid-feedback" role="alert">-->
                               <!--         <strong>{{ $message }}</strong>-->
                               <!--     </span>-->
                               <!--     @enderror-->
                               <!-- </div>-->
                               
                            <!--</div>-->
                            <!--<br>-->
                            <div class="row">
                                <div class="col-md-6">
                                 <label>Outlet Location:</label>
                                 <input type="text" class="form-control @error('outlet_location') is-invalid @enderror" name="outlet_location[]" value="<?php echo $startdate = (!empty(old('outlet_location')))? old('outlet_location') : ' ' ?>">
                                  @error('outlet_location')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                               </div>
                                <div class="col-md-6">
                                 <label>Outlet Pincode:</label>
                                 <select class="form-control" name="outlet_pincode[]">
                                    @foreach($pin as $pins)
                                        <option value="{{$pins->pincode}}" {{old ('outlet_pincode') == $pins->pincode ? 'selected' : ''}}>{{$pins->pincode}}</option>
                                    @endforeach
                                  </select>
                               </div>
                            </div> 
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                 <label>Pincode Served:</label>
                                 <select class="form-control js-example-basic-multiple @error('pincode') is-invalid @enderror" name="served_pincode[]" multiple>
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
                                <div class="col-md-6">
                                <label>Radius Served(In KM):</label>
                                 <input type="text" class="form-control @error('radius') is-invalid @enderror" name="outlet_radius[]" value="<?php echo $startdate = (!empty(old('radius')))? old('radius') : ' ' ?>">
                                  @error('radius')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div id="room_fileds"></div><br>
                            <div class="btn btn-primary" id="brandadd"  onclick="add_fields();"> Add More Outlets</div>
                        </div>
                     </div>
                     <div class="card-footer">
                        <div style="overflow:auto;">
                          <div style="float:right;">
                            <button class="btn btn-success" type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                            <button class="btn btn-primary" type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
                            <button class="btn btn-primary" type="submit" name="submit" id="subBtn">Submit</button>
                          </div>
                        </div>
                        
                        <div style="text-align:center;margin-top:40px;">
                          <span class="step"></span>
                          <span class="step"></span>
                          <span class="step"></span>
                        </div>
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
$(document).ready(function() {
    $('.js-example-basic-multiple').select2();
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

var currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the current tab

function showTab(n) {
  // This function will display the specified tab of the form ...
  var x = document.getElementsByClassName("tab");
  x[n].style.display = "block";
  // ... and fix the Previous/Next buttons:
  if (n == 0) {
    document.getElementById("prevBtn").style.display = "none";
  } else {
    document.getElementById("prevBtn").style.display = "inline";
  }
  if (n == (x.length - 1)) {
    document.getElementById("nextBtn").innerHTML = "Submit";
    document.getElementById("subBtn").style.display = "inline";
    document.getElementById("nextBtn").style.display = "none";
  } else {
    document.getElementById("nextBtn").innerHTML = "Next";
    document.getElementById("subBtn").style.display = "none";
    document.getElementById("nextBtn").style.display = "inline";
  }
  // ... and run a function that displays the correct step indicator:
  fixStepIndicator(n)
}

function nextPrev(n) {
  // This function will figure out which tab to display
  var x = document.getElementsByClassName("tab");
  // Exit the function if any field in the current tab is invalid:
//   if (n == 1 && !validateForm()) return false;
  // Hide the current tab:
  x[currentTab].style.display = "none";
  // Increase or decrease the current tab by 1:
  currentTab = currentTab + n;
  // if you have reached the end of the form... :
  if (currentTab >= x.length) {
    //...the form gets submitted:
    document.getElementById("regForm").submit();
    return false;
  }
  // Otherwise, display the correct tab:
  showTab(currentTab);
}

// function validateForm() {
//   // This function deals with validation of the form fields
//   var x, y, i, valid = true;
//   x = document.getElementsByClassName("tab");
//   y = x[currentTab].getElementsByTagName("input");
//   // A loop that checks every input field in the current tab:
//   for (i = 0; i < y.length; i++) {
//     // If a field is empty...
//     if (y[i].value == "") {
//       // add an "invalid" class to the field:
//       y[i].className += " invalid";
//       // and set the current valid status to false:
//       valid = false;
//     }
//   }
//   // If the valid status is true, mark the step as finished and valid:
//   if (valid) {
//     document.getElementsByClassName("step")[currentTab].className += " finish";
//   }
//   return valid; // return the valid status
// }

function fixStepIndicator(n) {
  // This function removes the "active" class of all steps...
  var i, x = document.getElementsByClassName("step");
  for (i = 0; i < x.length; i++) {
    x[i].className = x[i].className.replace(" active", "");
  }
  //... and adds the "active" class to the current step:
  x[n].className += " active";
}
</script>
<script>
var branchfield = 1;
    function add_fields(){
       branchfield++;
       var objTo = document.getElementById('room_fileds')
       var divtest = document.createElement("div");
       divtest.innerHTML = '<div style="margin-top:15px"><h4 style="margin-left:1px;margin-top:15px">Outlet ' + branchfield + ' :</h4><br> <div class="row"><div class="col-md-6"><label>Outlet Location:</label><input type="text" class="form-control " name="outlet_location[]"></div><div class="col-md-6"><label>Outlet Pincode:</label><select class="form-control" name="outlet_pincode[]">@foreach($pin as $pins)<option value="{{$pins->pincode}}">{{$pins->pincode}}</option>@endforeach</select></div></div> <br><div class="row"><div class="col-md-6"><label>Pincode Served:</label><select class="form-control js-example-basic-multiple'+ branchfield + '" name="served_pincode[]" multiple>@foreach($pin as $pins)<option value="{{$pins->pincode}}">{{$pins->pincode}}</option>@endforeach</select></div><div class="col-md-6"><label>Radius Served(In KM):</label><input type="text" class="form-control" name="outlet_radius[]"></div></div></div>';
   	   objTo.appendChild(divtest)						
    }  
</script>
@endsection