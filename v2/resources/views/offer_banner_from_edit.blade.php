<?php $gst = str_replace('/public','',url('/uploads/')); ?>
@extends('layouts.header')
@section('content')
<div class="main-content">
   <div class="section__content section__content--p30">
      <div class="container-fluid">
         <div class="row">
            <div class="col-lg-6">
               <div class="card">
                  <div class="card-header">Edit Offer Banner</div>
                  <form method="post" action="{{route('update-offer-banner')}}"  enctype="multipart/form-data">
                     @csrf
                     <div class="card-body">
                        <div class="row">
                           <div class="col-md-12">
                              <label>Company:</label>
                              <input type="hidden" name="id" value="{{$editbanner->id}}">
                              <select class="form-control" name="company_id">
                                  <?php //print_r($locationlist);exit; ?>
                                    @foreach($company as $com)
                                       <option value="{{$com->company_id}}" <?php if($com->company_id==$editbanner->company_id){echo 'selected';} ?>>{{$com->name}}</option>
                                    @endforeach
                              </select>
                           </div>
                        </div>
                        <br>
                        <div class="row">
                           <div class="col-md-12">
                              <label>Location:</label>
                              <select class="form-control" name="location">
                                  <?php //print_r($locationlist);exit; ?>
                                    @foreach($locationlist as $row)
                                       <option value="{{$row->city}}" <?php if($row->city==$editbanner->location){echo 'selected';} ?>>{{$row->city}}</option>
                                    @endforeach
                              </select>
                           </div>
                        </div>
                        <br>
                        <div class="row">
                           <div class="col-md-12">
                              <label>image:</label>
                              <input type="file" class="form-control @error('image') is-invalid @enderror" name="image">
                               <br>
                              <img src="{{$gst}}/{{ $editbanner->image }}" style="width:100px;height:60px;">
                           </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                              <label>Coupon Code:</label>
                              <input type="text" class="form-control" name="coupon_code" value={{$editbanner->coupon_code}}>
                                
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