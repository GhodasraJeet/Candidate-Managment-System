@extends('admin.layouts.app')
@section('title','Display Single Category')
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
        <h2 class="text-center my-5">Display Category</h2>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="categoryname">Name</label>
                    <input type="text" name="categoryname" id="categoryname" class="form-control" value="{{ $categoryfulldetails->name }}" placeholder="Enter Name" disabled>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
