<head>
    <link rel="stylesheet" href="{{ asset('css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css')}}">
    <style>
         .highlight {
        background: #f7e7d3;
        min-height: 30px;
        list-style-type: none;
    }

    .handle {
        min-width: 18px;
        background: #607D8B;
        height: 15px;
        display: inline-block;
        cursor: move;
        margin-right: 10px;
    }
    .own
    {
        width: 20px;
        height: 20px;
        background-color: blue;
        border-radius: 50%;
        cursor: move;
    }
    li
    {
        margin:1em;
    }
    </style>
</head>

<form action="{{route('student.store')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="text" name="name">
    <input type="email" name="email">
    <input type="number" name="phone">
    <input type="file" name="attachment">
    <select name="technology[]"  multiple>
        @foreach($technology as $tech)
            <option value="{{$tech->id}}">{{$tech->tech}}</option>
        @endforeach
    </select>
    <select name="state" id="">
        @foreach($state as $tech)
        <option value="{{$tech->id}}">{{$tech->status}}</option>
        @endforeach
    </select>
    <input type="submit" value="Save">
</form>
<div class="row">
    <div class="col-md-2">
        <h2>New Applicant</h2>
        <ul id="sortable1" class="list-group connectedSortable" style="height:300px;">
            @foreach($applicants as $applicant)
            <li class="list-group-item" id="{{$applicant->id}}" data-id="{{$applicant->id}}">
                <span class="handle mx-2"></span>{{$applicant->name}}
            </li>
            @endforeach
        </ul>
    </div>
    <div class="col-md-2">
        <h2>HR Round</h2>
        <ul class="sort_menu list-group connectedSortable" id="sortable2">
            @foreach($hrrounds as $hrround)
            <li class="list-group-item" id="{{$hrround->id}}"" data-id="{{$hrround->id}}">
                <span class="handle mx-2"></span>{{$hrround->name}}
            </li>
            @endforeach
        </ul>
    </div>
    <div class="col-md-2">
        <h2>Technical</h2>
        <ul class="sort_menu list-group connectedSortable" id="sortable3">
            @foreach($technicals as $technical)
            <li class="list-group-item" id="{{$technical->id}}"" data-id="{{$technical->id}}">
                <span class="handle mx-2"></span>{{$technical->name}}
            </li>
            @endforeach
        </ul>
    </div>
    <div class="col-md-2">
        <h2>Practical</h2>
        <ul class="sort_menu list-group connectedSortable" id="sortable4">
            @foreach($practicals as $practical)
            <li class="list-group-item" id="{{$practical->id}}"" data-id="{{$practical->id}}">
                <span class="handle mx-2"></span>{{$practical->name}}
            </li>
            @endforeach
        </ul>
    </div>

    <div class="col-md-2">
        <h2>Offered</h2>
        <ul class="sort_menu list-group connectedSortable" id="sortable5">
            @foreach($offerces as $offerce)
            <li class="list-group-item" id="{{$offerce->id}}"" data-id="{{$offerce->id}}">
                <span class="handle mx-2"></span>{{$offerce->name}}
            </li>
            @endforeach
        </ul>
    </div>

    <div class="col-md-2">
        <h2>Rejectes</h2>
        <ul class="sort_menu list-group connectedSortable" id="sortable6">
            @foreach($rejectes as $rejecte)
            <li class="list-group-item" id="{{$rejecte->id}}"" data-id="{{$rejecte->id}}">
                <span class="handle mx-2"></span>{{$rejecte->name}}
            </li>
            @endforeach
        </ul>
    </div>

    <div class="col-md-2">
        <h2>Hold</h2>
        <ul class="sort_menu list-group connectedSortable" id="sortable7">
            @foreach($holds as $hold)
            <li class="list-group-item" id="{{$hold->id}}"" data-id="{{$hold->id}}">
                <span class="handle mx-2"></span>{{$hold->name}}
            </li>
            @endforeach
        </ul>
    </div>
</div>

<script src="https://unpkg.com/jquery@2.2.4/dist/jquery.js"></script>
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<link href="https://code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css"/>

<script>
     $( "#sortable1,#sortable2,#sortable3,#sortable4,#sortable5,#sortable6,#sortable7" ).sortable({
      connectWith: ".connectedSortable"
    }).disableSelection();
    $('#sortable1').sortable({
        update: function(event, ui) {
            var productOrder = $(this).sortable('toArray').toString();
            updateToDatabase(productOrder,1);
        }
    });
    $('#sortable2').sortable({
        update: function(event, ui) {
            var productOrder = $(this).sortable('toArray').toString();
            updateToDatabase(productOrder,2);
        }
    });

    $('#sortable3').sortable({
        update: function(event, ui) {
            var productOrder = $(this).sortable('toArray').toString();
            updateToDatabase(productOrder,3);
        }
    });


    $('#sortable4').sortable({
        update: function(event, ui) {
            var productOrder = $(this).sortable('toArray').toString();
            updateToDatabase(productOrder,4);
        }
    });

    $('#sortable5').sortable({
        update: function(event, ui) {
            var productOrder = $(this).sortable('toArray').toString();
            updateToDatabase(productOrder,5);
        }
    });


    $('#sortable6').sortable({
        update: function(event, ui) {
            var productOrder = $(this).sortable('toArray').toString();
            updateToDatabase(productOrder,6);
        }
    });

    $('#sortable7').sortable({
        update: function(event, ui) {
            var productOrder = $(this).sortable('toArray').toString();
            updateToDatabase(productOrder,7);
        }
    });
    // var target = $('.sort_menu');
    //     target.sortable({
    //         handle: '.handle',
    //         placeholder: 'highlight',
    //         axis: "y",
    //         cursor:"move",
    //         update: function (e, ui){
    //            var sortData = target.sortable('toArray',{ attribute: 'data-id'})
    //            updateToDatabase(sortData.join(','))
    //         }
    //     })
        function updateToDatabase(idString,state){
    	   $.ajaxSetup({ headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'}});

    	   $.ajax({
              url:'{{url('/menu/update-order')}}',
              method:'POST',
              data:{ids:idString,state:state},
              success:function(){
                $('#show').html('');
                  $('#show').prepend('<div class="alert alert-primary">Menu Saved Successfully..!<div>')
                //  alert('Successfully updated')
              },
              error:function(data){
                 console.log(data)
              }
           })
    	}
</script>

