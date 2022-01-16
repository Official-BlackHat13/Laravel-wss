<?php $gst = str_replace('/public','',url('/uploads/')); ?>
@extends('layouts.header')
@section('content')
<style>
    .razorpay-payment-button:hover{
        color: #fff;
        background-color: #0069d9;
        border-color: #0062cc;
    }
    .razorpay-payment-button{
        background-color: #0069d9 !important;
        border-color: #0062cc;
        color:#fff !important;
        margin-top:35px;
        display: inline-block;
        font-weight: 400;
        color: #212529;
        text-align: center;
        vertical-align: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        background-color: transparent;
        border: 1px solid transparent;
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        line-height: 1.5;
        border-radius: 0.25rem;
        transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
</style>
<div class="main-content">
   <div class="section__content section__content--p30">
      <div class="container-fluid">
         <div class="row">
            <div class="col-lg-12">
               <div class="card">
                  <div class="card-header">Commercials</div>
                     <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                              <label>Prepiad Video Minutes: <?php if($company->video_minutes<=0){ ?><i class="fa fa-flag" aria-hidden="true" title="Your prepiad video minutes is low" style="color: red;"></i> <?php } ?></label>
                              <input type="hidden" name="id" value="{{$company->company_id}}">
                              <input type="text" class="form-control"  name="name" readonly value="{{$company->video_minutes}}">
                            </div>
                            <div class="col-md-4">
                                <label style="display:none;">Prepiad Video Minutes Available:</label>
                              <!--<button type="submit" class="btn btn-primary">Buy Now</button>-->
                              <form action="{{ route('payment') }}" method="POST" >
                                    @csrf
                                    <script src="https://checkout.razorpay.com/v1/checkout.js"
                                            data-key="{{ env('RAZORPAY_KEY') }}"
                                            data-amount="1000"
                                            data-buttontext="Buy Now"
                                            data-name="Bmonger"
                                            data-description="Rozerpay"
                                            data-prefill.name="name"
                                            data-prefill.email="email"
                                            data-theme.color="#ff7529">
                                    </script>
                                </form>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-8">
                              <label>Prepiad Audio Minutes Available:<?php if($company->audio_minutes<=0){ ?><i class="fa fa-flag" aria-hidden="true" title="Your prepiad audio minutes is low" style="color: red;"></i> <?php } ?></label>
                              <input type="hidden" name="id" value="{{$company->company_id}}">
                              <input type="text" class="form-control"  name="name" readonly value="{{$company->audio_minutes}}">
                            </div>
                            <div class="col-md-4">
                               <label style="display:none;">Prepiad Video Minutes Available:</label>
                              <!--<button class="btn btn-primary">Buy Now</button>-->
                              <form action="{{ route('payment') }}" method="POST" >
                                    @csrf
                                    <script src="https://checkout.razorpay.com/v1/checkout.js"
                                            data-key="{{ env('RAZORPAY_KEY') }}"
                                            data-amount="1000"
                                            data-buttontext="Buy Now"
                                            data-name="Bmonger"
                                            data-description="Rozerpay"
                                            data-prefill.name="name"
                                            data-prefill.email="email"
                                            data-theme.color="#ff7529">
                                    </script>
                                </form>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                              <label>Click Count (Audio):</label>
                              <input type="text" class="form-control"  name="name" readonly value="{{$users1->quickshopcount/$company->quick_click}}">
                              <span style="color:red;">₹ {{$company->quick_shop}} Per Click</span>
                            </div>
                            <div class="col-md-6">
                               <label>Click Count (Video):</label>
                               <input type="text" class="form-control"  name="name" readonly value="{{$users1->liveshopcount/$company->online_click}}">
                               <span style="color:red;">₹ {{$company->online_shop}} Per Click</span>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                                <div class="col-md-8">
                                  <label>Total Pay Per Click Amount</label>
                                  <?php $total=  (($users1->quickshopcount/$company->quick_click)*($company->quick_shop)) + (($users1->liveshopcount/$company->online_click)*($company->online_shop)) ?>
                                  <input type="text" class="form-control"  name="amount" readonly value="{{$total}}">
                                </div>
                                
                                <form action="{{ route('payment') }}" method="POST" >
                                    @csrf
                                    <script src="https://checkout.razorpay.com/v1/checkout.js"
                                            data-key="{{ env('RAZORPAY_KEY') }}"
                                            data-amount="1000"
                                            data-buttontext="Pay"
                                            data-name="Bmonger"
                                            data-description="Rozerpay"
                                            data-prefill.name="name"
                                            data-prefill.email="email"
                                            data-theme.color="#ff7529">
                                    </script>
                                </form>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                              <label>Daily S&M Per Store Price:</label>
                              <input type="text" class="form-control"  name="name" readonly value="xyz">
                            </div>
                            <div class="col-md-6">
                               <label>Total Active Stores:</label>
                               <input type="text" class="form-control"  name="name" readonly value="abc">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-8">
                              <label>Total S&M Price:</label>
                              <?php $total=  ($users1->quickshopcount*$company->quick_shop) + ($users1->liveshopcount*$company->online_shop) ?>
                              <input type="text" class="form-control"  name="name" readonly value="xyz*abc*no of active days">
                            </div>
                            <div class="col-md-4">
                               <label style="display:none;">Total Pay Per Click Amount:</label>
                               <!--<button class="btn btn-primary">Pay Now</button>-->
                               <form action="{{ route('payment') }}" method="POST" >
                                    @csrf
                                    <script src="https://checkout.razorpay.com/v1/checkout.js"
                                            data-key="{{ env('RAZORPAY_KEY') }}"
                                            data-amount="1000"
                                            data-buttontext="Pay"
                                            data-name="Bmonger"
                                            data-description="Rozerpay"
                                            data-prefill.name="name"
                                            data-prefill.email="email"
                                            data-theme.color="#ff7529">
                                    </script>
                                </form>
                            </div>
                        </div>
                     </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection('content')