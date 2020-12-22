<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Log in</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="{{ asset('css/css/all.min.css') }}">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="{{ asset('css/adminlte.min.css')}}">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <style>
    input,.login-card-body .input-group .input-group-text, .register-card-body .input-group .input-group-text
    {
        border-color: blue !important;
    }
    .input-group .input-group-append .input-group-text
    {
        color: blue;
    }
  </style>
</head>
<body class="hold-transition login-page">

    {{-- Display warning alert on delete --}}

    @if ($message = Session::get('warning'))
        @component('alert')
            @slot('class')
                danger
            @endslot
            @slot('tag')
                Danger
            @endslot
            @slot('message')
            {{$message}}
            @endslot
        @endcomponent
    @endif

    {{-- Display warning alert on unexpected error. --}}

    @if (session('error'))
        @component('alert')
            @slot('class')
                danger
            @endslot
            @slot('tag')
                Danger
            @endslot
            @slot('message')
            {{ session('error') }}
            @endslot
        @endcomponent
    @endif

<div class="login-box">
  <div class="login-logo">
    <b>Candidate Managment System</b>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <form action="{{ route('submitLogin') }}" method="post">
        @csrf
        <div class="input-group mb-3">
          <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Email" autofocus>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        @if ($errors->has('email'))
        <span role="alert">
            <p class="text-danger">{{ $errors->first('email') }}</p>
        </span>
    @endif
        <div class="input-group mb-3 mt-3">
          <input type="password" name="password" class="form-control" value="{{ old('password') }}" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        @if ($errors->has('password'))
          <span role="alert">
              <p class="text-danger">{{ $errors->first('password') }}</p>
          </span>
      @endif
      <input type="hidden" name="device_token" id="device_token">
        <div class="row mt-3">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script src="https://www.gstatic.com/firebasejs/7.16.1/firebase.js"></script>

<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js')}}"></script>
<script src="{{ asset('js/adminlte.min.js')}}"></script>
<script src="https://www.gstatic.com/firebasejs/7.16.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.16.1/firebase-messaging.js"></script>
</body>
</html>
