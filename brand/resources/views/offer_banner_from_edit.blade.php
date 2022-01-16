<?php $gst = 'https://bniindiastore.com/bmongers/uploads/' ?>
@extends('layouts.header')
@section('content')
<div class="main-content">
   <div class="section__content section__content--p30">
      <div class="container-fluid">
         <div class="row">
            <div class="col-lg-12">
               <div class="card">
                  <div class="card-header">Edit Offer Banner</div>
                  <form method="post" action="{{route('update-offer-banner')}}"  enctype="multipart/form-data">
                     @csrf
                     <div class="card-body">
                        <div class="row">
                           <div class="col-md-6">
                              <label>Location:</label>
                              <select class="form-control" name="location">
                                  <?php //print_r($locationlist);exit; ?>
                                    @foreach($locationlist as $row)
                                       <option value="{{$row->city}}" <?php if($row->city==$editbanner->location){echo 'selected';} ?>>{{$row->city}}</option>
                                    @endforeach
                              </select>
                           </div>
                        
                           <div class="col-md-6">
                              <label>image:</label>
                              <input type="file" class="form-control" name="image">
                               <br>
                              <img src="{{$gst}}/{{ $editbanner->image }}" style="width:100px;height:60px;">
                           </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                              <label>Coupon Code:</label>
                              <input type="text" class="form-control" name="coupon_code" value="{{$editbanner->coupon_code}}">
                                
                           </div>
                        
                            <div class="col-md-6">
                              <label>Expiry Date:</label>
                              <input type="date" class="form-control" name="expiry_date" value="{{$editbanner->expiry_date}}">
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
                              <input type="text" class="form-control" name="discount_amount" value="{{$editbanner->discount}}">
                                @error('discount_amount')
                                  <span class="invalid-feedback" role="alert">
                                       <strong>{{ $message }}</strong>
                                  </span>
                                @enderror
                           </div>
                        
                               <div class="col-md-6">
                                  <label>Maximum Discount (In Rs):</label>
                                  <input type="number" class="form-control" name="max_discount" value="{{$editbanner->max_discount}}">
                                    @error('max_discount')
                                      <span class="invalid-feedback" role="alert">
                                           <strong>{{ $message }}</strong>
                                      </span>
                                    @enderror
                               </div>
                            </div><br>
                           <div class="row">
                                <div class="col-md-12">
                                   <label>Minimum Subtotal (In Rs):</label>
                                   <input type="number" class="form-control" name="min_subtotal" value="{{$editbanner->min_subtotal}}">
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