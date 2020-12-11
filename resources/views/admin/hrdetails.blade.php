@extends('admin.layouts.app')
@section('title','Details of HR')
@section('css')
    {{-- <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css"> --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endsection
@section('content')

<div class="content">
    <div class="py-4 px-3 px-md-4" id="deleteHr">

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


    <div class="mb-3 mb-md-4 d-flex justify-content-between" id="next-alert">
        <div class="h3 mb-0">Hr</div>
    </div>

    <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#exampleModal">Add HR</button>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Add HR</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form id="save">
                  <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" name="name" id="name" placeholder="Enter Name" class="form-control">
                    <span id="error-name" class="text-danger"></span>
                  </div>
                  <div class="form-group">
                    <label for="">Email</label>
                    <input type="email" name="email" id="email" placeholder="Enter Email" class="form-control">
                    <span id="error-email" class="text-danger"></span>
                  </div>
                  <div class="form-group">
                    <label for="">Password</label>
                    <input type="text" name="password" id="password" placeholder="Enter Password" class="form-control">
                    <span id="error-password" class="text-danger"></span>
                  </div>
                  <button class="btn btn-primary">Save</button>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
    </div>
    <div class="modal fade" id="updateModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Update HR</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form id="update">
                  <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" name="name" id="update-name" placeholder="Enter HR" class="form-control" required>
                    <span id="name-error" class="text-danger"></span>
                  </div>
                  <div class="form-group">
                    <label for="">Email</label>
                    <input type="text" name="email" id="update-email" class="form-control" placeholder="Enter Email" required>
                    <span id="email-error" class="text-danger"></span>
                  </div>
                  <input type="hidden" id="hr_id" value="">
                  <button class="btn btn-primary">Update</button>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
    </div>
    <div class="modal fade" id="showModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Display HR</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form id="display-candidate">
                  <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" name="name" id="show-name" class="form-control" disabled>
                  </div>
                  <div class="form-group">
                    <label for="">Email</label>
                    <input type="text" name="email" id="show-email" class="form-control" disabled>
                  </div>
                  <label>Candidates</label>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
    </div>

    <div class="clearfix"></div>

    <input type="search" name="" id="search" placeholder="Search Here" class="form-control float-right my-2 px-3">
        <div class="clearfix"></div>
        <form method='post' action='{{ route("export")}}' class="my-3 float-right">
            {{ csrf_field() }}
            <input type="submit" name="exportexcel" value='Excel'>
            <input type="submit" name="exportcsv" value='CSV'>
            <input type="submit" name="exportpdf" value="PDF">
            <input type="hidden" name="page" id="current_page" value="">
          </form>

        <table class="table border text-center" id="category-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
        <div class="btn-group float-right mb-5">
            <button id="previous">Previous</button>
            <div class="pagination">
            </div>
            <button id="next">Next</button>
        </div>
    </div>
</div>



</div>
</div>
@endsection


@section('js')
{{-- <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
<script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script> --}}
<script>
  $(document).ready(function(){
            var data='';
            var current_page='';
            var page=1;
            var next_page='';
            var prev_page='';
            var total=0;

            $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            $('th').click(function(){
                var table=$(this).parents('table').eq(0);
                var rows=table.find('tr:gt(0)').toArray().sort(comparer($(this).index()));
                this.asc=!this.asc;
                if(!this.asc){
                    rows=rows.reverse();
                }
                for(var i=0;i<rows.length;i++){
                    table.append(rows[i]);
                }
            });

            function comparer(index){
                return function(a,b){
                    var valA=getCellValue(a,index),valB=getCellValue(b,index);
                    return $.isNumeric(valA) && $.isNumeric(valB) ? valA-valB:valA.toString().localeCompare(valB);
                }
            }

            function getCellValue(row,index){
                return $(row).children('td').eq(index).text();
            }

            fetchpage(page);

            $('#search').on('keyup',function(){
                var search= $(this).val().toLowerCase();
                searchMy(search);
            });

            function searchMy(search)
            {
                $('tbody tr').filter(function(){
                    $(this).toggle($(this).text().toLowerCase().indexOf(search)>-1);
                });
            }

            function fetchpage(page)
            {
                $('tbody,.pagination').empty();
                $.ajax({
                    type:'get',
                    url:"{{ route('hr.create') }}",
                    data:{
                        page:page
                    },
                    success:function(data){
                        current_page=data.current_page;
                        $('#current_page').val(current_page);
                        next_page=data.next_page;
                        prev_page=data.prev_page;
                        total=data.total;
                        // console.log(total);

                        if(data.next_page==null){
                            $('#next').hide();
                        }
                        else{
                            $('#next').show();
                        }
                        if(data.prev_page!=null){
                            $('#previous').show();
                        }
                        else{
                            $('#previous').hide();
                        }

                        for(var i=0;i<data.data.length;i++)
                        {
                            $('table').append('<tr><td>'+data.data[i].name+'</td><td>'+data.data[i].email+'</td><td><i class="fa fa-eye text-active mr-4" id="show" data-id='+data.data[i].id+'></i><i class="fa fa-trash delete-btn text-danger mr-4" data-id='+data.data[i].id+'></i><i class="fa fa-edit update-btn text-info" data-id='+data.data[i].id+'></i></td></tr>');

                        }
                        for(var j=1;j<=data.last_page;j++)
                        {
                            if(current_page==j){
                                $('.pagination').append('<button class="active page" data-page="'+j+'">'+j+'</button>');
                            }
                            else{
                                $('.pagination').append('<button class="page" data-page="'+j+'">'+j+'</button>');
                            }
                        }
                    }
                });
            }

            // Next and Previous Button
            $('#next').on('click',function(){
                fetchpage(current_page+1);
            });
            $('#previous').on('click',function(){
                fetchpage(current_page-1);
            });
            //  Pagination Change
            $(document).on('click','.page',function(){
                var page=$(this).attr('data-page');
                fetchpage(page);
            });
            // Delete Category
            $(document).on("click",".delete-btn",function(){
                var current=$(this);
                if(confirm('Are you sure you want to delete ?'))
                {
                    var hrid=$(this).data('id');
                    $.ajax({
                        type:"DELETE",
                        url:"{{ route('hr.destroy',['id'=>"+hrid+"]) }}",
                        data:{
                            hrid:hrid
                        },
                        success:function(data){
                            var r=JSON.parse(data);
                            console.log(r);
                            if(r.success==true){
                                $('#next-alert').after('<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Danger </strong>'+r.message+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                                fetchpage(current_page);
                            }
                            else if(r.success==false){
                                alert(r.message);
                            }
                        }
                    });
                }
                else{
                    return false;
                }
            });
            // Save Category
            $('#save').submit(function(e){
                var name=$('#name').val();
                var email=$('#email').val();
                var password=$('#password').val();
                // alert(name+" "+password);
                $('#error-name,#error-email').html(' ');
                e.preventDefault();
                $.ajax({
                    url:'{{route("hr.store")}}',
                    method:'POST',
                    data:{
                            name:name,
                            email:email,
                            password:password
                    },
                    success:function(response){
                        var r=JSON.parse(response);
                        if(r.success==true)
                        {
                            $('#exampleModal').modal('hide');
                            $('#next-alert').after('<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Success </strong>'+r.message+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                            fetchpage(current_page);
                        }
                        else if(r.success==false)
                        {
                            $('#error-name').html(r.data.name);
                            $('#error-email').html(r.data.email);
                            $('#error-password').html(r.data.password);
                        }
                    },
                    error:function(error){
                        console.log(error)
                    }
                    });
            });
            // Update Model Manage
            $(document).on('click','.update-btn',function(){
                var hr_id=$(this).data('id');
                $('#updateModel').modal('show');
                $.ajax({
                        type:'get',
                        url:"{{ route('hr.show',['id'=>"+hr_id+"]) }}",
                        data:{
                            hrid:hr_id
                        },
                        success:function(data){
                            var r=JSON.parse(data);
                            $('#update-name').val(r.data.name);
                            $('#update-email').val(r.data.email);
                            $('#hr_id').val(r.data.id);
                        }
                    });
            });
            //  Update Data
            $('#update').submit(function(e){
                e.preventDefault();
                var name=$('#update-name').val();
                var email=$('#update-email').val();
                var id=$('#hr_id').val();
                var url="{{ route('hr.update',['id'=>"+id+"]) }}";
                $.ajax({
                    url:url,
                    method:'POST',
                    data:{
                        name:name,
                        email:email,
                        id:id,
                        _method:"put"
                    },
                    success:function(response){
                        var r=JSON.parse(response);
                        if(r.success==true){
                            $('#updateModel').modal('hide');
                            $('#next-alert').after('<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Success </strong>'+r.message+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                            fetchpage(current_page);
                        }
                        else if(r.success==false){
                            console.log(r);
                            $('#name-error').html(r.data.name);
                            $('#email-error').html(r.data.email);
                        }
                    },
                    error:function(error){
                        console.log(error)
                    }
                    });
            });
            // Display Single Data
            $(document).on("click",'#show',function(){
                $('#showModel').modal(show);
                $('.list-group').empty();
                var hr_id=$(this).data('id');
                $.ajax({
                        type:'get',
                        url:"{{ route('hr.show',['id'=>"+hr_id+"]) }}",
                        data:{
                            hrid:hr_id
                        },
                        success:function(data){
                            var r=JSON.parse(data);
                            $('#show-name').val(r.data.name);
                            $('#show-email').val(r.data.email);
                            console.log(r.data.get_candidate);
                            var data='<ul class="list-group">';
                            var i=0;
                            if(r.data.get_candidate.length==0){
                                data+='<li class="list-group-item">No Candidates Found</li>';
                            }
                            else{
                                while(i!=r.data.get_candidate.length){
                                    data+='<li class="list-group-item">'+r.data.get_candidate[i].name+'</li>';
                                    i++;
                                }
                            }
                            data+='</ul>';
                            $('#display-candidate').append(data);
                        }
                    });
            });
    });
</script>

@endsection
