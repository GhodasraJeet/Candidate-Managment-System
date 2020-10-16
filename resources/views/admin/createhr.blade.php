@extends('admin.layouts.app')
@section('title','Add new HR')
@section('content')

<div class="container">
    <h2 class="text-center">Add New HR</h2>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12">
        <form action="{{ route('hr.store') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="hrname">Name</label>
                <input type="text" name="hrname" class="form-control" value="{{ old('hrname') }}" placeholder="Enter Name">
                @if($errors->has('hrname'))
                    <p class="text-danger">{{ $errors->first('hrname') }}</p>
                @endif
            </div>
            <div class="form-group">
                <label for="hremail">Email</label>
                <input type="email" name="hremail" class="form-control" value="{{ old('hremail') }}" placeholder="Enter Email">
                @if($errors->has('hremail'))
                    <p class="text-danger">{{ $errors->first('hremail') }}</p>
                @endif
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" value="{{ old('password') }}" placeholder="Enter Password">
                @if($errors->has('password'))
                    <p class="text-danger">{{ $errors->first('password') }}</p>
                @endif
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" value="{{ old('password_confirmation') }}" placeholder="Enter Confirm Password">
                @if($errors->has('password_confirmation'))
                    <p class="text-danger">{{ $errors->first('password_confirmation') }}</p>
                @endif
            </div>
            <input type="submit" class="btn btn-primary" value="Add">
        </form>
        <div>
    </div>
</div>

@endsection
