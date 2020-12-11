@extends('admin.layouts.app')
@section('content')
<div class="container">
    <div class="float-left">
        <a href="{{route('plan.index')}}" class="btn btn-primary">Back</a>
    </div>
    <div class="clearfix"></div>
    <div class="card" style="width:24rem;margin:auto;">
        <div class="card-body">
            <form action="{{route('plan.update',$plan->id)}}" method="post">
                @csrf
                @method('put')
                <div class="form-group">
                    <label for="plan name">Plan Name:</label>
                    <input type="text" class="form-control" name="name" value="{{ $plan->name }}">

                </div>
                <div class="form-group">
                    <label for="cost">Plan Cost:</label>
                    <input type="text" class="form-control" name="cost" value="{{ $plan->cost }}">

                </div>
                <div class="form-group">
                    <label for="cost">Plan Description:</label>
                    <input type="text" class="form-control" name="description" value="{{ $plan->description }}">

                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>
@endsection
