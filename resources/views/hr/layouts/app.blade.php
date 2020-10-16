<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/css/all.min.css') }}">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="{{ asset('css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css')}}">
    @yield('css')
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <title>@yield('title')</title>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

      <!-- Navbar -->
      <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
          </li>
        </ul>
        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link"  href="{{ route('logout') }}" role="button">
              Logout
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.navbar -->

      <!-- Main Sidebar Container -->
      <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{route('hrhome') }}" class="brand-link">
          <span class="brand-text font-weight-light text-center">CMS</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">
              <a href="#" class="d-block">{{auth()->user()->name}}</a>
            </div>
          </div>

          <!-- Sidebar Menu -->
          <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              <!-- Add icons to the links using the .nav-icon class
                   with font-awesome or any other icon font library -->
              <li class="nav-item has-treeview">
              <a href="{{ route('hrhome') }}" class="nav-link {{ (request()->is('hrhome*')) ? 'active':'' }}">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                    Dashboard
                  </p>
                </a>
              </li>
              <li class="nav-item has-treeview {{ (request()->is('hrcategory*')) ? 'menu-open':'' }}">
                <a href="#" class="nav-link {{ (request()->is('hrcategory*')) ? 'active':'' }}">
                  <i class="nav-icon fas fa-chart-pie"></i>
                  <p>
                    Category
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('hrcategory.create') }}" class="nav-link ">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Add Category</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('hrcategory.index') }}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Display Category</p>
                    </a>
                  </li>
                </ul>
              </li>



              <li class="nav-item has-treeview {{ (request()->is('hrinterview*')) ? 'menu-open':'' }}">
                <a href="#" class="nav-link {{ (request()->is('hrinterview*')) ? 'active':'' }}">
                  <i class="nav-icon fas fa-user"></i>
                  <p>
                    Candidate
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">

                    <li class="nav-item menu-open">
                        <a href="{{ route('hrinterview.create') }}" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Add Candidate</p>
                        </a>
                      </li>
                  <li class="nav-item menu-open">
                    <a href="{{ route('hrinterview.index') }}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Display all Candidate</p>
                    </a>
                  </li>
                  <li class="nav-item menu-open">
                    <a href="{{ route('hrinterview.mycandidate') }}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>My Candidate</p>
                    </a>
                  </li>
                </ul>
              </li>

            </ul>
          </nav>
          <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper py-2">
        <!-- Content Header (Page header) -->
        @yield('content')
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->
    </div>
<!-- jQuery -->
<script src="{{ asset('js/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
@yield('js')
<script src="{{ asset('js/adminlte.min.js')}}"></script>
<script src="{{ asset('js/my.js') }}"></script>


</body>
</html>
