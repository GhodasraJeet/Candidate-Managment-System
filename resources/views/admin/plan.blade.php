@extends('admin.layouts.app')
@section('content')
<div class="container">
    <div class="float-left">
        <a href="{{route('plan.index')}}" class="btn btn-primary">Back</a>
    </div>
    <div class="clearfix"></div>
    <div class="card" style="width:24rem;margin:auto;">
        <div class="card-body">
            <form action="{{route('store.plan')}}" method="post">
                @csrf
                <div class="form-group">
                    <label for="plan name">Plan Name:</label>
                    <input type="text" class="form-control" name="name" placeholder="Enter Plan Name">
                    @if($errors->has('name'))
                        <p class="text-danger">{{ $errors->first('name') }}</p>
                    @endif
                </div>
                <div class="form-group">
                    <label for="cost">Plan Cost:</label>
                    <input type="text" class="form-control" name="cost" placeholder="Enter Cost">
                    @if($errors->has('cost'))
                        <p class="text-danger">{{ $errors->first('cost') }}</p>
                    @endif
                </div>
                <div class="form-group">
                    <label for="cost">Plan Description:</label>
                    <input type="text" class="form-control" name="description" placeholder="Enter Description">
                    @if($errors->has('description'))
                        <p class="text-danger">{{ $errors->first('description') }}</p>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection
