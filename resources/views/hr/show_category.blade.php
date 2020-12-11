@extends('hr.layouts.app')
@section('title','Display Single Category')

@section('content')

<div class="content">
    <div class="container">

        <h2 class="text-center my-5">Display Category</h2>
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
                <div class="form-group">
                    <label for="categoryname">Name</label>
                    <input type="text" name="categoryname" id="categoryname" class="form-control" value="{{ $categoryfulldetails->name }}" disabled>
                </div>
                <div class="form-group">
                    <label for="createdat">Created at</label>
                    <input type="text" class="form-control" value="{{ $categoryfulldetails['created_at'] }}" disabled>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
