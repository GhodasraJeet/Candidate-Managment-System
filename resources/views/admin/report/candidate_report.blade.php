@extends('admin.layouts.app')
@section('title','Candidate Report')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
@endsection


@section('content')
    <div class="content">
        <div class="py-4 px-3 px-md-4">
            <h2 class="mb-4">Candidate Reports</h2>

            <div class="row input-daterange align-items-end my-5">
                <div class="col-md-4">
                    <label for="">From Date</label>
                    <input type="date" name="start_date" id="start_date" class="form-control border border-primary" placeholder="From Date"  />
                </div>
                <div class="col-md-4">
                    <label for="">To Date</label>
                    <input type="date" name="end_date" id="end_date" class="form-control border border-primary" placeholder="To Date"  />
                </div>
                <div class="col-md-4">
                    <div class="btn-group">
                    <button type="button" name="Generate" id="Generate" class="btn btn-primary ">Filter</button>
                    <button type="button" name="reset" id="reset" class="btn btn-default">Refresh</button>
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
    const table=$('#interviewreport-table');
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
</script>
@endsection
