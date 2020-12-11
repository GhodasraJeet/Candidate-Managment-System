@extends('admin.layouts.app')
@section('title','Details of Interview')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
@endsection

@section('content')
<div class="content">
    <div class="py-4 px-3 px-md-4" id="deleteCandidate">
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
    <h2>Candidate Details</h2>

    {{--  Display Add New HR Message --}}

    <div class="row input-daterange my-3">
        <div class="col-md-3">
            <label for="">From Date</label>
            <input type="date" name="start_date" id="start_date" class="form-control border border-primary" placeholder="From Date"  />
        </div>
        <div class="col-md-3">
            <label for="">To Date</label>
            <input type="date" name="end_date" id="end_date" class="form-control border border-primary" placeholder="To Date"  />
        </div>
        <div class="col-md-3">
            <label for="">Choose Category</label>
            <select class="form-control border border-primary" id="category">
                <option value="">All</option>
                @forelse ($category as $item)
                    <option value={{$item->id}}>{{$item->name}}</option>
                @empty
                    <option value="">No Category Found</option>
                @endforelse
            </select>
        </div>
        <div class="col-md-3">
            <label for="">Choose HR</label>
            <select class="form-control border border-primary" id="hr">
                <option value="">All</option>
                @forelse ($hr as $item)
                    <option value={{$item->id}}>{{$item->name}}</option>
                @empty
                    <option value="">No HR Found</option>
                @endforelse
            </select>
        </div>
    </div>
    <div class="row justify-content-center mb-5">
        <div class="btn-group">
            <button type="button" name="Generate" id="Generate" class="btn btn-primary ">Filter</button>
            <button type="button" name="reset" id="reset" class="btn btn-default">Refresh</button>
        </div>
    </div>

    <div class="clearfix"></div>
        <div class="table-responsive">

            {!! $dataTable->table() !!}
            {!! $dataTable->scripts() !!}

        </div>
    </div>

</div>
@endsection
@section('js')
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
<script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
<script>
    const table=$('#interviewer-table');
    table.on('preXhr.dt',function(e,settings,data){
       data.start_date=$('#start_date').val();
       data.end_date=$('#end_date').val();
       data.category=$('#category').val();
       data.hr=$('#hr').val();
    });
    $('#Generate').on('click',function(){
        table.DataTable().ajax.reload();
        return false;
    });
    $('#reset').on('click',function(){
        $('#start_date').val(" ");
        $('#end_date').val(" ");
       table.on('preXhr.dt',function(e,settings,data){
       data.start_date='';
       data.end_date='';
       data.category='';
       data.hr='';
       });
       table.DataTable().ajax.reload();
        return false;
    });

    $('#category').on('change',function(){
        table.DataTable().ajax.reload();
    });
    $('#hr').on('change',function(){
        table.DataTable().ajax.reload();
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
    });

    $('body').on('click', '.deleteCandidate', function () {
        var product_id = $(this).data("id");
        if(confirm("Are You sure want to delete !"))
        {
            $.ajax({
            type: "DELETE",
            url: "{{ route('candidates.index') }}"+'/'+product_id,
            success: function (data) {
                console.log(data);
                    $('#interviewer-table').DataTable().ajax.reload();
                    var r=JSON.parse(data);
            if(r.status==true)
            {
                $alert="<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Danger</strong>"+
                r.msg+"<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                $('#deleteCandidate').prepend($alert);
                setTimeout(() => {
                $('.alert').alert('dispose');
                    $(".alert").slideUp(500);
                }, 4000);
            }
            else
            {
                $alert="<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Danger</strong>"+
                r.msg+"<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                $('#deleteCandidate').prepend($alert);
                setTimeout(() => {
                $('.alert').alert('dispose');
                    $(".alert").slideUp(500);
                }, 4000);
            }
                },
            error: function (data) {
                    console.log('Error:', data);
                }
            });
        }
        else
        {
            return false;
        }
    });
</script>

@endsection
