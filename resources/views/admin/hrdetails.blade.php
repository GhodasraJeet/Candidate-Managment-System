@extends('admin.layouts.app')
@section('title','Details of HR')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" />
@endsection
@section('content')

<div class="content">
    <div class="container">
    <div class="py-4 px-3 px-md-4">

                <div class="alert alert-danger alert-dismissible fade mb-3" id="danger" role="alert">
                    <strong>Delete</strong> HR deleted successfully...!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>

                @if ($message = Session::get('success'))

                <div class="alert alert-success alert-left-bordered border-success alert-dismissible d-flex align-items-center p-md-4 mb-2 fade show" role="alert">
                    <i class="gd-check-box icon-text text-success mr-2"></i>
                    <p class="mb-0">
                      <strong>Success</strong> {{ $message }}
                    </p>
                    <button type="button" class="close" aria-label="Close" data-dismiss="alert">
                      <i class="gd-close icon-text icon-text-xs" aria-hidden="true"></i>
                    </button>
                  </div>
                  @endif
                  @if ($message = Session::get('warning'))
                  <div class="alert alert-danger alert-left-bordered border-danger alert-dismissible d-flex align-items-center p-md-4 mb-2 fade show" role="alert">
                    <p class="mb-0">
                      <strong>Warning</strong> {{ $message }}
                    </p>
                    <button type="button" class="close" aria-label="Close" data-dismiss="alert">
                      <i class="gd-close icon-text icon-text-xs" aria-hidden="true"></i>
                    </button>
                  </div>

                @endif




                <div class="mb-3 mb-md-4 d-flex justify-content-between">

                    <div class="h3 mb-0">Hr Lists</div>

                </div>
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

                <!-- Users -->
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped" id="hrDetails">
                        <thead align="center">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Registration Date</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody align="center">



                        </tbody>
                    </table>

                </div>
                <!-- End Users -->
            </div>

</div>
</div>
@endsection


@section('js')
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('js/responsive.bootstrap4.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script><script>
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

    load_data();

    function load_data(from_date = '', to_date = '')
    {
        $('#hrDetails').DataTable({
        "processing": true,
        "serverSide":true,
        "responsive":true,
        ajax:{
            url:"{{route('hr.index')}}",
            data:{from_date:from_date, to_date:to_date}
        },
        columns:[
            {data:"name",className:"name"},
            {data:"email",className:"email"},
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
        $('#hrDetails').DataTable().destroy();
        load_data(from_date, to_date);
    }
    else
    {
        alert('Both Date is required');
    }
});

    $('#refresh').click(function(){
        $('#from_date').val('');
        $('#to_date').val('');
        $('#hrDetails').DataTable().destroy();
        load_data();
    });

    $('body').on('click', '.deleteHr', function () {
        var product_id = $(this).data("id");
        if(confirm("Are You sure want to delete !"))
        {
            $.ajax({
            type: "DELETE",
            url: "{{ route('hr.index') }}"+'/'+product_id,
            success: function (data) {
                $('#hrDetails').DataTable().ajax.reload();
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
