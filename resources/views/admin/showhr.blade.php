@extends('admin.layouts.app')
@section('title','Display Single HR')
@section('content')

{{-- Display single HR --}}

<div class="content">
    <div class="container">
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
        @if ($message = Session::get('warning'))
        @component('alert')
            @slot('class')
                warning
            @endslot
            @slot('tag')
                Warning
            @endslot
            @slot('message')
            {{$message}}
            @endslot
    @endcomponent
    @endif
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
    <h2 class="text-center mb-5">HR Details</h2>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="hrname">Name</label>
                <input type="text" name="hrname" class="form-control" value="{{ $hrfulldetails->name }}" disabled>
            </div>
            <div class="form-group">
                <label for="hremail">Email</label>
                <input type="text" name="hremail" class="form-control" value="{{ $hrfulldetails->email }}" disabled>
            </div>
            <div class="form-group">
                <label for="hrcreatedat">Created at</label>
                <input type="text" name="hrcreatedat" class="form-control" value="{{ $hrfulldetails['created_at'] }}" disabled>
            </div>
            <div class="form-group">
                <label for="">Candidate List</label>
                <select name="" id="" class="form-control" multiple disabled>
                    @forelse ($hrfulldetails->getCandidate as $item)
                    <option value="">{{$item->name}}</option>
                    @empty
                        <option>No Found</option>
                    @endforelse
                </select>
            </div>
        </div>
    </div>
</div></div>
@endsection
