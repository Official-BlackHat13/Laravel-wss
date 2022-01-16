<!doctype html>
<html>
   <head>
      <meta charset="utf-8">
      <title>Bmonger Invoice</title>
      <style>
         .invoice-box {
         max-width: 1000px;
         margin: auto;
         padding: 30px;
         border: 1px solid #eee;
         box-shadow: 0 0 10px rgba(0, 0, 0, .15);
         font-size: 14px;
         line-height: 24px;
         font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
         color: #000;
         }
         .invoice-box table {
         width: 100%;
         line-height: inherit;
         text-align: left;
         }
         .invoice-box table td {
         padding: 5px;
         vertical-align: top;
         }
         .invoice-box table tr.top table td {
         padding-bottom: 20px;
         }
         .invoice-box table tr.top table td.title {
         text-align: right;
         color: #333;
         padding: 0;
         }
         .invoice-box table tr.top table td.title .order-title{
         margin :0;
         } 
         .invoice-box table tr.information table td {
         padding-bottom: 40px;
         }
         .invoice-box table tr.heading td {
         background: #eee;
         border-bottom: 1px solid #ddd;
         font-weight: bold;
         }
         .invoice-box table tr.details td {
         padding-bottom: 20px;
         }
         .invoice-box table tr.item td{
         border-bottom: 1px solid #eee;
         }
         .invoice-box table tr.item.last td {
         border-bottom: none;
         }
         .invoice-box .user-detil-table table tr td:nth-child(2) {
         text-align: right;
         }
         .invoice-box .logo-detil-table table tr td:nth-child(2) {
         text-align: right;
         }
         .note{
         margin: 0;
         font-size: 13px;
         }
         @media only screen and (max-width: 600px) {
         .invoice-box table tr.top table td {
         width: 100%;
         display: block;
         text-align: center;
         }
         .invoice-box table tr.information table td {
         width: 100%;
         display: block;
         text-align: center;
         }
         }
         /** RTL **/
         .rtl {
         direction: rtl;
         font-family: Tahoma, "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
         }
         .rtl table {
         text-align: right;
         }
         .rtl table tr td:nth-child(2) {
         text-align: left;
         }
         a {
         margin-right: 10px;
         text-decoration: none;
         }
         tr.total td {
         padding: 6px 10px 10px !important;
         text-align: right;
         font-size: 14px;
         font-weight: bold;
         }
         .total{
         /*border-bottom: 1px solid #eee;*/
         margin-bottom: 30px;
         }
         .information.footer tr:nth-child(2){
         text-align: left;
         font-size: 14px;
         }
         .user-detil-table{
         margin-bottom: 5px;
         }
         .user-detil-table p {
         margin: 0;
         font-size: 13px;
         line-height: 18px;
         }
         .logo-detil-table{
         margin-bottom: 30px;
         }
         .order-title span {
         position: relative;
         font-size: 24px;
         }
         .order-title span:after {
         content: "";
         background: #cf2031;
         width: 38%;
         height: 2px;
         display: block;
         position: absolute;
         left: -6px;
         top: 28px;
         }
         .logo-detil-table p {
         font-size: 13px;
         line-height: 18px;
         margin: 0;
         }
         .addr-detil-table {
         margin-bottom: 30px;
         }
         .addr-detil-table p {
         font-size: 13px;
         line-height: 18px;
         margin: 0;
         }
      </style>
   </head>
   <body>
      <div class="invoice-box">
         <div class="logo-detil-table">
            <table cellpadding="0" cellspacing="0">
               <tr>
                  <td colspan="2">
                     <p>Bmongers ventures solutions,<br>
                        No.108/38(8), 3rd Cross, 1st Main,<br>
                        Lakshmamma Layout, Bangalore,<br>
                        Karnataka <br>
                        Email: info@bmonger.com
                     </p>
                  </td>
                  <td>
                     <h3>BMONGER</h3>
                  </td>
               </tr>
            </table>
         </div>
         <hr>
         <div class="logo-table">
            <table cellpadding="0" cellspacing="0">
               <tr class="top">
                  <td colspan="2">
                     <table>
                        <tr>
                           <td class="title">
                              <h2 class="order-title"><span>Order Details</span></h2>
                           </td>
                        </tr>
                     </table>
                  </td>
               </tr>
            </table>
         </div>
         <div class="addr-detil-table">
            <table cellpadding="0" cellspacing="0">
               <tr>
                  <td>
                     <p>
                        <?php //print_r(json_decode($OrderList));exit; ?>
                        <strong>Billing Address</strong><br>
                        {{$name}}<br>
                        {{$address}}<br>
                        {{$city}} , {{$state}},{{$country}}<br>
                        <abbr title="Email">E:</abbr>  {{$email}}<br>
                        <abbr title="Phone">P:</abbr>  {{$phone}}
                  </td>
               </tr>
            </table>
         </div>
         <div class="user-detil-table">
            <table cellpadding="0" cellspacing="0">
               <tr>
                  <td>
                     <p>
                        Order Number : {{$order_id}}
                     </p>
                  </td>
                  <td style="text-align: right;">
                     <p>
                        Order Date: <?php echo date('Y-m-d'); ?>
                     </p>
                  </td>
               </tr>
            </table>
         </div>
         <table cellpadding="0" cellspacing="0">
            <tr class="heading">
               <td>Sl. no</td>
               <td>Product</td>
               <td>Qty</td>
               <td>Price</td>
               <td>CGST</td>
               <td>SGST</td>
               <td>IGST</td>
               <td>Total Price</td>
            </tr>
            <?php
                $OrderDetails=DB::table('transactions')
                            ->select('transactions.*','product.product_name','product.gst_type','gst_amount')
                           ->leftjoin('product','product.id','transactions.product_id')
                           ->where('transactions.order_id','=',$order_id)
                           ->get();      
               $i = 1;
               ?>
            @foreach($OrderDetails as  $val)
            <tr class="item">
               <td>{{$i}}</td>
               <td>{{$val->product_name}} </td>
               <td>{{$val->qty}}</td>
               <td>₹  {{$val->product_amount}}</td>
               <?php
                  if(!empty($val->gst_type)){
                      if($val->gst_type == '%'){
                          $TotalGst = ($val->qty)*( $val->product_amount * $val->gst_amount/100 );
                      }elseif($val->gst_type == 'Fixed'){
                          $TotalGst =  ($val->qty)*($val->gst_amount);
                      }elseif($val->gst_type == ' '){
                          $TotalGst=0;
                      }
                  }
                  else{
                      $TotalGst=0;
                  }
                  
                  if($state = 'karnataka'){
                      $cgst = ($TotalGst/2);
                      $sgst = ($TotalGst/2);
                      $igst = 0;
                  }else{ 
                      $igst = ($TotalGst);
                      $cgst = 0;
                      $sgst = 0;
                  }?>
               <td>₹ <?php if($cgst !=''){ echo $cgst;?>
                    
                                   <?php
               } else{ echo 0;} 
                                        ?> 
               </td>
               <td>₹ <?php if($sgst !=''){ echo $sgst; ?>
               
                                   <?php
               } else{ echo 0;} 
                                        ?> 
               </td>
               <td>₹ <?php if($igst !=''){ echo $igst; ?>
              
                                   <?php
               } else{ echo 0;} ?> 
               </td>
               <td>₹ {{$val->product_amount * $val->qty + $TotalGst}}</td>
            </tr>
            <?php
               $i++;
               ?>
            @endforeach
         </table>
         <table class="information footer">
            <tr class="total">
               <td>
                  <?php
                     
                if($state  = 'karnataka') { ?>
                  <span>CGST: ₹ <?php if(!empty($tax_amount)){  echo $tax_amount/2; } else{ echo 0;}?></span> <br>
                  <span>SGST: ₹ <?php if(!empty($tax_amount)){  echo $tax_amount/2; }else{ echo 0;}?></span> <br>
                  <span>IGST: ₹ <?php  echo 0 ; ?></span> <br>
                  <?php  }else{ ?>
                  <span>CGST: ₹ <?php  echo 0; ?></span> <br>
                  <span>SGST: ₹ <?php  echo 0; ?></span> <br>
                  <span>IGST: ₹ <?php if(!empty($tax_amount)){  echo $tax_amount; }else{ echo 0;}?></span> <br>
                  <?php  } ?>
                  <span>Total GST: ₹ <?php if(!empty($tax_amount)){  echo $tax_amount; }else{ echo 0;}?></span> <br>
                  <span>Delivery Charges: ₹ <?php if(!empty($delivery_amount)){  echo $delivery_amount; }else{ echo 0;}?></span> <br>
                  <span>Total Amount: ₹ {{$total_amount}}</span> <br>
               </td>
            </tr>
         </table>
      </div>
   </body>
</html>