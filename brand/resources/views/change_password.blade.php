@extends('layouts.header')
@section('content')
<div class="main-content">
   <div class="section__content section__content--p30">
            @if(Session::has('failed'))
                <p style="z-index: 1;" class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{ Session::get('failed') }} <i class="fas fa-check-circle"></i></p>
            @endif
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card" style="margin-top: 1rem;">
                <div class="card-header">Change Password</div>
                <form method="post" action="{{route('changepassword')}}"  enctype="multipart/form-data">
                @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Old Password</label>
                                <input type="hidden" class="form-control m-input " name="userid" value="{{Auth::user()->id}}">
                                <input type="password" placeholder="Enter old password" class="form-control @error('password') is-invalid @enderror" name="password" value="<?php echo $startdate = (!empty(old('password')))?old('password'):'' ?>">
                                @error('password')
                                  <span class="invalid-feedback" role="alert">
                                       <strong>{{ $message }}</strong>
                                  </span>
                                @enderror
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-md-6">
                                <label>New Password</label>
                                <input type="password" placeholder="Enter new password" class="form-control @error('new_password') is-invalid @enderror" name="new_password">
                                @error('new_password')
                                  <span class="invalid-feedback" role="alert">
                                       <strong>{{ $message }}</strong>
                                  </span>
                                @enderror
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Confirm Password</label>
                                <input type="password" placeholder="Confirm new password" class="form-control @error('confirm_password') is-invalid @enderror" name="confirm_password">
                                @error('confirm_password')
                                  <span class="invalid-feedback" role="alert">
                                       <strong>{{ $message }}</strong>
                                  </span>
                                @enderror
                            </div>
                        </div><br>
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
    </section>
  </div>
@endsection
