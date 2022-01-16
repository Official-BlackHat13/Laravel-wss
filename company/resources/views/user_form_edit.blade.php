@extends('layouts.header')
@section('content')
<div class="main-content">
   <div class="section__content section__content--p30">
      <div class="container-fluid">
         <div class="row">
            <div class="col-lg-12">
               <div class="card">
                  <div class="card-header">Edit User</div>
                  <form method="post" action="{{route('update-user')}}"  enctype="multipart/form-data">
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
                              <input type="number" class="form-control" name="mobile" value="{{$edituser->mobile}}">
                           </div>
                        
                           <div class="col-md-6">
                              <label>Company Name:</label>
                              <input type="text" class="form-control" name="company_name" value="{{$edituser->company_name}}">
                           </div>
                        </div>
                        <br>
                        <div class="row">
                           <div class="col-md-6">
                              <label>Age:</label>
                              <input type="number" class="form-control" name="age" value="{{$edituser->age}}">
                           </div>
                        
                           <div class="col-md-6">
                               <label>Gender:</label>
                              <select class="form-control" name="gender">
                                    <option value="male" <?php if($edituser->gender == 'male'){echo 'selected';} ?>>Male</option>
                                    <option value="female" <?php if($edituser->gender == 'female'){echo 'selected';} ?>>Female</option>
                              </select>
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