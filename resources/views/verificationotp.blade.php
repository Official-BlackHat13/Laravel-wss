@section('content')
<style>
    .invoice-box table td {
        padding: 5px;
        vertical-align: top;
        font-size: 11px;
        text-align: left;
    }
    .table thead th {
        vertical-align: bottom;
        border-bottom: 2px solid #dee2e6;
        text-align: left;
    }
    #footerweb{
            display:none !important;
        }
    @media print {
        #app {
            display:none;
        }
        .subcribe-sec{
            display:none;
        }
        #footerweb{
            display:none !important;
        }
        #sidebar{
            display:none;
        }
        #btn{
            display:none;
        }
        #create_pdf{
            display:none;
        }
    }
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
        margin-bottom: 20px;
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
<section class="container-fluid page-body-wrapper">
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="">
    <div id="editor"></div>

                <div class="" id="PDFcontent">
                    <div class="profile-right">
                        <div class="row">
                            <div class="col-lg-6 offset-lg-3">
                                <h4 class="text-center order-title mb-30"><span>Verification OTP</span></h4>
                            </div>
                        </div>
                    
                        <div class="invoice-box" id="DivIdToPrint">

                            <div class="logo-detil-table">
                                <table cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td colspan="2">
                                            {{$p7}}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
