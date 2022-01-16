@extends('layouts.header')
@section('content')
<div class="main-content">
   <div class="section__content section__content--p30">
      <div class="container-fluid">
         <div class="row">
            <div class="col-lg-6">
               <div class="card">
                  <div class="card-header">Add Offer Banner</div>
                  <form method="post" action="{{route('postdtob')}}"  enctype="multipart/form-data">
                     @csrf
                     <div class="card-body">
                        <div class="row">
                           <div class="col-md-12">
                              <label>Location:</label>
                              <select class="form-control" name="location">
                                  <?php //print_r($locationlist);exit; ?>
                                    @foreach($locationlist as $row)
                                       <option value="{{$row->city}}" {{old ('location') == $row->city ? 'selected' : ''}}>{{$row->city}}</option>
                                    @endforeach
                              </select>
                           </div>
                        </div>
                        <br> 
                        <div class="row">
                           <div class="col-md-12">
                              <label>image:</label>
                              <input type="file" class="form-control @error('image') is-invalid @enderror" name="image">
                                @error('image')
                                  <span class="invalid-feedback" role="alert">
                                       <strong>{{ $message }}</strong>
                                  </span>
                                @enderror
                           </div><br>
                            <span class="row col-md-12" style="color:red;margin-left:0px;">Upload Size:- Less then 2MB </span><br>
                            <span class="row col-md-12" style="color:red;margin-left:0px;">Image Format:- jpeg,jpg,png allowed</span><br>
                            <span class="row col-md-12" style="color:red;margin-left:0px;">Image Size:-  590 W* 1080 H (PX)</span>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                              <label>Coupon Code:</label>
                              <input type="text" class="form-control @error('coupon_code') is-invalid @enderror" name="coupon_code" value="{{ old('coupon_code', isset($basicOrgInfo) ? $basicOrgInfo->coupon_code : '') }}">
                                @error('coupon_code')
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
