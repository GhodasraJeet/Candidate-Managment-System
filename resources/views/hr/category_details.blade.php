@extends('hr.layouts.app')
@section('title','Details of Category')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
@endsection
@section('content')

<div class="content">
    <div class="py-4 px-3 px-md-4" id="deleteCandidate">

    {{-- Display error message on alert.blade.php unhandled event --}}

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

    {{-- Display error message on alert.blade.php success --}}

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

    {{-- Display error message on alert.blade.php warning --}}

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

    <div class="mb-3 mb-md-4 d-flex justify-content-between">
        <div class="h3 mb-0">Add Category</div>
    </div>


    <form action="{{ route('category.store') }}" method="post">
        @csrf
        <div class="form-row">
            <div class="form-group col-md-10">
                <input type="text" name="categoryname" id="categoryname" class="form-control" value="{{ old('categoryname') }}" placeholder="Enter Category Name" autofocus>
                @if($errors->has('categoryname'))
                    <p class="text-danger">{{ $errors->first('categoryname') }}</p>
                @endif
            </div>
        <div class="form-group col-md-2">
            <button type="submit" class="btn btn-primary">Add Category</button>
        </div>
        </div>
    </form>
<hr>
<h2>Category Filter</h2>
    <div class="row input-daterange align-items-end my-5">
        <div class="col-md-4">
            <label for="start_date">From Date</label>
            <input type="date" name="start_date" id="start_date" class="form-control border border-primary" placeholder="From Date" />
        </div>
        <div class="col-md-4">
            <label for="end_date">To Date</label>
            <input type="date" name="end_date" id="end_date" class="form-control border border-primary" placeholder="To Date"  />
        </div>
        <div class="col-md-4">
            <div class="btn-group">
            <button type="button" name="filter" id="Generate" class="btn btn-primary">Filter</button>
            <button type="button" name="refresh" id="reset" class="btn btn-default">Refresh</button>
            </div>
        </div>
    </div>
        {!! $dataTable->table() !!}
        {!! $dataTable->scripts() !!}
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
    const table=$('#category-table');
    table.on('preXhr.dt',function(e,settings,data){
       data.start_date=$('#start_date').val();
       data.end_date=$('#end_date').val();
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
       });
       table.DataTable().ajax.reload();
        return false;

    });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('body').on('click', '.deleteCategory', function () {
     var product_id = $(this).data("id");
     confirm("Are You sure want to delete !");

     $.ajax({
         type: "DELETE",
         url: "{{ route('category.index') }}"+'/'+product_id,
         success: function (data) {
            $('#category-table').DataTable().ajax.reload();
            var r=JSON.parse(data);
            if(r.status==true)
            {
                $alert="<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Danger</strong>&nbsp;"+
                r.msg+"<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                $('#deleteCandidate').prepend($alert);
                setTimeout(() => {
                $('.alert').alert('dispose');
                    $(".alert").slideUp(500);
                }, 4000);
            }
            else
            {
                $alert="<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Danger</strong>&nbsp;"+
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
 });
</script>
@endsection



