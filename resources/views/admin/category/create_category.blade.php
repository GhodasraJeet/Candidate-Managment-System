@extends('admin.layouts.app')
@section('title','Add New Category')
@section('content')

<div class="content">
<div class="container">
    <h2 class="text-center mt-5">Add New Category</h2>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12">
        <form action="{{ route('admincategory.store') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="categoryname">Category Name</label>
                <input type="text" name="categoryname" id="categoryname" class="form-control" value="{{ old('categoryname') }}" placeholder="Enter Category Name" autofocus>
                @if($errors->has('categoryname'))
                    <p class="text-danger">{{ $errors->first('categoryname') }}</p>
                @endif
            </div>
            <input type="submit" class="btn btn-primary" value="Add">
        </form>
        <div>
    </div>
</div>
</div>
@endsection
