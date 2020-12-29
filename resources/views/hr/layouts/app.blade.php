<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="_token" content="{{ csrf_token() }}">
    <link rel="manifest" href="{{asset('manifest.json')}}">
    <link rel="stylesheet" href="{{ asset('css/css/all.min.css') }}">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="{{ asset('css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css')}}">
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    @yield('css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <title>@yield('title')</title>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">


      <nav class="main-header navbar navbar-expand navbar-white navbar-light">

        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
          </li>
        </ul>

        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link"  href="{{ route('logout') }}" role="button">
              Logout
            </a>
          </li>
        </ul>
      </nav>

      <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="{{route('hr.home') }}" class="brand-link">
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
              <a href="{{ route('hr.home') }}" class="nav-link {{ (request()->is('hr/home')) ? 'active':'' }}">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                    Dashboard
                  </p>
                </a>
              </li>
              <li class="nav-item has-treeview {{ (request()->is('hr/category')) ? 'active':'' }}">
                <a href="{{ route('category.index') }}" class="nav-link {{ (request()->is('category*')) ? 'active':'' }}">
                  <i class="nav-icon fas fa-chart-pie"></i>
                  <p>
                    Category
                  </p>
                </a>
              </li>
              <li class="nav-item has-treeview {{ (request()->is('hr/interview*')) ? 'active':'' }}">
                <a href="{{ route('interview.index') }}" class="nav-link {{ (request()->is('interview*')) ? 'active':'' }}">
                  <i class="nav-icon fas fa-user"></i>
                  <p>
                    Candidate
                  </p>
                </a>
              </li>

            </ul>
          </nav>
        </div>
      </aside>

      <div class="content-wrapper py-2">
        <center>
            {{-- <button id="btn-nft-enable" onclick="initFirebaseMessagingRegistration()" class="btn btn-danger btn-flat">Allow for Notification</button>
            <input type="hidden" name="device_token" id="device_token"> --}}

        </center>
        @yield('content')

      </div>

    </div>

<script src="https://www.gstatic.com/firebasejs/7.16.1/firebase.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.16.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.16.1/firebase-messaging.js"></script>
<script>

    var firebaseConfig = {
        apiKey: "AIzaSyAdFTQbVACDmHy5QqaVYZby4iktlKywcFM",
        authDomain: "fir-notification-216ed.firebaseapp.com",
        projectId: "fir-notification-216ed",
        databaseURL: "https://fir-notification-216ed-default-rtdb.firebaseio.com",
        storageBucket: "fir-notification-216ed.appspot.com",
        messagingSenderId: "268566207438",
        appId: "1:268566207438:web:e7b57b412477b95cbaa99f",
        measurementId: "G-VJBSG41916"
    };
    firebase.initializeApp(firebaseConfig);
    const messaging = firebase.messaging();
    initFirebaseMessagingRegistration();
    function initFirebaseMessagingRegistration()
    {
        messaging
        .requestPermission()
        .then(function(){
            return messaging.getToken()
        })
        .then(function(token) {
            $('#device_token').val(token);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{ route("save-token") }}',
                type: 'POST',
                data: {
                    token: token
                },
                dataType: 'JSON',
                success: function (response) {
                    console.log('Token saved successfully.');
                },
                error: function (err) {
                    console.log(err);
                },
            });
        })
        .catch(function (err) {
            console.log('User Chat Token Error'+ err);
        });
    }

    messaging.onMessage(function(payload) {
        const noteTitle = payload.notification.title;
        const noteOptions = {
        body: payload.notification.body,
        icon: payload.notification.icon,
    };
    new Notification(noteTitle, noteOptions);
});
</script>
<script src="{{ asset('js/bootstrap.bundle.min.js')}}"></script>
<script src="{{ asset('js/adminlte.min.js')}}"></script>
@yield('js')
<script src="{{ asset('js/my.js') }}"></script>
</body>
</html>
