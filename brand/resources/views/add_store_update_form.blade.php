@extends('layouts.header')
@section('content')
<div class="main-content">
   <div class="section__content section__content--p30">
      <div class="container-fluid">
         <div class="row">
            <div class="col-lg-12">
               <div class="card">
                  <div class="card-header">Add Store Updates</div>
                  <form method="post" action="{{route('postdtstup')}}"  enctype="multipart/form-data">
                     @csrf
                     <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                              <label>Store:</label>
                              <select class="form-control js-example-basic-multiple" name="store_admin_id">
                                @foreach($store as $stores)
                                    <option value="{{$stores->store_admin_id}}">{{$stores->store_admin_id}}</option>
                                @endforeach
                              </select>
                            </div>
                            <div class="col-md-6">
                              <label>Title:</label>
                              <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="<?php echo $startdate = (!empty(old('title')))? old('title') : ' ' ?>">
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
                              <textarea type="text" class="form-control @error('update_description') is-invalid @enderror" name="update_description"><?php echo $startdate = (!empty(old('update_description')))? old('update_description') : ' ' ?></textarea>
                              @error('update_description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                           </div>
                        </div><br>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Image:</label>
                                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                                @error('image')
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