@extends('hr.layouts.app')
@section('title','Welcome To HR')
@section('content')

<section class="content">
    <div class="container-fluid">
        @if ($message = Session::get('success'))
        @component('alert')
            @slot('class')
                success
            @endslot
            @slot('tag')
                Success
            @endslot
            @slot('message')
            {{$message}}
            @endslot
        @endcomponent
    @endif

    <h5 class="my-3">Dashboard</h5>
            <div class="row">
            <div class="col-md-3 col-sm-6 col-12">
                <a href="{{ route('interview.index') }}" class="text-dark">
                <div class="info-box">
                    <span class="info-box-icon bg-info"><i class="far fa-user"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Candidates</span>
                        <span class="info-box-number">{{ $interview }}</span>
                    </div>
                </div>
            </a>
            </div>
            <div class="col-md-3 col-sm-6 col-12">
                <a href="{{ route('category.index') }}" class="text-dark">
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="nav-icon fas fa-chart-pie"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Categories</span>
                            <span class="info-box-number">{{ $category }}</span>
                        </div>
                </div>
            </a>
            </div>
            </div>
            @if (Auth::user()->subscribed())
            <div class="row">
                <div class="col-md-12">
                    <div class="card border-primary mb-3" style="max-width: 18rem;">
                        <div class="card-header">Current Plan</div>
                        <div class="card-body text-primary">
                        <h5 class="card-title">{{ $currentPlan[0]->name }}</h5>
                          <p class="card-text">{{ $currentPlan[0]->description }}</p>
                          <code>Rs. {{ $currentPlan[0]->cost }}</code>
                          <a href="{{route('cancel')}}" class="btn btn-danger d-block my-4">Cancel Subscription</a>
                        </div>
                      </div>
                </div>
            </div>
            @endif
    </div>
</section>
@endsection

@section('js')

@endsection
