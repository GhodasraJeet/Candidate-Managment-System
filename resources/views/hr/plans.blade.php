@extends('hr.layouts.app')
@section('content')

@if ($message = Session::get('success'))
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

<div class="container" id="plan">
    <div class="row justify-content-center">
        <div class="col-md-12 d-flex my-5 flex-wrap">
            @foreach($plans as $plan)
            <div class="card">
                <div class="card-header"><h3>{{ $plan->name }}</h3></div>
                <div class="card-body">
                    <h5>{{ $plan->description }}</h5>
                    <h5 class="font-weight-bold">Rs {{ number_format($plan->cost, 2) }}/- Monthly</h5>
                    <a href="{{ route('plans.show', $plan->slug) }}" class="btn btn-primary btn-block pull-right mt-3">Select</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
