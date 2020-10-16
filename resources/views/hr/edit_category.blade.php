@extends('hr.layouts.app')
@section('title','Edit Category')
@section('content')
<div class="content">
<div class="container">

    <h2 class="text-center my-5">Edit Category</h2>

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
    <div class="row">
        <div class="col-md-12">
        <form action="{{ route('hrcategory.update',$categoryfulldetails->id) }}" method="post">
            @csrf
            @method('put')
            <div class="form-group">
                <label for="categoryname">Name</label>
                <input type="text" name="categoryname" id="categoryname" class="form-control" value="{{ $categoryfulldetails->name }}" placeholder="Enter Name">
                @if($errors->has('categoryname'))
                    <p class="text-danger">{{ $errors->first('categoryname') }}</p>
                @endif
            </div>
            <input type="submit" class="btn btn-primary" value="Update">
        </form>
        <div>
    </div>
</div>
</div>

@endsection
