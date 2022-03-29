<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>NIVNE | @yield('title')</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('admin/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('admin/dist/css/adminlte.min.css') }}">

  <link rel="stylesheet" href="{{ asset('admin/plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  @yield('css-top')

  @livewireStyles
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>

      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
      <img src="{{ asset('admin/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">NIVNE APP</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('admin/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->name }}</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      @include('staff.layouts.sidebar')
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @yield('content')
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2021 <a href="#">DJ-NET IT Solutions</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

{{-- @include('admin.layouts.partials.confirmation-delete-modal') --}}

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{ asset('admin/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('admin/dist/js/adminlte.min.js') }}"></script>

<script src="{{ asset('admin/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>

<script src="{{ asset('admin/plugins/select2/js/select2.full.min.js') }}"></script>

<script>
    $("input[is-active-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    })

    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    // $('.select2bs4').select2({
    //     theme: 'bootstrap4'
    // })


</script>

@yield('js-bot')

<script>

    //Branches Modal
    window.addEventListener('show-branch-modal', event => {
        $('#formModal').modal('show');
    })

    window.addEventListener('hide-branch-modal', event => {
        $('#formModal').modal('hide');
    })

    //Users Modal
    window.addEventListener('show-user-modal', event => {
        $('#formModal').modal('show');
    })

    window.addEventListener('hide-user-modal', event => {
        $('#formModal').modal('hide');
    })

    //Categories Modal
    window.addEventListener('show-category-modal', event => {
        $('#formModal').modal('show');
    })

    window.addEventListener('hide-category-modal', event => {
        $('#formModal').modal('hide');
    })

     //Customer Modal
     window.addEventListener('show-customer-modal', event => {
        $('#formModal').modal('show');
    })

    window.addEventListener('hide-customer-modal', event => {
        $('#formModal').modal('hide');
    })

     //Employee Modal
     window.addEventListener('show-employee-modal', event => {
        $('#formModal').modal('show');
    })

    window.addEventListener('hide-employee-modal', event => {
        $('#formModal').modal('hide');
    })

    //Brands Modal
    window.addEventListener('show-brand-modal', event => {
        $('#formModal').modal('show');
    })

    window.addEventListener('hide-brand-modal', event => {
        $('#formModal').modal('hide');
    })

    //Suppliers Modal
    window.addEventListener('show-supplier-modal', event => {
        $('#formModal').modal('show');
    })

    window.addEventListener('hide-supplier-modal', event => {
        $('#formModal').modal('hide');
    })

    //Suppliers Modal
    window.addEventListener('show-receipt-modal', event => {
        $('#formModal').modal('show');
    })

    window.addEventListener('hide-receipt-modal', event => {
        $('#formModal').modal('hide');
    })

    //Products Modal
    window.addEventListener('show-product-modal', event => {
        $('#formProductModal').modal('show');
    })

    window.addEventListener('hide-product-modal', event => {
        $('#formProductModal').modal('hide');
    })

    //Stocks Product In Modal
    window.addEventListener('show-stock-productin-modal', event => {
        $('#formModal').modal('show');
    })

    window.addEventListener('hide-stock-productin-modal', event => {
        $('#formModal').modal('hide');
    })

     //Stocks Product Out Modal
    window.addEventListener('show-productout-modal', event => {
        $('#formModal').modal('show');
    })

    window.addEventListener('hide-productout-modal', event => {
        $('#formModal').modal('hide');
    })

    //add product to tracking Product Out Modal
    window.addEventListener('show-add-product-tracking-modal', event => {
        $('#formAddProductToTrackingModal').modal('show');
    })

    window.addEventListener('hide-add-product-tracking-modal', event => {
        $('#formAddProductToTrackingModal').modal('hide');
    })

     //add product add to tracking Modal
     window.addEventListener('show-product-add-modal', event => {
        $('#addProductModal').modal('show');
    })

    window.addEventListener('hide-product-add-modal', event => {
        $('#addProductModal').modal('hide');
    })

    window.addEventListener('show-staff-stock-modal', event => {
        $('#formModal').modal('show');
    })

    window.addEventListener('hide-staff-stock-modal', event => {
        $('#formModal').modal('hide');
    })

    window.addEventListener('show-staff-stock-history-modal', event => {
        $('#stocks-history-modal').modal('show');
    })

    window.addEventListener('hide-staff-stock-history-modal', event => {
        $('#stocks-history-modal').modal('hide');
    })
    //Confirmation Delete Modal
    window.addEventListener('show-confirmation-delete-modal', event => {
        $('#confirmationModal').modal('show');
    })

    window.addEventListener('hide-confirmation-delete-modal', event => {
        $('#confirmationModal').modal('hide');
    })

    window.addEventListener('show-confirmation-delete-modal-tracking', event => {
        $('#confirmationModaltracking').modal('show');
    })

    window.addEventListener('hide-confirmation-delete-modal-tracking', event => {
        $('#confirmationModaltracking').modal('hide');
    })

    window.addEventListener('refresh-list-of-items', event => {
        $('#listOfItemsTable').load();
    })

    window.addEventListener('show-qty-modal', event => {
        $('#qtyModal').modal('show');
    })

    window.addEventListener('hide-qty-modal', event => {
        $('#qtyModal').modal('hide');
    })

    window.addEventListener('show-return-modal', event => {
        $('#returnModal').modal('show');
    })

    window.addEventListener('hide-return-modal', event => {
        $('#returnModal').modal('hide');
    })

    window.addEventListener('show-return-qty-modal', event => {
        $('#returnQty').modal('show');
    })

    window.addEventListener('hide-return-qty-modal', event => {
        $('#returnQty').modal('hide');
    })

    window.addEventListener('show-product_tracking-modal', event => {
        $('#productTrackingModal').modal('show');
    })

    window.addEventListener('hide-product_tracking-modal', event => {
        $('#productTrackingModal').modal('hide');
    })

</script>
@stack('scripts')

@livewireScripts
</body>
</html>
