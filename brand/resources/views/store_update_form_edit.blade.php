<?php $gst = str_replace('/public','',url('/uploads/')); ?>
@extends('layouts.header')
@section('content')
<div class="main-content">
   <div class="section__content section__content--p30">
      <div class="container-fluid">
         <div class="row">
            <div class="col-lg-12">
               <div class="card">
                  <div class="card-header">Add Store Updates</div>
                  <form method="post" action="{{route('update-stup')}}"  enctype="multipart/form-data">
                     @csrf
                     <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                              <label>Store:</label>
                               <input type="hidden" class="form-control" name="id" value="{{$edituser->id}}">
                              <select class="form-control js-example-basic-multiple" name="store_admin_id">
                                @foreach($store as $stores)
                                    <option value="{{$stores->store_admin_id}}" <?php if($edituser->store_admin_id==$stores->store_admin_id){echo 'selected';} ?>>{{$stores->store_admin_id}}</option>
                                @endforeach
                              </select>
                            </div>
                            <div class="col-md-6">
                              <label>Title:</label>
                              <input type="text" class="form-control" name="title" value="{{$edituser->title}}">
                              @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div><br>
                        <div class="row">
                           <div class="col-md-12">
                              <label>Description:</label>
                              <textarea type="text" class="form-control" name="update_description">{{$edituser->description}}</textarea>
                           </div>
                        </div><br>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Image:</label>
                                <input type="file" name="image" class="form-control">
                                <br>
                                <img src="{{$gst}}/{{ $edituser->image }}" style="width:100px;height:60px;">
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