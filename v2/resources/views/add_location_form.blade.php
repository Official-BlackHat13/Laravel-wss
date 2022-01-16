@extends('layouts.header')
@section('content')
<div class="main-content">
   <div class="section__content section__content--p30">
      <div class="container-fluid">
         <div class="row">
            <div class="col-lg-6">
               <div class="card">
                  <div class="card-header">Add Location</div>
                  <form method="post" action="{{route('postdtlocation')}}"  enctype="multipart/form-data">
                     @csrf
                     <div class="card-body">
                        <div class="row">
                           <div class="col-md-12">
                              <label>State:</label>
                              <select type="text" class="form-control state-dropdown @error('state') is-invalid @enderror" name="state">
                                @foreach($state as $states)
                                    <option value="{{$states->name}}" data-id="{{$states->id}}" {{old ('state') == $states->name ? 'selected' : ''}}>{{$states->name}}</option>
                                @endforeach
                              </select>
                                @error('state')
                                  <span class="invalid-feedback" role="alert">
                                       <strong>{{ $message }}</strong>
                                  </span>
                                @enderror
                           </div>
                        </div>
                        <br>
                        <div class="row">
                           <div class="col-md-12">
                                <label>City:</label>
                                <input type="text"  class="form-control city-dropdown @error('city') is-invalid @enderror" name="city" value="{{ old('city', isset($basicOrgInfo) ? $basicOrgInfo->city : '') }}">
                                @error('city')
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
@section('script')
<!--<script>-->
<!--$(document).ready(function() {-->
<!--$('.state-dropdown').on('change', function() {-->
<!--var state_id = $(this).find(':selected').data('id');-->
// alert(state_id);
<!--$(".city-dropdown").html('');-->
<!--$.ajax({-->
<!--url:"{{url('get-cities-by-state1')}}",-->
<!--type: "POST",-->
<!--data: {-->
<!--state_id: state_id,-->
<!--_token: '{{csrf_token()}}' -->
<!--},-->
<!--dataType : 'json',-->
<!--success: function(result){-->
<!--$('.city-dropdown').html('<option value="">Select City</option>'); -->
<!--$.each(result.cities,function(key,value){-->
<!--$(".city-dropdown").append('<option value="'+value.name+'">'+value.name+'</option>');-->
<!--});-->
<!--}-->
<!--});-->
<!--});-->
<!--});-->
<!--</script>-->
@endsection