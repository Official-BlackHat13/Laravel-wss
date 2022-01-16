@extends('layouts.header')
@section('content')
<div class="main-content">
   <div class="section__content section__content--p30">
      <div class="container-fluid">
         <div class="row">
            <div class="col-lg-12">
               <div class="card">
                  <div class="card-header">Edit Brand Admin</div>
                  <form method="post" action="{{route('update-brand-admin')}}"  enctype="multipart/form-data">
                     @csrf
                     <div class="card-body">
                        <div class="row">
                           <div class="col-md-6">
                              <label>Name:</label>
                              <input type="hidden" class="form-control m-input" name="id" value="{{$edituser->id}}">
                              <input type="text" class="form-control" name="name" value="{{$edituser->name}}">
                           </div>
                        
                           <div class="col-md-6">
                              <label>Email:</label>
                              <input type="text" class="form-control" name="email" value="{{$edituser->email}}">
                           </div>
                        </div>
                        <br>
                        <div class="row">
                           <div class="col-md-6">
                              <label>Mobile:</label>
                              <input type="number" class="form-control" name="phone" value="{{$edituser->phone}}">
                           </div>
                        
                           <div class="col-md-6">
                              <label>Age:</label>
                              <input type="text" class="form-control" name="age" value="{{$edituser->age}}">
                           </div>
                        </div>
                        <br>
                        <div class="row">
                           <div class="col-md-6">
                               <label>Gender:</label>
                              <select class="form-control" name="gender">
                                    <option value="M" <?php if($edituser->gender == 'M'){echo 'selected';} ?>>Male</option>
                                    <option value="F" <?php if($edituser->gender == 'F'){echo 'selected';} ?>>Female</option>
                              </select>
                           </div>
                           <div class="col-md-6">
                              <label>State:</label>
                              <input type="text" class="form-control" name="state" value="{{$edituser->state}}">
                           </div>
                        </div>
                        <br>
                        <div class="row">
                           <div class="col-md-6">
                               <label>City:</label>
                              <select class="form-control" name="city">
                                @foreach($city as $cities)
                                    <option value="{{$cities->city}}" <?php if($edituser->city == $cities->city){echo 'selected';} ?>>{{$cities->city}}</option>
                                @endforeach
                              </select>
                           </div>
                           <div class="col-md-6">
                              <label>Pincode Managed:</label>
                             <select class="form-control js-example-basic-multiple" name="pincode[]" multiple>
                                @foreach($dis_explodes as $dis)             
                                    <option value="{{$dis}}" selected>{{$dis}}</option>
                                @endforeach
                                @foreach($pin as $pins)
                                    <option value="{{$pins->pincode}}">{{$pins->pincode}}</option>
                                @endforeach
                              </select>
                           </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                              <label>Position:</label>
                              <input type="text" name="position" class="form-control" value="{{$edituser->position}}">
                            </div>
                            <!--<div class="col-md-6">-->
                            <!--  <label>Password:</label>-->
                            <!--  <input type="password" name="password" class="form-control" value="{{$edituser->password}}" disabled>-->
                            <!--</div>-->
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