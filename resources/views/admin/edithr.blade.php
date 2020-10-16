@extends('admin.layouts.app')
@section('title','Edit HR')
@section('content')

<div class="content">
<div class="container">
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
    <h2 class="text-center">Edit HR</h2>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12">
        <form action="{{ route('hr.update',$hrfulldetails->id) }}" method="post">
            @csrf
            @method('put')
            <div class="form-group">
                <label for="hrname">Name</label>
                <input type="text" name="hrname" class="form-control" value="{{ $hrfulldetails->name }}" placeholder="Enter Name">
                @if($errors->has('hrname'))
                    <p class="text-danger">{{ $errors->first('hrname') }}</p>
                @endif
            </div>
            <div class="form-group">
                <label for="hremail">Email</label>
                <input type="email" name="hremail" class="form-control" value="{{ $hrfulldetails->email }}" placeholder="Enter Email">
                @if($errors->has('hremail'))
                    <p class="text-danger">{{ $errors->first('hremail') }}</p>
                @endif
            </div>
            <input type="submit" class="btn btn-primary" value="Update">
        </form>
        <div>
    </div>
</div>
    </div>
@endsection
