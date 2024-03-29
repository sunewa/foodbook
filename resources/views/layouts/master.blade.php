
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="csrf-token" content="{{csrf_token()}}" >
  <title>Food Book</title>

  
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('./css/app.css') }}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper" id="app">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="/" class="nav-link">Home</a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>

    
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/home" class="brand-link">
      <img src="{{ asset('./img/logo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Food Book</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('./img/profile.png') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->name }}</a>
          <a>{{ Auth::user()->role }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

          <li class="nav-item">
            <router-link to="/manage/dashboard" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/manage/posts" class="nav-link">
              <i class="nav-icon fas fa-cubes"></i>
              <p>
                Posts
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/manage/products" class="nav-link">
              <i class="nav-icon fas fa-box-open"></i>
              <p>
                Products
                <i class="fas fa-angle-left right"></i>
              </p>
            </router-link>
            <ul class="nav nav-treeview">
            <li class="nav-item">
              <router-link to="/manage/products/history" class="nav-link">
              
                <p>Purchase History</p>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/manage/products/order" class="nav-link">
              
                <p>Order History</p>
              </router-link>
            </li>
          </ul>
          </li>
         

          @can('isAdmin')
            <li class="nav-item">
              <router-link to="/manage/users" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
                <p>Users</p>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/manage/feedback" class="nav-link">
              <i class="nav-icon fas fa-comment"></i>
                <p>Feedback</p>
              </router-link>
            </li>
          @endcan
          <li class="nav-item">
            <router-link to="/manage/profile" class="nav-link">
              <i class="nav-icon fas fa-id-badge"></i>
              <p>
                Profile
              </p>
            </router-link>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                <i class="nav-icon fas fa-sign-out-alt"></i>
                <p>{{ __('Logout') }}</p>
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <div class="content">
      <div class="container-fluid">
        <router-view></router-view>
      </div>
    </div>
    
  </div>
  <!-- /.content-wrapper -->

 

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      NIT6150 Advance Project
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2020 <a href="#">Food Book</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->


<!-- AdminLTE App -->
<script src="{{ asset('./js/app.js') }}"></script>

</body>
</html>
