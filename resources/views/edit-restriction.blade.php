@extends('layouts.header')
@section('content')
<div class="main-content">
   <div class="section__content section__content--p30">
      <div class="container-fluid">
         <div class="row">
            <div class="col-lg-6">
               <div class="card">
                  <div class="card-header">Edit Restriction</div>
                  <form method="post" action="{{route('update-restriction')}}"  enctype="multipart/form-data">
                    @csrf
                     <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                              <label>Sub Category:</label>
                              <input type="hidden" name="id" value="{{$edituser->id}}">
                              <select class="form-control" name="subcategory_id">
                                @foreach($users2 as $coun)
                                    <option value="{{$coun->id}}" <?php if($edituser->subcategory_id==$coun->id){echo 'selected';} ?>>{{$coun->name}}</option>
                                @endforeach
                              </select>
                                
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                              <label>Specification:</label>
                              <select class="form-control js-example-basic-multiple @error('specification') is-invalid @enderror" name="specification[]" multiple>
                                @foreach($users1 as $usr)
                                    <option value="{{$usr->name}}">{{$usr->name}}</option>
                                @endforeach
                              </select>
                              @error('specification')
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