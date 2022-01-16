<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title>Company Dashboard</title>

    <!-- Fontfaces CSS-->
    <link href="{{ asset('css/font-face.css')}}" rel="stylesheet" media="all">
    <link href="{{ asset('vendor/font-awesome-4.7/css/font-awesome.min.css')}}" rel="stylesheet" media="all">
    <link href="{{ asset('vendor/font-awesome-5/css/fontawesome-all.min.css')}}" rel="stylesheet" media="all">
    <link href="{{ asset('vendor/mdi-font/css/material-design-iconic-font.min.css')}}" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="{{ asset('vendor/bootstrap-4.1/bootstrap.min.css')}}" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="{{ asset('vendor/animsition/animsition.min.css')}}" rel="stylesheet" media="all">
    <link href="{{ asset('vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css')}}" rel="stylesheet" media="all">
    <link href="{{ asset('vendor/wow/animate.css')}}" rel="stylesheet" media="all">
    <link href="{{ asset('vendor/css-hamburgers/hamburgers.min.css')}}" rel="stylesheet" media="all">
    <link href="{{ asset('vendor/slick/slick.css')}}" rel="stylesheet" media="all">
    <link href="{{ asset('vendor/select2/select2.min.css')}}" rel="stylesheet" media="all">
    <link href="{{ asset('vendor/perfect-scrollbar/perfect-scrollbar.css')}}" rel="stylesheet" media="all">
    <link href="{{ asset('vendor/vector-map/jqvmap.min.css')}}" rel="stylesheet" media="all">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css" rel="stylesheet" media="all">
    <link href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css" rel="stylesheet" media="all">
    <!-- Main CSS-->
    <link href="{{ asset('css/theme.css')}}" rel="stylesheet" media="all">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <style>
        th,td{
            white-space:nowrap;
            text-align:center;
        }
        .invalid-feedback{
            display:block !important;
        }
        label{
            font-weight: 600 !important;
        }
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
          -webkit-appearance: none;
          margin: 0;
        }
        
        /* Firefox */
        input[type=number] {
          -moz-appearance: textfield;
        }

        .navbar-sidebar2 .navbar__list li .arrow {
            right: -15px !important;
        }
    </style>
</head>

<body class="animsition">
    <div class="">
        <!-- MENU SIDEBAR-->
        <aside class="menu-sidebar2">
            <div class="logo">
                <a href="#">
                    <!--<img src="{{ asset('images/icon/logo-white.png')}}" alt="Cool Admin" />-->
                    <h3 style="color:#fff;"> COMPANY ADMIN</h3>
                </a>
            </div>
            <div class="menu-sidebar2__content js-scrollbar1">
                <div class="account2">
                    <div class="image img-cir img-120" style="display:none">
                        <img src="{{ asset('images/icon/avatar-big-01.jpg')}}" alt="{{ Auth::user()->name }}" />
                    </div>
                    <h4 class="name">{{ Auth::user()->name }}</h4>
                    <div class="">
                        <a href="{{ route('logout') }}" class="dropdown-item" 
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
                <nav class="navbar-sidebar2">
                    <ul class="list-unstyled navbar__list">
                        <li class="active has-sub">
                            <a  href="{{route('dashboard')}}">
                                <i class="fas fa-tachometer-alt"></i>Dashboard
                            </a>
                        </li>
                        <li class=" has-sub">
                            <a  href="{{route('view-account')}}">
                                <i class="fas fa-tasks"></i>View Account
                            </a>
                        </li>
                        <li class=" has-sub">
                            <a class="js-arrow open" href="#">
                                <i class="fas fa-bank"></i>Assign Admins
                                <span class="arrow">
                                    <i class="fas fa-angle-down"></i>
                                </span>
                            </a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list" >
                                <li>
                                    <a  href="{{route('brand-admin')}}">
                                        <i class="fas fa-tasks"></i>Brand Admin
                                    </a>
                                </li>
                                <li>
                                    <a  href="{{route('store-admin')}}">
                                        <i class="fas fa-tasks"></i>Store Admin
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class=" has-sub">
                            <a  href="{{route('commercials')}}">
                                <i class="fas fa-tasks"></i>Account Commercials
                            </a>
                        </li>
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-bank"></i>Manage Master Inventory
                                <span class="arrow">
                                    <i class="fas fa-angle-down"></i>
                                </span>
                            </a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list" >
                                <li>
                                    <a  href="{{route('product')}}">
                                        <i class="fas fa-tasks"></i>Manage Inventory Manually
                                    </a>
                                </li>
                                <li>
                                    <a  href="">
                                        <i class="fas fa-tasks"></i>Manage Inventory - API Integrated
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="has-sub">
                            <a class="js-arrow" href="{{route('orderdetails')}}">
                                <i class="fas fa-bank"></i>Order Processing
                                <!--<span class="arrow">-->
                                <!--    <i class="fas fa-angle-down"></i>-->
                                <!--</span>-->
                            </a>
                            <!--<ul class="list-unstyled navbar__sub-list js-sub-list">-->
                            <!--    <li>-->
                            <!--        <a  href="#">-->
                            <!--            <i class="fas fa-tasks"></i>Manage Inventory Manually-->
                            <!--        </a>-->
                            <!--    </li>-->
                            <!--    <li>-->
                            <!--        <a  href="">-->
                            <!--            <i class="fas fa-tasks"></i>IN APP Tools-->
                            <!--        </a>-->
                            <!--    </li>-->
                            <!--    <li>-->
                            <!--        <a  href="">-->
                            <!--            <i class="fas fa-tasks"></i>Manage Inventory - API Integrated-->
                            <!--        </a>-->
                            <!--    </li>-->
                            <!--</ul>-->
                        </li>
                        <li class=" has-sub">
                            <a  href="{{route('outlet')}}">
                                <i class="fas fa-tasks"></i>Manage Store Admins - Liaisons
                            </a>
                        </li>
                        <li class=" has-sub">
                            <a  href="{{route('sales-performance')}}">
                                <i class="fas fa-tasks"></i>View Sales Performance
                            </a>
                        </li>
                        <li class=" has-sub">
                            <a  href="{{route('live-stream')}}">
                                <i class="fas fa-tasks"></i>Manage Live Stream For Users
                            </a>
                        </li>
                        <li class=" has-sub">
                            <a  href="{{route('staff-updates')}}">
                                <i class="fas fa-tasks"></i>Manage Live Updates For Staff
                            </a>
                        </li>
                        <li class=" has-sub">
                            <a class="js-arrow open" href="#">
                                <i class="fas fa-bank"></i>Manage Coupons & Vouchers  
                                <span class="arrow">
                                    <i class="fas fa-angle-down"></i>
                                </span>
                            </a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list" >
                                <li>
                                    <a  href="{{route('banner')}}">
                                        <i class="fas fa-tasks"></i>Banner
                                    </a>
                                </li>
                                <li>
                                    <a  href="{{route('offer-banner')}}">
                                        <i class="fas fa-tasks"></i>Offer Banner
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class=" has-sub">
                            <a  href="{{route('promos')}}">
                                <i class="fas fa-tasks"></i>Manage Promotions For Quick Shop
                            </a>
                        </li>
                        <li class=" has-sub">
                            <a  href="#">
                                <i class="fas fa-tasks"></i>View Staff & Store Interactions
                            </a>
                        </li>
                        <li class=" has-sub">
                            <a  href="{{route('user-staff-interaction')}}">
                                <i class="fas fa-tasks"></i>View User & Staff Interactions
                            </a>
                        </li>
                        <li class=" has-sub">
                            <a  href="{{route('staff-performance')}}">
                                <i class="fas fa-tasks"></i>View Staff Performance on State - City - Store Level
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>
        <!-- END MENU SIDEBAR-->
        <!-- PAGE CONTAINER-->
        <div class="page-container2">
            <!-- HEADER DESKTOP-->
            <header class="header-desktop2">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="header-wrap2">
                            <div class="logo d-block d-lg-none">
                                <a href="#">
                                    <!--<img src="images/icon/logo-white.png" alt="CoolAdmin"/>-->
                                    <h3 style="color:#fff;"> COMPANY ADMIN</h3>
                                </a>
                            </div>
                            <div class="header-button2">
                                    <?php   $uid= auth::user()->id;
                                            $edituser = DB::table('company_admin')
                                                        ->select('*')
                                                        ->where('id', '=',$uid)
                                                        ->first(); 
                                                       
                                    ?>
                                    <div class="header-button-item has-noti js-item-menu" style="<?php if(($edituser->video_minutes <= $edituser->reserve_video_minutes/2 && $edituser->video_minutes > 0) || ($edituser->video_minutes <=0) || ($edituser->audio_minutes <= $edituser->reserve_audio_minutes/2 && $edituser->audio_minutes > 0) || ($edituser->audio_minutes <= 0) ){echo "display:block";}else{echo "display:none";} ?>">
                                        <i class="zmdi zmdi-notifications"></i>
                                        <div class="notifi-dropdown js-dropdown">
                                            <?php if($edituser->video_minutes <= $edituser->reserve_video_minutes/2 && $edituser->video_minutes > 0  ) { ?>
                                            <div class="notifi__item">
                                                <div class="bg-c1 img-cir img-40">
                                                    <i class="zmdi zmdi-email-open"></i>
                                                </div>
                                                <div class="content">
                                                    <p>Your Prepaid Video minutes is low please recharge shortly.</p>
                                                </div>
                                            </div>
                                            <?php } elseif($edituser->video_minutes <= 0){ ?>
                                            <div class="notifi__item">
                                                <div class="bg-c1 img-cir img-40">
                                                    <i class="zmdi zmdi-email-open"></i>
                                                </div>
                                                <div class="content">
                                                    <p>Your Prepaid Video minutes limit is exceed please recharge immediately to countinue our services.</p>
                                                </div>
                                            </div>
                                            <?php } ?>
                                            <?php if($edituser->audio_minutes <= $edituser->reserve_audio_minutes/2 && $edituser->audio_minutes > 0  ) { ?>
                                            <div class="notifi__item">
                                                <div class="bg-c1 img-cir img-40">
                                                    <i class="zmdi zmdi-email-open"></i>
                                                </div>
                                                <div class="content">
                                                    <p>Your Prepaid Audio minutes is low please recharge shortly.</p>
                                                </div>
                                            </div>
                                            <?php }elseif($edituser->audio_minutes <= 0){ ?>
                                                <div class="notifi__item">
                                                    <div class="bg-c1 img-cir img-40">
                                                        <i class="zmdi zmdi-email-open"></i>
                                                    </div>
                                                    <div class="content">
                                                        <p>Your Prepaid Audio minutes limit is exceed please recharge immediately to countinue our services.</p>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    
                                <div class="header-button-item mr-0 js-sidebar-btn">
                                    <i class="zmdi zmdi-menu"></i>
                                </div>
                                <div class="setting-menu js-right-sidebar d-none d-lg-block">
                                    <div class="account-dropdown__body">
                                        <div class="account-dropdown__item">
                                            <a href="{{route('view-account')}}">
                                                <i class="zmdi zmdi-account"></i>Account</a>
                                        </div>
                                        <div class="account-dropdown__item">
                                            <a href="{{route('change-password')}}">
                                                <i class="zmdi zmdi-settings"></i>Change Password</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <aside class="menu-sidebar2 js-right-sidebar d-block d-lg-none">
                <div class="logo">
                    <a href="#">
                        <!--<img src="images/icon/logo-white.png" alt="Cool Admin" />-->
                        <h3 style="color:#fff;"> COMPANY ADMIN</h3>
                    </a>
                </div>
                <div class="menu-sidebar2__content js-scrollbar2">
                    <div class="account2">
                        <div class="image img-cir img-120" style="display:none;">
                            <img src="images/icon/avatar-big-01.jpg" alt="{{ Auth::user()->name }}" />
                        </div>
                        <h4 class="name">{{ Auth::user()->name }}</h4>
                        <div class="">
                            <a href="{{ route('logout') }}" class="dropdown-item" 
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                    <nav class="navbar-sidebar2">
                    <ul class="list-unstyled navbar__list">
                        <li class="active has-sub">
                            <a  href="{{route('dashboard')}}">
                                <i class="fas fa-tachometer-alt"></i>Dashboard
                            </a>
                        </li>
                        <li class=" has-sub">
                            <a  href="{{route('view-account')}}">
                                <i class="fas fa-tasks"></i>View Account
                            </a>
                        </li>
                        <li class=" has-sub">
                            <a class="js-arrow open" href="#">
                                <i class="fas fa-bank"></i>Assign Admins
                                <span class="arrow">
                                    <i class="fas fa-angle-down"></i>
                                </span>
                            </a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list" >
                                <li>
                                    <a  href="{{route('brand-admin')}}">
                                        <i class="fas fa-tasks"></i>Brand Admin
                                    </a>
                                </li>
                                <li>
                                    <a  href="{{route('store-admin')}}">
                                        <i class="fas fa-tasks"></i>Store Admin
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class=" has-sub">
                            <a  href="{{route('commercials')}}">
                                <i class="fas fa-tasks"></i>Account Commercials
                            </a>
                        </li>
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-bank"></i>Manage Master Inventory
                                <span class="arrow">
                                    <i class="fas fa-angle-down"></i>
                                </span>
                            </a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list" >
                                <li>
                                    <a  href="{{route('product')}}">
                                        <i class="fas fa-tasks"></i>Manage Inventory Manually
                                    </a>
                                </li>
                                <li>
                                    <a  href="">
                                        <i class="fas fa-tasks"></i>Manage Inventory - API Integrated
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-bank"></i>Order Processing
                                <!--<span class="arrow">-->
                                <!--    <i class="fas fa-angle-down"></i>-->
                                <!--</span>-->
                            </a>
                            <!--<ul class="list-unstyled navbar__sub-list js-sub-list">-->
                            <!--    <li>-->
                            <!--        <a  href="#">-->
                            <!--            <i class="fas fa-tasks"></i>Manage Inventory Manually-->
                            <!--        </a>-->
                            <!--    </li>-->
                            <!--    <li>-->
                            <!--        <a  href="">-->
                            <!--            <i class="fas fa-tasks"></i>IN APP Tools-->
                            <!--        </a>-->
                            <!--    </li>-->
                            <!--    <li>-->
                            <!--        <a  href="">-->
                            <!--            <i class="fas fa-tasks"></i>Manage Inventory - API Integrated-->
                            <!--        </a>-->
                            <!--    </li>-->
                            <!--</ul>-->
                        </li>
                        <li class=" has-sub">
                            <a  href="{{route('outlet')}}">
                                <i class="fas fa-tasks"></i>Manage Store Admins - Liaisons
                            </a>
                        </li>
                        <li class=" has-sub">
                            <a  href="{{route('sales-performance')}}">
                                <i class="fas fa-tasks"></i>View Sales Performance
                            </a>
                        </li>
                        <li class=" has-sub">
                            <a  href="{{route('live-stream')}}">
                                <i class="fas fa-tasks"></i>Manage Live Stream For Users
                            </a>
                        </li>
                        <li class=" has-sub">
                            <a  href="{{route('staff-updates')}}">
                                <i class="fas fa-tasks"></i>Manage Live Updates For Staff
                            </a>
                        </li>
                        <li class=" has-sub">
                            <a class="js-arrow open" href="#">
                                <i class="fas fa-bank"></i>Manage Coupons & Vouchers  
                                <span class="arrow">
                                    <i class="fas fa-angle-down"></i>
                                </span>
                            </a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list" >
                                <li>
                                    <a  href="{{route('banner')}}">
                                        <i class="fas fa-tasks"></i>Banner
                                    </a>
                                </li>
                                <li>
                                    <a  href="{{route('offer-banner')}}">
                                        <i class="fas fa-tasks"></i>Offer Banner
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class=" has-sub">
                            <a  href="{{route('promos')}}">
                                <i class="fas fa-tasks"></i>Manage Promotions For Quick Shop
                            </a>
                        </li>
                        <li class=" has-sub">
                            <a  href="#">
                                <i class="fas fa-tasks"></i>View Staff & Store Interactions
                            </a>
                        </li>
                        <li class=" has-sub">
                            <a  href="{{route('user-staff-interaction')}}">
                                <i class="fas fa-tasks"></i>View User & Staff Interactions
                            </a>
                        </li>
                        <li class=" has-sub">
                            <a  href="{{route('staff-performance')}}">
                                <i class="fas fa-tasks"></i>View Staff Performance on State - City - Store Level
                            </a>
                        </li>
                    </ul>
                </nav>
                </div>
            </aside>

@yield('content')

		</div>

    </div>

    <!-- Jquery JS-->
    <script src="{{ asset('vendor/jquery-3.2.1.min.js')}}"></script>
    <!-- Bootstrap JS-->
    <script src="{{ asset('vendor/bootstrap-4.1/popper.min.js')}}"></script>
    <script src="{{ asset('vendor/bootstrap-4.1/bootstrap.min.js')}}"></script>
    <!-- Vendor JS       -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="{{ asset('vendor/slick/slick.min.js')}}"></script>
    <script src="{{ asset('vendor/wow/wow.min.js')}}"></script>
    <script src="{{ asset('vendor/animsition/animsition.min.js')}}"></script>
    <script src="{{ asset('vendor/bootstrap-progressbar/bootstrap-progressbar.min.js')}}"></script>
    <script src="{{ asset('vendor/counter-up/jquery.waypoints.min.js')}}"></script>
    <script src="{{ asset('vendor/counter-up/jquery.counterup.min.js')}}"></script>
    <script src="{{ asset('vendor/circle-progress/circle-progress.min.js')}}"></script>
    <script src="{{ asset('vendor/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
    <script src="{{ asset('vendor/chartjs/Chart.bundle.min.js')}}"></script>
    <script src="{{ asset('vendor/select2/select2.min.js')}}">
    </script>
    <script src="{{ asset('vendor/vector-map/jquery.vmap.js')}}"></script>
    <script src="{{ asset('vendor/vector-map/jquery.vmap.min.js')}}"></script>
    <script src="{{ asset('vendor/vector-map/jquery.vmap.sampledata.js')}}"></script>
    <script src="{{ asset('vendor/vector-map/jquery.vmap.world.js')}}"></script>
    
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
    
    <!--<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>-->
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>-->
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>-->
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>-->
    <!--<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>-->
    <script src="https://cdn.ckeditor.com/4.15.0/standard-all/ckeditor.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <!-- Main JS-->
    <script src="{{ asset('js/main.js')}}"></script>
    @yield('script')
    <script>
        $(document).ready(function() {
            var table= $('#example').DataTable({
              "paging": true,
              "lengthChange": true,
              // "lengthMenu": [[5]],
              "searching": true,
              "ordering": true,
              "info": true,
              "autoWidth": true,
              "responsive": true,
               dom: 'Bfrtip',
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'pdfHtml5'
                ]
              
            });
            
            $(document).on('click', '#btnPrintbrand', function () {
                var matches = [];
                var checkedcollection = table.$(".chkAccId:checked", { "page": "all" });
                checkedcollection.each(function (index, elem) {
                    matches.push($(elem).val());
                });
                if(matches.length <=0)  
                { 
                    alert("Please select atleast one record to delete.");
                }  else {
                    if(confirm("Are you sure, you want to delete the selected data ?")){  
                        var strIds = matches.join(","); 
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('multiple-brand-delete') }}",
                            data:{_token : '<?php echo csrf_token(); ?>',ids:strIds},
                            success: function (data) {
                                window.location.reload();
                            },
                        });
                    }
                } 
            });
            
            $(document).on('click', '#btnPrintproduct', function () {
                var matches = [];
                var checkedcollection = table.$(".chkAccId:checked", { "page": "all" });
                checkedcollection.each(function (index, elem) {
                    matches.push($(elem).val());
                });
                if(matches.length <=0)  
                { 
                    alert("Please select atleast one record to delete.");
                }  else {
                    if(confirm("Are you sure, you want to delete the selected data ?")){  
                        var strIds = matches.join(","); 
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('multiple-product-delete') }}",
                            data:{_token : '<?php echo csrf_token(); ?>',ids:strIds},
                            success: function (data) {
                                window.location.reload();
                            },
                        });
                    }
                } 
            });
            
            $(document).on('click', '#btnPrintbanner', function () {
                var matches = [];
                var checkedcollection = table.$(".chkAccId:checked", { "page": "all" });
                checkedcollection.each(function (index, elem) {
                    matches.push($(elem).val());
                });
                if(matches.length <=0)  
                { 
                    alert("Please select atleast one record to delete.");
                }  else {
                    if(confirm("Are you sure, you want to delete the selected data ?")){  
                        var strIds = matches.join(","); 
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('multiple-banner-delete') }}",
                            data:{_token : '<?php echo csrf_token(); ?>',ids:strIds},
                            success: function (data) {
                                window.location.reload();
                            },
                        });
                    }
                } 
            });
            
            $(document).on('click', '#btnPrintlocation', function () {
                var matches = [];
                var checkedcollection = table.$(".chkAccId:checked", { "page": "all" });
                checkedcollection.each(function (index, elem) {
                    matches.push($(elem).val());
                });
                if(matches.length <=0)  
                { 
                    alert("Please select atleast one record to delete.");
                }  else {
                    if(confirm("Are you sure, you want to delete the selected data ?")){  
                        var strIds = matches.join(","); 
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('multiple-location-delete') }}",
                            data:{_token : '<?php echo csrf_token(); ?>',ids:strIds},
                            success: function (data) {
                                window.location.reload();
                            },
                        });
                    }
                } 
            });
            
            $(document).on('click', '#btnPrintsupcat', function () {
                var matches = [];
                var checkedcollection = table.$(".chkAccId:checked", { "page": "all" });
                checkedcollection.each(function (index, elem) {
                    matches.push($(elem).val());
                });
                if(matches.length <=0)  
                { 
                    alert("Please select atleast one record to delete.");
                }  else {
                    if(confirm("Are you sure, you want to delete the selected data ?")){  
                        var strIds = matches.join(","); 
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('multiple-super-category-delete') }}",
                            data:{_token : '<?php echo csrf_token(); ?>',ids:strIds},
                            success: function (data) {
                                window.location.reload();
                            },
                        });
                    }
                } 
            });
            
            $(document).on('click', '#btnPrintcat', function () {
                var matches = [];
                var checkedcollection = table.$(".chkAccId:checked", { "page": "all" });
                checkedcollection.each(function (index, elem) {
                    matches.push($(elem).val());
                });
                if(matches.length <=0)  
                { 
                    alert("Please select atleast one record to delete.");
                }  else {
                    if(confirm("Are you sure, you want to delete the selected data ?")){  
                        var strIds = matches.join(","); 
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('multiple-category-delete') }}",
                            data:{_token : '<?php echo csrf_token(); ?>',ids:strIds},
                            success: function (data) {
                                window.location.reload();
                            },
                        });
                    }
                } 
            });
            
            $(document).on('click', '#btnPrintsubcat', function () {
                var matches = [];
                var checkedcollection = table.$(".chkAccId:checked", { "page": "all" });
                checkedcollection.each(function (index, elem) {
                    matches.push($(elem).val());
                });
                if(matches.length <=0)  
                { 
                    alert("Please select atleast one record to delete.");
                }  else {
                    if(confirm("Are you sure, you want to delete the selected data ?")){  
                        var strIds = matches.join(","); 
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('multiple-subcategory-delete') }}",
                            data:{_token : '<?php echo csrf_token(); ?>',ids:strIds},
                            success: function (data) {
                                window.location.reload();
                            },
                        });
                    }
                } 
            });
            
            $(document).on('click', '#btnPrintcoupon', function () {
                var matches = [];
                var checkedcollection = table.$(".chkAccId:checked", { "page": "all" });
                checkedcollection.each(function (index, elem) {
                    matches.push($(elem).val());
                });
                if(matches.length <=0)  
                { 
                    alert("Please select atleast one record to delete.");
                }  else {
                    if(confirm("Are you sure, you want to delete the selected data ?")){  
                        var strIds = matches.join(","); 
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('multiple-coupon-delete') }}",
                            data:{_token : '<?php echo csrf_token(); ?>',ids:strIds},
                            success: function (data) {
                                window.location.reload();
                            },
                        });
                    }
                } 
            });
            
            $(document).on('click', '#btnPrintorder', function () {
                var matches = [];
                var checkedcollection = table.$(".chkAccId:checked", { "page": "all" });
                checkedcollection.each(function (index, elem) {
                    matches.push($(elem).val());
                });
                if(matches.length <=0)  
                { 
                    alert("Please select atleast one record to delete.");
                }  else {
                    if(confirm("Are you sure, you want to delete the selected data ?")){  
                        var strIds = matches.join(","); 
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('multiple-order-delete') }}",
                            data:{_token : '<?php echo csrf_token(); ?>',ids:strIds},
                            success: function (data) {
                                window.location.reload();
                            },
                        });
                    }
                } 
            });
            
        } );
    </script>
    <script>
        $(document).ready(function(){
            setTimeout(function(){
                $(".alert-success").fadeOut(400);
            }, 3000)
        });
        
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });
        
</script>
<script>
    CKEDITOR.replace('product_description', {
      height: 250,
      extraPlugins: 'colorbutton'
    });
</script>
</body>

</html>
<!-- end document-->