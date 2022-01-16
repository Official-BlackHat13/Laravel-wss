<?php $gst = str_replace('/public','',url('/uploads/')); ?>
@extends('layouts.header')
@section('content')
<div class="main-content">
   <div class="section__content section__content--p30">
      <div class="container-fluid">
         <div class="row">
            <div class="col-lg-6">
               <div class="card">
                  <div class="card-header">Edit Sub Category</div>
                  <form method="post" action="{{route('update-sub-category')}}"  enctype="multipart/form-data">
                     @csrf
                     <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                              <label>Category:</label>
                              <select class="form-control" name="category_id">
                                  @foreach($cat as $row)
                                    <option value="{{$row->id}}" <?php if($subcat->category_id == $row->id){echo 'selected';} ?>>{{$row->name}}</option>
                                  @endforeach
                              </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                           <div class="col-md-12">
                              <label>Name:</label>
                              <input type="hidden" name="id" value="{{$subcat->id}}">
                              <input type="text" class="form-control" name="name" value="{{$subcat->name}}">
                           </div>
                        </div>
                        <br>
                        <!--<div class="row">-->
                        <!--   <div class="col-md-12">-->
                        <!--      <label>Icon:</label>-->
                        <!--      <input type="file" class="form-control" name="image" >-->
                        <!--      <br>-->
                        <!--      <img src="{{$gst}}/{{ $subcat->image }}" style="width:100px;height:60px;">-->
                        <!--   </div>-->
                        <!--</div>-->
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