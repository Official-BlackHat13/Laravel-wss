@extends('layouts.header')
@section('content')
<div class="main-content">
   <div class="section__content section__content--p30">
      <div class="container-fluid">
         <div class="row">
             
            <div class="col-lg-12">
               <div class="card">
                  <div class="card-header">Sales Performance</div>
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
                            <label>Total Sales : </label>&nbsp;&nbsp;<input class="sales" readonly value=""><br>
                            <label>Total No of Bills : </label>&nbsp;&nbsp;<input class="bills" readonly value=""> <br>
                            <label>Total No. of Customers: </label>&nbsp;&nbsp;<input class="customers" readonly value=""> <br>
                            <label>Total Exchange: </label>&nbsp;&nbsp;<input class="exchange" readonly value=""> <br>
                            <label>Total Return : </label>&nbsp;&nbsp;<input class="return" readonly value=""> 
                        </div>
                    </div>
                </div>        
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h4>View Sales</h4>
                </div>
            </div><br>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table id="example" class="table table-bordered table-striped table-responsive">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Customer Name</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>Items</th>
                                        <th>Offer</th>
                                        <th>Price</th>
                                        <th>Order Status</th>
                                        <th>Review</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
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
url:"{{url('get-sales-by-admin')}}",
type: "POST",
data: {
admin_id: admin_id,outlet_id:outlet_id,
_token: '{{csrf_token()}}' 
},
dataType : 'json',
success: function(data){
    var str = JSON.stringify(data)
    $(".sales").val(data.video);
    $(".bills").val(data.audio);
    $(".customers").val(data.rating);
    $(".exchange").val(data.points);
    $(".return").val(data.user);
}
});
});
});
</script>
@endsection