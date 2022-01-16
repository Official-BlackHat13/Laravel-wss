@extends('layouts.header')
@section('content')
<div class="main-content">
   <div class="section__content section__content--p30">
      <div class="container-fluid">
         <div class="row">
            <div class="col-lg-12">
               <div class="card">
                  <div class="card-header">Add Offer Banner</div>
                  <form method="post" action="{{route('postdtob')}}"  enctype="multipart/form-data">
                     @csrf
                     <div class="card-body">
                        <div class="row">
                           <div class="col-md-6">
                              <label>Location:</label>
                              <select class="form-control" name="location">
                                    @foreach($locationlist as $row)
                                       <option value="{{$row->city}}" {{old ('location') == $row->city ? 'selected' : ''}}>{{$row->city}}</option>
                                    @endforeach
                              </select>
                           </div>
                        
                           <div class="col-md-6">
                              <label>image:</label>
                              <input type="file" class="form-control @error('image') is-invalid @enderror" name="image">
                                @error('image')
                                  <span class="invalid-feedback" role="alert">
                                       <strong>{{ $message }}</strong>
                                  </span>
                                @enderror
                           
                            <span class="row col-md-12" style="color:red;margin-left:0px;">Upload Size:- Less then 2MB </span>
                            <span class="row col-md-12" style="color:red;margin-left:0px;">Image Format:- jpeg,jpg,png allowed</span>
                            <span class="row col-md-12" style="color:red;margin-left:0px;">Image Size:-  590 W* 1080 H (PX)</span>
                            </div><br>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                              <label>Coupon Code:</label>
                              <input type="text" class="form-control @error('coupon_code') is-invalid @enderror" name="coupon_code" value="{{ old('coupon_code', isset($basicOrgInfo) ? $basicOrgInfo->coupon_code : '') }}">
                                @error('coupon_code')
                                  <span class="invalid-feedback" role="alert">
                                       <strong>{{ $message }}</strong>
                                  </span>
                                @enderror
                           </div>
                        
                            <div class="col-md-6">
                              <label>Expiry Date:</label>
                              <input type="date" class="form-control @error('expiry_date') is-invalid @enderror" name="expiry_date" value="<?php echo $startdate = (!empty(old('expiry_date')))? old('expiry_date') : ' ' ?>">
                                @error('expiry_date')
                                  <span class="invalid-feedback" role="alert">
                                       <strong>{{ $message }}</strong>
                                  </span>
                                @enderror
                           </div>
                        </div><br>
                        <div class="row">
                            <div class="col-md-6">
                              <label>Discount (In %):</label>
                              <input type="text" class="form-control @error('discount_amount') is-invalid @enderror" name="discount_amount" value="<?php echo $startdate = (!empty(old('discount_amount')))? old('discount_amount') : ' ' ?>">
                                @error('discount_amount')
                                  <span class="invalid-feedback" role="alert">
                                       <strong>{{ $message }}</strong>
                                  </span>
                                @enderror
                           </div>
                        
                               <div class="col-md-6">
                                  <label>Maximum Discount (In Rs):</label>
                                  <input type="number" class="form-control @error('max_discount') is-invalid @enderror" name="max_discount" value="<?php echo $startdate = (!empty(old('max_discount')))? old('max_discount') : ' ' ?>">
                                    @error('max_discount')
                                      <span class="invalid-feedback" role="alert">
                                           <strong>{{ $message }}</strong>
                                      </span>
                                    @enderror
                               </div>
                            </div><br>
                           <div class="row">
                                <div class="col-md-6">
                                   <label>Minimum Subtotal (In Rs):</label>
                                   <input type="number" class="form-control @error('min_subtotal') is-invalid @enderror" name="min_subtotal" value="<?php echo $startdate = (!empty(old('min_subtotal')))? old('min_subtotal') : ' ' ?>">
                                    @error('min_subtotal')
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
@endsection
