@extends('layouts.header')
@section('content')
<div class="main-content">
   <div class="section__content section__content--p30">
      <div class="container-fluid">
         <div class="row">
            <div class="col-lg-6">
               <div class="card">
                  <div class="card-header">Add Specification</div>
                  <form method="post" action="{{route('postdtsp')}}"  enctype="multipart/form-data">
                    @csrf
                     <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                              <label>Name:</label>
                              <input type="text" placeholder="Shape" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', isset($basicOrgInfo) ? $basicOrgInfo->name : '') }}">
                                @error('name')
                                  <span class="invalid-feedback" role="alert">
                                       <strong>{{ $message }}</strong>
                                  </span>
                                @enderror
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                              <label>Keyword:</label>
                              <input type="text" placeholder="Oval,Round" class="form-control @error('keyword') is-invalid @enderror" name="keyword" value="{{ old('keyword', isset($basicOrgInfo) ? $basicOrgInfo->keyword : '') }}">
                                @error('keyword')
                                  <span class="invalid-feedback" role="alert">
                                       <strong>{{ $message }}</strong>
                                  </span>
                                @enderror
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