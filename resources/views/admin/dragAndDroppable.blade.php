<link rel="stylesheet" href="{{ asset('css/tempusdominus-bootstrap-4.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/adminlte.min.css')}}">
<style>
    body{user-select: none;}
    .list-group-item {
        display: flex;
        align-items: center;
    }

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
    .card
    {
        width: 10rem;
        height:10rem;
    }
    li{
        list-style: none;
        margin: 1em;
    }
    #droppable{background-color: grey;}
    #draggable { width: 150px; height: 150px; padding: 0.5em;border:1px solid; }
</style>
<div class="container">
    <div class="row my-5">
        <div class="col-md-12">
            <div id="show"></div>
            <div class="d-flex">
                <ul class="sort_menu list-group">
                    @foreach ($data as $row)
                    <li class="list-group-item" data-id="{{$row->id}}">
                        <span class="own mx-2"></span> {{$row->label}}
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
{{--
    <div class="row border h-50 my-4">
        <div id="draggable" class="ui-widget-content">
            <p>Drag me around</p>
          </div>
    </div> --}}

    <ul id="gallary" class="d-flex flex-wrap">
        <li class="card"><div class=" bg-primary"></div></li>
        <li class="card"><div class=" bg-primary"></div></li>
        <li class="card"><div class=" bg-primary"></div></li>
        <li class="card" id="droppable"></li>
    </ul>

</div>
<style>

</style>
<script src="https://unpkg.com/jquery@2.2.4/dist/jquery.js"></script>
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<link href="https://code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css"/>

<script>
    $(document).ready(function(){

        var $gallary = $( "#gallary" );
        $("li",$gallary).draggable({

            cursor:"move"
        });
        $( "#droppable" ).droppable({
            drop: function( event, ui ) {
                $( this )
                .addClass( "ui-state-highlight" )
                .find( "p" )
                    .html( "Dropped!" );
            }
        });
        // $( "#draggable" ).draggable({ cursor: "move",containment: "parent" });





    	function updateToDatabase(idString){
    	   $.ajaxSetup({ headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'}});

    	   $.ajax({
              url:'{{url('/menu/update-order')}}',
              method:'POST',
              data:{ids:idString},
              success:function(){
                $('#show').html('');
                  $('#show').prepend('<div class="alert alert-primary">Menu Saved Successfully..!<div>')
                //  alert('Successfully updated')
              },
              error:function(data){
                 alert(data)
              }
           })
    	}

        var target = $('.sort_menu');
        target.sortable({
            handle: '.own',
            placeholder: 'highlight',
            axis: "y",
            cursor:"move",
            update: function (e, ui){
               var sortData = target.sortable('toArray',{ attribute: 'data-id'})
            //    alert(sortData);
               updateToDatabase(sortData.join(','))
            }
        })

    })
</script>
