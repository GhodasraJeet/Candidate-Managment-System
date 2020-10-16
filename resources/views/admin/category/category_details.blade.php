@extends('admin.layouts.app')
@section('title','Details of Category')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" />

@endsection
@section('content')


<div class="content">
    <div class="py-4 px-3 px-md-4" id="deleteCandidate">
        <div class="card mb-3 mb-md-4">
            <div class="card-body">
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

                <div class="mb-3 mb-md-4 d-flex justify-content-between">
                    <div class="h3 mb-0">Category Lists</div>
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
                {{-- <div class="table-responsive"> --}}
                    <table class="table table-bordered table-hover table-striped" id="categoryDetails">
                        <thead align="center">
                        <tr>
                            <th>name</th>
                            <th>created_at</th>
                            <th>action</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                {{-- </div> --}}
                <!-- End Users -->
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
 load_data();
 function load_data(from_date = '', to_date = '')
 {
    $('#categoryDetails').DataTable({
        "processing": true,
        "serverSide":true,
        "responsive": true,
        ajax:{
            url:'{{route("admincategory.index")}}',
            data:{from_date:from_date, to_date:to_date}
        },
        columns:[
            {data:"name",className:"name"},
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
   $('#categoryDetails').DataTable().destroy();
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
  $('#categoryDetails').DataTable().destroy();
  load_data();
 });
    $('body').on('click', '.deleteCategory', function () {
     var product_id = $(this).data("id");
     console.log("{{ route('hrcategory.index') }}"+'/'+product_id);
     confirm("Are You sure want to delete !");

     $.ajax({
         type: "DELETE",
         url: "{{ route('admincategory.index') }}"+'/'+product_id,
         success: function (data) {
            $('#categoryDetails').DataTable().ajax.reload();
            console.log(data);
            var r=JSON.parse(data);
            if(r.status==true)
            {
                $alert="<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Danger</strong>"+
                r.msg+"<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                $('#deleteCandidate').prepend($alert);
            }
            else
            {
                $alert="<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Danger</strong>"+
                r.msg+"<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                $('#deleteCandidate').prepend($alert);
            }
         },
         error: function (data) {
             console.log('Error:', data);
         }
     });
 });
});
</script>
@endsection



