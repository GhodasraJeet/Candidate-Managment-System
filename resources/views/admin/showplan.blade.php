@extends('admin.layouts.app')
@section('content')

@if ($message = Session::get('success'))
@component('alert')
    @slot('class')
        success
    @endslot
    @slot('tag')
        success
    @endslot
    @slot('message')
    {{$message}}
    @endslot
@endcomponent
@endif
@if ($message = Session::get('danger'))
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
    <div class="float-right">
        <a href="{{route('create.plan')}}" class="btn btn-primary">Create Plan</a>
    </div>
    <div class="clearfix"></div>
    <div class="row justify-content-center">
        <div class="col-md-12 d-flex my-5 flex-wrap">
            @foreach($plans as $plan)
            <div class="card">
                <div class="card-header"><h3>{{ $plan->name }}</h3></div>
                <div class="card-body">
                    <h5>{{ $plan->description }}</h5>
                    <h5 class="font-weight-bold">Rs {{ number_format($plan->cost, 2) }}/- Monthly</h5>
                    <a href="{{route('plan.edit',$plan->id)}}" class="mt-4 btn btn-block btn-outline-primary pull-right">Edit</a>
                    <form action="{{ route('plan.destroy', $plan->id) }}" method="post">
                        @method('delete')
                        @csrf
                        <input type="submit" class="btn btn-block btn-outline-danger pull-right" value="Delete">
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="row text-center">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>User Id</th>
                        {{-- <th>Subscription</th> --}}
                        {{-- <th>Status</th> --}}
                        {{-- <th>Download Invoice</th> --}}
                    </tr>
                </thead>
                <tbody>
                @forelse ($customer as $details)
                <tr>

                    <td>{{ $details->email }}</td>
                    <td>{{ $details->id }}</td>
                    <td>{{ $details->subscription }}</td>
                    {{-- <td>@if($details->status=="paid") <i class="ion ion-checkmark text-green"></i> {{ ucfirst($details->status) }} @endif </td>
                    <td><a href="{{ $details->hosted_invoice_url }}" class="btn btn-primary">Download</a></td> --}}
                    {{-- <td><a href="/user/invoice/{{ $details->id }}">Download</a></td> --}}
                </tr>
                @empty

                @endforelse
            </tbody>
        </table>
        </div>
    </div>
</div>
@endsection
