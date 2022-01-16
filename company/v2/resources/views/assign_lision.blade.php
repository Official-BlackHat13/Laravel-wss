@extends('layouts.header')
@section('content')
<div class="main-content">
   <div class="section__content section__content--p30">
      <div class="container-fluid">
            @if(Session::has('success'))
                <p style="z-index: 1;" class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('success') }} <i class="fas fa-check-circle"></i></p>
            @endif
         <div class="row">
            <div class="col-lg-6">
               <div class="card">
                  <div class="card-header">Assign Liaison</div>
                  <form method="post" action="{{route('assign')}}"  enctype="multipart/form-data">
                     @csrf
                     <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                              <label>Outlet:</label>
                              <select class="form-control" name="outlet_id">
                                  @foreach($outlet as $row)
                                    <option value="{{$row->id}}">{{$row->outlet_location}},{{$row->city}},{{$row->state}}</option>
                                  @endforeach
                              </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                              <label>Store Admin:</label>
                             <select class="form-control js-example-basic-multiple @error('store_admin') is-invalid @enderror" name="store_admin[]" multiple>
                                @foreach($store as $pins)
                                    <option value="{{$pins->id}}">{{$pins->name}}</option>
                                @endforeach
                              </select>
                              @error('store_admin')
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