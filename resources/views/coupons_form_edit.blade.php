@extends('layouts.header')
@section('content')
<div class="main-content">
   <div class="section__content section__content--p30">
      <div class="container-fluid">
         <div class="row">
            <div class="col-lg-12">
               <div class="card">
                  <div class="card-header">Edit Coupon</div>
                  <form method="post" action="{{route('updatecoupons')}}"  enctype="multipart/form-data">
                     @csrf
                     <div class="card-body">
                        <div class="row">
                           <div class="col-md-6">
                              <label>Coupon Code:</label>
                              <input type="text" class="form-control" name="coupon_code" value="{{$editcoupons->coupon_code}}">
                              <input type="hidden" class="form-control m-input" name="id" value="{{$editcoupons->id}}">
                           </div>
                        
                           <div class="col-md-6">
                              <label>Expiry Date:</label>
                              <input type="date" class="form-control" name="expiry_date" value="{{$editcoupons->expiry_date}}">
                           </div>
                        </div>
                        <br>
                        <div class="row">
                           <div class="col-md-6">
                              <label>Discount Type:</label>
                              <select class="form-control" name="discount_type">
                                    <option value="%" <?php if($editcoupons->discount_type == '%'){echo 'selected';} ?>>In %</option>
                                    <option value="Fixed" <?php if($editcoupons->discount_type == 'Fixed'){echo 'selected';} ?>>Fixed Amount</option>
                              </select>
                           </div>
                        
                           <div class="col-md-6">
                              <label>Discount Amount:</label>
                              <input type="text" class="form-control" name="discount_amount" value="{{$editcoupons->discount_amount}}">
                           </div>
                        </div>
                        <br>
                        <div class="row">
                           <div class="col-md-6">
                              <label>Maximum Discount:</label>
                              <input type="number" class="form-control" name="max_discount" value="{{$editcoupons->max_discount}}">
                           </div>
                        
                           <div class="col-md-6">
                              <label>Minimum Subtotal:</label>
                               <input type="number" class="form-control" name="min_subtotal" value="{{$editcoupons->min_subtotal}}">
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