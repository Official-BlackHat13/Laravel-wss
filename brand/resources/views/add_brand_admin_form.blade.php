@extends('layouts.header')
@section('content')
<div class="main-content">
   <div class="section__content section__content--p30">
      <div class="container-fluid">
         <div class="row">
            <div class="col-lg-12">
               <div class="card">
                  <div class="card-header">Add Brand Admin</div>
                  <form method="post" action="{{route('postdtbad')}}"  enctype="multipart/form-data">
                     @csrf
                     <div class="card-body">
                        <div class="row">
                           <div class="col-md-6">
                              <label>Name:</label>
                              <input type="text" class="form-control @error('names') is-invalid @enderror" name="name" value="<?php echo $startdate = (!empty(old('name')))? old('name') : ' ' ?>">
                              @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                           </div>
                        
                           <div class="col-md-6">
                              <label>Email:</label>
                              <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="<?php echo $startdate = (!empty(old('email')))? old('email') : ' ' ?>">
                              @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                           </div>
                        </div>
                        <br>
                        <div class="row">
                           <div class="col-md-6">
                              <label>Mobile:</label>
                              <input type="number" class="form-control @error('phone') is-invalid @enderror" name="phone" value="<?php echo $startdate = (!empty(old('phone')))? old('phone') : ' ' ?>">
                              @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                           </div>
                        
                           <div class="col-md-6">
                              <label>Age:</label>
                              <input type="text" class="form-control @error('age') is-invalid @enderror" name="age" value="<?php echo $startdate = (!empty(old('age')))? old('age') : ' ' ?>">
                              @error('age')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                           </div>
                        </div>
                        <br>
                        <div class="row">
                           <div class="col-md-6">
                               <label>Gender:</label>
                              <select class="form-control" name="gender">
                                    <option value="M">Male</option>
                                    <option value="F">Female</option>
                              </select>
                           </div>
                           <div class="col-md-6">
                              <label>State:</label>
                              <input type="text" class="form-control @error('state') is-invalid @enderror" name="state" value="<?php echo $startdate = (!empty(old('state')))? old('state') : ' ' ?>">
                              @error('state')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                           </div>
                        </div>
                        <br>
                        <div class="row">
                           <div class="col-md-6">
                               <label>City:</label>
                              <select class="form-control" name="city">
                                @foreach($city as $cities)
                                    <option value="{{$cities->city}}">{{$cities->city}}</option>
                                @endforeach
                              </select>
                           </div>
                           <div class="col-md-6">
                              <label>Pincode Managed:</label>
                             <select class="form-control js-example-basic-multiple @error('pincode') is-invalid @enderror" name="pincode[]" multiple>
                                @foreach($pin as $pins)
                                    <option value="{{$pins->pincode}}">{{$pins->pincode}}</option>
                                @endforeach
                              </select>
                              @error('pincode')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                           </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                              <label>Position:</label>
                              <input type="text" name="position" class="form-control @error('position') is-invalid @enderror" value="<?php echo $startdate = (!empty(old('position')))? old('position') : ' ' ?>">
                              @error('position')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                              <label>Password:</label>
                              <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" value="<?php echo $startdate = (!empty(old('password')))? old('password') : ' ' ?>">
                              @error('password')
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