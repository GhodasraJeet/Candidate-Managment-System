@extends('admin.layouts.app')
@section('content')


<div class="content-header">
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <center>
                <button id="btn-nft-enable" onclick="initFirebaseMessagingRegistration()" class="btn btn-danger btn-flat">Allow for Notification</button>
            </center>
                <h2 class="my-3">{{ __('Notification') }}</h2>

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form action="{{ route('send.notification') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" class="form-control" name="title" placeholder="Notification Title" value="{{ old('title') }}">
                            @if ($errors->has('title'))
                                <span role="alert">
                                    <p class="text-danger">{{ $errors->first('title') }}</p>
                                </span>
                            @endif
                            <input type="hidden" name="device_token" id="device_token">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" name="body">{{ old('body') }}</textarea>
                            @if ($errors->has('body'))
                                <span role="alert">
                                    <p class="text-danger">{{ $errors->first('body') }}</p>
                                </span>
                            @endif
                          </div>
                        <button type="submit" class="btn btn-primary">Send Notification</button>
                    </form>
        </div>
    </div>
</div>
</div>
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
    function initFirebaseMessagingRegistration()
    {
        messaging
        .requestPermission()
        .then(function () {
            return messaging.getToken()
        })
        .then(function(token) {
            console.log(token);
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
                    alert('Token saved successfully.');
                },
                error: function (err) {
                    console.log('User Chat Token Error'+ err);
                },
            });
        })
        .catch(function (err) {
            console.log('User Chat Token Error'+ err);
        });
    }

    messaging.onMessage(function(payload) {
        console.log(payload);
        const noteTitle = payload.notification.title;
        const noteOptions = {
            body: payload.notification.body,
            icon: payload.notification.icon,
        };
    new Notification(noteTitle, noteOptions);
});
</script>
@endsection
