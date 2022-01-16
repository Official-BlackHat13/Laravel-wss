@extends('layouts.header')
@section('content')
<div class="main-content">
   <div class="section__content section__content--p30">
      <div class="container-fluid">
         <div class="row">
             
            <div class="col-lg-12">
               <div class="card">
                  <div class="card-header">User Staff Interactions</div>
                  <form method="post" action="#"  enctype="multipart/form-data">
                     @csrf
                     <div class="card-body">
                        <div class="row">
                           <div class="col-md-6">
                              <label>City:</label>
                              <select class="form-control city-dropdown" name="city">
                                <option value="">Select City</option>
                                @foreach($users1 as $brands)
                                    <option value="{{$brands->city}}">{{$brands->city}}</option>
                                @endforeach
                              </select>
                           </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Store:</label>
                                <select id="" class="form-control store-dropdown" name="store">
                                   
                                </select>
                               
                            </div>
                        </div>
                        <br>
                        <div class="row">
                           <div class="col-md-6">
                               <label>Store Admin:</label>
                                <select  class="form-control store-admin-dropdown" name="admin">
                                   
                                </select>
                                  
                            </div>
                        </div>
                  </form>
               </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label>Video Calls Count : </label>&nbsp;&nbsp;<input class="video_count" readonly value=""><br>
                            <label>Audio Calls Count : </label>&nbsp;&nbsp;<input class="audio_count" readonly value=""> <br>
                            <label>Avg. Rating: </label>&nbsp;&nbsp;<input class="avg_rate" readonly value=""> <br>
                            <label>Points: </label>&nbsp;&nbsp;<input class="points" readonly value=""> <br>
                            <label>Users Engaged Count : </label>&nbsp;&nbsp;<input class="user_count" readonly value=""> <br>
                            <label>Total Sales : </label>&nbsp;&nbsp;<input class="sale" readonly value=""><br>
                            <label>Blocked By User Count : </label>&nbsp;&nbsp;<input class="block" readonly value=""> 
                        </div>
                    </div>
                </div>        
            </div>
         </div>
      </div>
   </div>
</div>
@endsection('content')
@section('script')
<script>
$(document).ready(function() {
$('.city-dropdown').on('change', function() {
var city_id = $(this).val();
// alert(city_id);
$(".store-dropdown").html('');
$.ajax({
url:"{{url('get-stores-by-city')}}",
type: "POST",
data: {
city_id: city_id,
_token: '{{csrf_token()}}' 
},
dataType : 'json',
success: function(result){
$('.store-dropdown').html('<option value="" >Select Store</option>'); 
$.each(result.outlet,function(key,value){
$(".store-dropdown").append('<option value="'+value.id+'">'+value.outlet_location+','+value.city+','+value.state+'</option>');
});
$('.store-admin-dropdown').html('<option value="">Select Store First</option>'); 
}
});
});    
$('.store-dropdown').on('change', function() {
var outlet_id = $(this).val();
$(".store-admin-dropdown").html('');
$.ajax({
url:"{{url('get-admin-by-store')}}",
type: "POST",
data: {
outlet_id: outlet_id,
_token: '{{csrf_token()}}' 
},
dataType : 'json',
success: function(result){
$('.store-admin-dropdown').html('<option value="">Select Store Admin</option>'); 
$.each(result.admin,function(key,value){
$(".store-admin-dropdown").append('<option value="'+value.store_admin_id+'" data-id="'+outlet_id+'">'+value.name+'</option>');
});
}
});
});

$('.store-admin-dropdown').on('change', function() {
var admin_id = $(this).val();
var outlet_id = $(this).find(':selected').data('id');
$.ajax({
url:"{{url('get-data-by-admin')}}",
type: "POST",
data: {
admin_id: admin_id,outlet_id:outlet_id,
_token: '{{csrf_token()}}' 
},
dataType : 'json',
success: function(data){
    var str = JSON.stringify(data)
    $(".video_count").val(data.video);
    $(".audio_count").val(data.audio);
    $(".points").val(data.points);
    $(".user_count").val(data.user);
    $(".sale").val('XYZ');
    $(".block").val(data.block);
    if(data.rating == null){
        $(".avg_rate").val(0);
    }else{
        $(".avg_rate").val(data.rating.toFixed(2));
    }
}
});
});
});
</script>
@endsection