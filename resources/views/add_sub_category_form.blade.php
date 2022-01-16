@extends('layouts.header')
@section('content')
<div class="main-content">
   <div class="section__content section__content--p30">
      <div class="container-fluid">
         <div class="row">
            <div class="col-lg-6">
               <div class="card">
                  <div class="card-header">Add Sub Category</div>
                  <form method="post" action="{{route('postdtsubcat')}}"  enctype="multipart/form-data">
                     @csrf
                     <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                              <label>Category:</label>
                              <select class="form-control" name="category_id">
                                  @foreach($cat as $row)
                                    <option value="{{$row->id}}" {{old ('super_cat_id') == $row->id ? 'selected' : ''}}>{{$row->name}}</option>
                                  @endforeach
                              </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                              <label>Name:</label>
                              <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', isset($basicOrgInfo) ? $basicOrgInfo->name : '') }}">
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
                              <label>Icon:</label>
                              <input type="file" class="form-control @error('image') is-invalid @enderror" name="image">
                                @error('image')
                                  <span class="invalid-feedback" role="alert">
                                       <strong>{{ $message }}</strong>
                                  </span>
                                @enderror
                                <span class="row col-md-12" style="color:red;">Upload Size:- Less Then 1MB </span>
                                <span class="row col-md-12" style="color:red;">Image Format:- jpeg,jpg,png allowed</span>
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