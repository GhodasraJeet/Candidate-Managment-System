<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{asset('img/logo.png')}}">
    <link rel="manifest" href="{{asset('manifest.json')}}">

    <meta name="_token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/css/all.min.css') }}">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="{{ asset('css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css')}}">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    @yield('css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
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

          <aside class="main-sidebar sidebar-dark-primary elevation-4">

            <a href="{{route('admin.home') }}" class="brand-link">
              <span class="brand-text font-weight-light text-center">CMS</span>
            </a>


            <div class="sidebar">

              <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="info">
                  <a href="#" class="d-block">{{ Auth::user()->name }}</a>
                </div>
              </div>


              <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                  <li class="nav-item has-treeview">
                  <a href="{{ route('admin.home') }}" class="nav-link {{ (request()->is('admin/home*')) ? 'active':'' }}">
                      <i class="nav-icon fas fa-tachometer-alt"></i>
                      <p>
                        Dashboard
                      </p>
                    </a>
                  </li>

                  <li class="nav-item has-treeview {{ (request()->is('admin/admincategory*')) ? 'menu-open active':'' }}">
                    <a href="{{ route('admincategory.index') }}" class="nav-link {{ (request()->is('category*')) ? 'active':'' }}">
                      <i class="nav-icon fas fa-chart-pie"></i>
                      <p>
                        Category

                      </p>
                    </a>

                  </li>

                  <li class="nav-item has-treeview {{ (request()->is('admin/hr*')) ? ' active':'' }}">
                    <a href="{{ route('hr.index') }}" class="nav-link {{ (request()->is('admin/hr*')) ? 'active':'' }}">
                      <i class="nav-icon fas fa-user"></i>
                      <p>
                        HR
                      </p>
                    </a>
                  </li>

                  <li class="nav-item has-treeview {{ (request()->is('admin/plans*')) ? ' active':'' }}">
                    <a href="{{ route('plan.index') }}" class="nav-link {{ (request()->is('admin/plans*')) ? 'active':'' }}">
                      <i class="nav-icon fas fa-briefcase"></i>
                      <p>
                        Plans
                      </p>
                    </a>
                  </li>

                  <li class="nav-item has-treeview {{ (request()->is('admin/candidates*')) ? 'menu-open active':'' }}">
                    <a href="{{ route('candidates.index') }}" class="nav-link {{ (request()->is('candidates/')) ? 'active':'' }}">
                      <i class="nav-icon fas fa-users"></i>
                      <p>
                        Candidate
                      </p>
                    </a>
                  </li>

                  <li class="nav-item has-treeview {{ (request()->is('admin/candidatesreport'))||(request()->is('admin/hrreport*')) ? 'menu-open':'' }}">
                    <a href="#" class="nav-link {{ (request()->is('admin/candidatesreport*'))||(request()->is('admin/hrreport*')) ? 'active':'' }}">
                      <i class="nav-icon fas fa-chart-pie"></i>
                      <p>
                        Reports
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="{{route('viewcandidate')}}" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Candidates</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="{{route('viewhr')}}" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>HR</p>
                        </a>
                      </li>
                    </ul>
                  </li>


                </ul>
              </nav>

            </div>

          </aside>

          <div class="content-wrapper py-2">
            @yield('content')
          </div>
        </div>


    <script src="{{ asset('js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('js/adminlte.min.js')}}"></script>
    @yield('js')
    <script src="{{ asset('js/my.js') }}"></script>
</body>
</html>
