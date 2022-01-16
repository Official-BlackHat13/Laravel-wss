@extends('layouts.header')
@section('content')
<div class="main-content">
   <div class="section__content section__content--p30">
      <div class="container-fluid">
         <div class="row">
            <div class="col-lg-6">
               <div class="card">
                  <div class="card-header">Edit Specification</div>
                  <form method="post" action="{{route('update-specifications')}}"  enctype="multipart/form-data">
                     @csrf
                     <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                              <label>Name:</label>
                              <input type="hidden" name="id" value="{{$spec->id}}">
                              <input type="text" placholder="Eg: Shape" class="form-control" name="name" value="{{ $spec->name }}">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                              <label>Keyword:</label>
                              <input type="text" placeholder="Eg: Oval,Round" class="form-control" name="keyword" value="{{$spec->value }}">
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