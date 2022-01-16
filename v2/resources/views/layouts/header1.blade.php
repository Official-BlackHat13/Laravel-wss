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
    <title>Dashboard</title>

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
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
    
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
    </style>
</head>

<body class="animsition">
    <div class="">
        <!-- MENU SIDEBAR-->
        <aside class="menu-sidebar2">
            <div class="logo">
                <a href="#">
                    <!--<img src="{{ asset('images/icon/logo-white.png')}}" alt="Cool Admin"/>-->
                    <h3 style="color:#fff;"> BMONGER ADMIN</h3>
                </a>
            </div>
            <div class="menu-sidebar2__content js-scrollbar1">
                <div class="account2">
                    <div class="image img-cir img-120" style="display:none">
                        <!--<img src="{{ asset('images/icon/avatar-big-01.jpg')}}" alt="{{ Auth::user()->name }}" />-->
                        <i class="fa fa-user" aria-hidden="true" style="font-size:20px;"></i>
                    </div>
                    <h4 class="name">{{ Auth::user()->name }}</h4>
                    <div class="">
                        <a href="{{ route('logout') }}" class="dropdown-item" 
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </a>
                        <!--<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">-->
                        <!--    @csrf-->
                        <!--</form>-->
                    </div>
                </div>
                <nav class="navbar-sidebar2">
                    <ul class="list-unstyled navbar__list">
                        <li class="active has-sub">
                            <a  href="{{route('dashboard')}}">
                                <i class="fas fa-tachometer-alt"></i>Dashboard
                            </a>
                        </li>
                        <li class="has-sub">
                            <a class="js-arrow open" href="#">
                                <i class="fas fa-bank"></i>Assign Admins
                                <span class="arrow">
                                    <i class="fas fa-angle-down"></i>
                                </span>
                            </a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
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
                                <li>
                                    <a  href="{{route('outlet')}}">
                                        <i class="fas fa-tasks"></i>Outlets
                                    </a>
                                </li>
                                <li>
                                    <a  href="{{route('Liaison')}}">
                                        <i class="fas fa-tasks"></i>Assign Liaison
                                    </a>
                                </li>
                                <!--<li>-->
                                <!--    <a  href="{{route('product')}}">-->
                                <!--        <i class="fas fa-tasks"></i>Products-->
                                <!--    </a>-->
                                <!--</li>-->
                            </ul>
                        </li>
                        <li class="has-sub">
                            <a class="js-arrow open" href="#">
                                <i class="fas fa-bank"></i>Manage Banners
                                <span class="arrow">
                                    <i class="fas fa-angle-down"></i>
                                </span>
                            </a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a  href="{{route('banner')}}">
                                        <i class="fa fa-file-image-o"></i>Banners
                                    </a>
                                </li>
                                <li>
                                    <a  href="{{route('offer-banner')}}">
                                        <i class="fas fa-trophy"></i>Offer Banner
                                    </a>
                                </li>
                                <li>
                                    <a  href="{{route('winner-banner')}}">
                                        <i class="fas fa-trophy"></i>Winner Banner
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="has-sub">
                            <a href="{{route('users')}}">
                                <i class="fas fa-users"></i>Manage Users
                            </a>
                        </li>
                        <li>
                            <a  href="{{route('company')}}">
                                <i class="fas fa-tasks"></i>Manage Companies
                            </a>
                        </li>
                        
                        <li>
                            <a href="#">
                                <i class="fas fa-tasks"></i>Manage Razorpay and Internal Payments
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fas fa-tasks"></i>Manage Agora
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fas fa-tasks"></i>Manage Shiprocket
                            </a>
                        </li>
                        
                        <li>
                            <a href="{{route('coupons')}}">
                                <i class="fas fa-tasks"></i>Manage Offers
                            </a>
                        </li>
                        
                        <li>
                            <a href="#">
                                <i class="fas fa-tasks"></i>Manage Marketplace Promotions
                            </a>
                        </li>
                        
                        <li class="has-sub">
                            <a class="js-arrow open" href="#">
                                <i class="fas fa-bank"></i>Auto Populated Fields
                                <span class="arrow">
                                    <i class="fas fa-angle-down"></i>
                                </span>
                            </a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a  href="{{route('location')}}">
                                        <i class="fas fa-map-marker-alt"></i>Locations
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('super-category')}}"><i class="fas fa-tasks"></i>Super Category</a>
                                </li>
                                <li>
                                    <a href="{{route('category')}}"><i class="fas fa-tasks"></i>Category</a>
                                </li>
                                <li>
                                    <a href="{{route('sub-category')}}"><i class="fas fa-tasks"></i>Sub Category</a>
                                </li>
                                
                                <li>
                                    <a href="{{route('attributes')}}">
                                        <i class="fas fa-tasks"></i>Attributes
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('specifications')}}">
                                        <i class="fas fa-tasks"></i>Specifications
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('specifications-restriction')}}">
                                        <i class="fas fa-tasks"></i> Restriction
                                    </a>
                                </li>
                            </ul>
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
                                    <!--<img src="images/icon/logo-white.png" alt="CoolAdmin" />-->
                                    <h3 style="color:#fff;"> BMONGER ADMIN</h3>
                                </a>
                            </div>
                            <div class="header-button2">
                                <!--<div class="header-button-item js-item-menu">-->
                                <!--    <i class="zmdi zmdi-search"></i>-->
                                <!--    <div class="search-dropdown js-dropdown">-->
                                <!--        <form action="">-->
                                <!--            <input class="au-input au-input--full au-input--h65" type="text" placeholder="Search for datas &amp; reports..." />-->
                                <!--            <span class="search-dropdown__icon">-->
                                <!--                <i class="zmdi zmdi-search"></i>-->
                                <!--            </span>-->
                                <!--        </form>-->
                                <!--    </div>-->
                                <!--</div>-->
                                
                                <div class="header-button-item mr-0 js-sidebar-btn">
                                    <i class="zmdi zmdi-menu"></i>
                                </div>
                                <div class="setting-menu js-right-sidebar d-none d-lg-block">
                                    <div class="account-dropdown__body">
                                        <div class="account-dropdown__item">
                                            <a href="#">
                                                <i class="zmdi zmdi-account"></i>Account</a>
                                        </div>
                                        <div class="account-dropdown__item">
                                            <a href="#">
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
                        <h3 style="color:#fff;"> BMONGER ADMIN</h3>
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
                        <li class="has-sub">
                            <a class="js-arrow open" href="#">
                                <i class="fas fa-bank"></i>Super Admin
                                <span class="arrow">
                                    <i class="fas fa-angle-down"></i>
                                </span>
                            </a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list" style="display:block">
                                <li>
                                    <a  href="{{route('company')}}">
                                        <i class="fas fa-tasks"></i>Companies
                                    </a>
                                </li>
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
                                <li>
                                    <a  href="{{route('outlet')}}">
                                        <i class="fas fa-tasks"></i>Outlets
                                    </a>
                                </li>
                                <li>
                                    <a  href="{{route('Liaison')}}">
                                        <i class="fas fa-tasks"></i>Assign Liaison
                                    </a>
                                </li>
                                <!--<li>-->
                                <!--    <a  href="{{route('product')}}">-->
                                <!--        <i class="fas fa-tasks"></i>Products-->
                                <!--    </a>-->
                                <!--</li>-->
                                <li>
                                    <a  href="{{route('banner')}}">
                                        <i class="fa fa-file-image-o"></i>Banners
                                    </a>
                                </li>
                                <li>
                                    <a  href="{{route('offer-banner')}}">
                                        <i class="fas fa-trophy"></i>Offer Banner
                                    </a>
                                </li>
                                <li>
                                    <a  href="{{route('winner-banner')}}">
                                        <i class="fas fa-trophy"></i>Winner Banner
                                    </a>
                                </li>
                                <li>
                                    <a  href="{{route('location')}}">
                                        <i class="fas fa-map-marker-alt"></i>Locations
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('super-category')}}"><i class="fas fa-tasks"></i>Super Category</a>
                                </li>
                                <li>
                                    <a href="{{route('category')}}"><i class="fas fa-tasks"></i>Category</a>
                                </li>
                                <li>
                                    <a href="{{route('sub-category')}}"><i class="fas fa-tasks"></i>Sub Category</a>
                                </li>
                                <li>
                                    <a href="{{route('coupons')}}">
                                        <i class="fas fa-tasks"></i>Coupons/Vouchers
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('attributes')}}">
                                        <i class="fas fa-tasks"></i>Attributes
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('specifications')}}">
                                        <i class="fas fa-tasks"></i>Specifications
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('specifications-restriction')}}">
                                        <i class="fas fa-tasks"></i> Restriction
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="has-sub">
                            <a href="{{route('users')}}">
                                <i class="fas fa-users"></i>Users
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
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
    
    <!-- Main JS-->
    <script src="{{ asset('js/main.js')}}"></script>
    @yield('script')
    <script>
        $(document).ready(function() {
            var table = $('#example').DataTable({
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
            
            $(document).on('click', '#btnPrint', function () {
                var matches = [];
                var checkedcollection = table.$(".chkAccId:checked", { "page": "all" });
                checkedcollection.each(function (index, elem) {
                    matches.push($(elem).val());
                });
                if(matches.length <=0)  
                { 
                    alert("Please select atleast one record to delete.");
                }  else {
                    if(confirm("Are you sure, you want to delete the selected locations ?")){  
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
                    if(confirm("Are you sure, you want to delete the selected banners ?")){  
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
            
            $(document).on('click', '#btnPrintsupercat', function () {
                var matches = [];
                var checkedcollection = table.$(".chkAccId:checked", { "page": "all" });
                checkedcollection.each(function (index, elem) {
                    matches.push($(elem).val());
                });
                if(matches.length <=0)  
                { 
                    alert("Please select atleast one record to delete.");
                }  else {
                    if(confirm("Are you sure, you want to delete the selected super categories ?")){  
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
                    if(confirm("Are you sure, you want to delete the selected categories ?")){  
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
                    if(confirm("Are you sure, you want to delete the selected sub categories ?")){  
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
                    if(confirm("Are you sure, you want to delete the selected coupons ?")){  
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
            
            $(document).on('click', '#btnPrintcompany', function () {
                var matches = [];
                var checkedcollection = table.$(".chkAccId:checked", { "page": "all" });
                checkedcollection.each(function (index, elem) {
                    matches.push($(elem).val());
                });
                if(matches.length <=0)  
                { 
                    alert("Please select atleast one record to delete.");
                }  else {
                    if(confirm("Are you sure, you want to delete the selected companies ?")){  
                        var strIds = matches.join(","); 
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('multiple-company-delete') }}",
                            data:{_token : '<?php echo csrf_token(); ?>',ids:strIds},
                            success: function (data) {
                                window.location.reload();
                            },
                        });
                    }
                } 
            });
            
            $(document).on('click', '#btnPrintoutlet', function () {
                var matches = [];
                var checkedcollection = table.$(".chkAccId:checked", { "page": "all" });
                checkedcollection.each(function (index, elem) {
                    matches.push($(elem).val());
                });
                if(matches.length <=0)  
                { 
                    alert("Please select atleast one record to delete.");
                }  else {
                    if(confirm("Are you sure, you want to delete the selected outlets ?")){  
                        var strIds = matches.join(","); 
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('multiple-outlet-delete') }}",
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
                    if(confirm("Are you sure, you want to delete the selected product ?")){  
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
                    if(confirm("Are you sure, you want to delete the selected brand ?")){  
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
            
            $(document).on('click', '#btnPrintstore', function () {
                var matches = [];
                var checkedcollection = table.$(".chkAccId:checked", { "page": "all" });
                checkedcollection.each(function (index, elem) {
                    matches.push($(elem).val());
                });
                if(matches.length <=0)  
                { 
                    alert("Please select atleast one record to delete.");
                }  else {
                    if(confirm("Are you sure, you want to delete the selected product ?")){  
                        var strIds = matches.join(","); 
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('multiple-store-admin-delete') }}",
                            data:{_token : '<?php echo csrf_token(); ?>',ids:strIds},
                            success: function (data) {
                                window.location.reload();
                            },
                        });
                    }
                } 
            });
            
            $(document).on('click', '#btnPrintwinnerbanner', function () {
                var matches = [];
                var checkedcollection = table.$(".chkAccId:checked", { "page": "all" });
                checkedcollection.each(function (index, elem) {
                    matches.push($(elem).val());
                });
                if(matches.length <=0)  
                { 
                    alert("Please select atleast one record to delete.");
                }  else {
                    if(confirm("Are you sure, you want to delete the selected product ?")){  
                        var strIds = matches.join(","); 
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('multiple-wb-delete') }}",
                            data:{_token : '<?php echo csrf_token(); ?>',ids:strIds},
                            success: function (data) {
                                window.location.reload();
                            },
                        });
                    }
                } 
            });
            
            $(document).on('click', '#btnPrintofferbanner', function () {
                var matches = [];
                var checkedcollection = table.$(".chkAccId:checked", { "page": "all" });
                checkedcollection.each(function (index, elem) {
                    matches.push($(elem).val());
                });
                if(matches.length <=0)  
                { 
                    alert("Please select atleast one record to delete.");
                }  else {
                    if(confirm("Are you sure, you want to delete the selected product ?")){  
                        var strIds = matches.join(","); 
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('multiple-ob-delete') }}",
                            data:{_token : '<?php echo csrf_token(); ?>',ids:strIds},
                            success: function (data) {
                                window.location.reload();
                            },
                        });
                    }
                } 
            });
            
            $(document).on('click', '#btnPrintspec', function () {
                var matches = [];
                var checkedcollection = table.$(".chkAccId:checked", { "page": "all" });
                checkedcollection.each(function (index, elem) {
                    matches.push($(elem).val());
                });
                if(matches.length <=0)  
                { 
                    alert("Please select atleast one record to delete.");
                }  else {
                    if(confirm("Are you sure, you want to delete the selected specifications ?")){  
                        var strIds = matches.join(","); 
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('multiple-sp-delete') }}",
                            data:{_token : '<?php echo csrf_token(); ?>',ids:strIds},
                            success: function (data) {
                                window.location.reload();
                            },
                        });
                    }
                } 
            });
            
            $(document).on('click', '#btnPrintattr', function () {
                var matches = [];
                var checkedcollection = table.$(".chkAccId:checked", { "page": "all" });
                checkedcollection.each(function (index, elem) {
                    matches.push($(elem).val());
                });
                if(matches.length <=0)  
                { 
                    alert("Please select atleast one record to delete.");
                }  else {
                    if(confirm("Are you sure, you want to delete the selected attributes ?")){  
                        var strIds = matches.join(","); 
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('multiple-at-delete') }}",
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