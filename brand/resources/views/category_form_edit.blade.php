<?php $gst = str_replace('/public','',url('/uploads/')); ?>
@extends('layouts.header')
@section('content')
<div class="main-content">
   <div class="section__content section__content--p30">
      <div class="container-fluid">
         <div class="row">
            <div class="col-lg-6">
               <div class="card">
                  <div class="card-header">Edit Category</div>
                  <form method="post" action="{{route('update-category')}}"  enctype="multipart/form-data">
                     @csrf
                     <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                              <label>Super Category:</label>
                              <select class="form-control" name="super_cat_id">
                                  @foreach($scat as $row)
                                    <option value="{{$row->id}}" <?php if($cat->super_category_id == $row->id){echo 'selected';} ?>>{{$row->name}}</option>
                                  @endforeach
                              </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                           <div class="col-md-12">
                              <label>Name:</label>
                              <input type="hidden" name="id" value="{{$cat->id}}">
                              <input type="text" class="form-control" name="name" value="{{$cat->name}}">
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