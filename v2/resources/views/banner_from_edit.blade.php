<?php $gst = str_replace('/public','',url('/uploads/')); ?>
@extends('layouts.header')
@section('content')
<div class="main-content">
   <div class="section__content section__content--p30">
      <div class="container-fluid">
         <div class="row">
            <div class="col-lg-6">
               <div class="card">
                  <div class="card-header">Edit Banner</div>
                  <form method="post" action="{{route('updatebanner')}}"  enctype="multipart/form-data">
                     @csrf
                     <div class="card-body">
                        <div class="row">
                           <div class="col-md-12">
                              <label>image:</label>
                              <input type="hidden" name="id" value="{{$editbanner->id}}">
                              <input type="file" class="form-control" name="image" >
                              <br>
                              <img src="{{$gst}}/{{ $editbanner->image }}" style="width:100px;height:60px;">
                           </div>
                        </div>
                        <br>
                        <div class="row">
                           <div class="col-md-12">
                              <label>Location:</label>
                              <select class="form-control" name="location">
                                    @foreach($locationlist as $row)
                                       <option value="{{$row->city}}" <?php if($editbanner->location == $row->city){echo 'selected';} ?> >{{$row->city}}</option>
                                    @endforeach
                              </select>
                           </div>
                        </div>
                        <br>
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