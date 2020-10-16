@extends('hr.layouts.app')
@section('title','Details of Interview')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" />
@endsection
@section('content')

<div class="content">

<div class="container">


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
        {{ $message }}
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
            {{ $message }}
        @endslot
    @endcomponent

    @endif
    <h2 class="mt-5">My Candidate Details</h2>

    {{--  Display Add New HR Message --}}

    <div class="row input-daterange my-5">
        <div class="col-md-4">
            <input type="text" name="from_date" id="from_date" class="form-control border border-primary" placeholder="From Date" readonly />
        </div>
        <div class="col-md-4">
            <input type="text" name="to_date" id="to_date" class="form-control border border-primary" placeholder="To Date" readonly />
        </div>
        <div class="col-md-4">
            <div class="btn-group">
            <button type="button" name="filter" id="filter" class="btn btn-primary">Filter</button>
            <button type="button" name="refresh" id="refresh" class="btn btn-default">Refresh</button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="table-responsive">
            <table class="table" id="candidateDetails">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>OtherPhone</th>
                        <th width="40%">
                            <select name="category_filter" id="category_filter" class="form-control">
                                <option value="">Select Category</option>
                                    @foreach($category as $row)
                                <option value="{{ $row->id }}">{{ $row->name }}</option>
                                    @endforeach
                            </select>
                        </th>
                        <th>Experince</th>
                        <th>Current Salary</th>
                        <th>Expected Salary</th>
                        <th>Graduation</th>
                        <th>Practical Remarks</th>
                        <th>Technical Remarks</th>
                        <th>General Remarks</th>
                        <th>Created_at</th>
                        <th>Operations</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>

</div>
@endsection
@section('js')
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('js/responsive.bootstrap4.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>
<script>
$(document).ready(function(){

    $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });

    $('.input-daterange').datepicker({
        todayBtn:'linked',
        format:'yyyy-mm-dd',
        autoclose:true
    });

    fetchCategory();

    $('#category_filter').change(function(){
        var category_id = $('#category_filter').val();
        $('#candidateDetails').DataTable().destroy();
        fetchCategory(category_id);
    });

    function fetchCategory(category='',from_date = '', to_date = '')
    {
        $('#candidateDetails').DataTable({
        "processing": true,
        "serverSide":true,
        "responsive":true,
        ajax:{
            url:"{{route('hrinterview.mycandidate')}}",
            data: {category:category,from_date:from_date, to_date:to_date},
        },
        columns:[
            {data:"name",className:"name"},
            {data:"email",className:"email"},
            {data:"phone",className:"phone"},
            {data:"other_phone",className:"other_phone"},
            {data:"category",className:"category",orderable:false},
            {data:"experience",className:"experience"},
            {data:"current_salary",className:"current_salary"},
            {data:"expected_salary",className:"expected_salary"},
            {data:"graduation",className:"graduation"},
            {data:"practical_remarks",className:"practical_remarks"},
            {data:"technical_remarks",className:"technical_remarks"},
            {data:"general_remarks",className:"general_remarks"},
            {data:"created_at",className:"created_at"},
            {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }

    $('#filter').click(function(){
        var from_date = $('#from_date').val();
        var to_date = $('#to_date').val();
        if(from_date != '' &&  to_date != '')
        {
            $('#candidateDetails').DataTable().destroy();
            fetchCategory('',from_date, to_date);
        }
        else
        {
            alert('Both Date is required');
        }
    });


    $('#refresh').click(function(){
        $('#from_date').val('');
        $('#to_date').val('');
        $('#candidateDetails').DataTable().destroy();
        fetchCategory();
    });


    $('body').on('click', '.deleteCandidate', function () {
     var product_id = $(this).data("id");
     if(confirm("Are You sure want to delete !"))
     {
        $.ajax({
         type: "DELETE",
         url: "{{ route('hrinterview.index') }}"+'/'+product_id,
         success: function (data) {
            $('#candidateDetails').DataTable().ajax.reload();
            $('#danger').addClass('show');
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
});
</script>
@endsection
