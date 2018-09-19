@extends('layouts.master')
@section('title')
Colours
@endsection
@section('styles')
       <link rel="stylesheet" href="{{url('/css/dataTables.min.css')}}">
    
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
           

        
<style>
    td.details-control {
    background: url("{{url('/open-iconic/svg/plus.svg')}}") no-repeat center center;
    cursor: pointer;
}
tr.details td.details-control {
    background: url("{{url('/open-iconic/svg/minus.svg')}}") no-repeat center center;
}
 	
th.dt-center, td.dt-center { text-align: center; }   

img.images {
    max-width:100%;
max-height:100%;
height: auto;
}

</style>
@endsection
@section('content')
<div class="row">

    <div class="col-2" > 
        <h3 class="w3-bar-item">Filtry</h3>
        <h4 class="w3-bar-item">Tagi</h4>
        <form id="frm" action="{{route('datatables.data')}}" method="get">
            @csrf
            @foreach($tags as $tag)
            <div class="form-check">
                <input type="checkbox" class="tagi" id="tagi{{ $tag->id }}" name="tags[]" value="{{ $tag->friend_name }}">
                <label class="form-check-label" for="exampleCheck1">{{ $tag->name }}</label>
            </div>
            @endforeach

            <h4 class="w3-bar-item">Kategorie</h4>
            @foreach($categories as $cat)
            <div class="form-check">
                <input type="checkbox" class="kateg" id="kateg{{ $cat->id }}" name="categories[]" value="{{ $cat->id }}">
                <label class="form-check-label" for="exampleCheck1">{{ $cat->name }}</label>
            </div>
            @endforeach
            <br>

        </form>
    </div>
    <div  class="col-10">
        <h1>Kolorki</h1>
       
        <div id="cartnfo" class="alert alert-info" style="display: none;">
            <span>{{ Lang::get('messages.item2cart') }}</span>
        </div>

                <h4>   <a href="{{route('item.create')}}" rel="modal:open" class="editor_create">Create new record</a></h4> 

       
       
        <table class="table table-active table-bordered" id="items-table">
        
            <thead> 
                <tr>
                    <th>MORE</th>
                    <th>GO2</th>
                    <th>NAME</th>
                    <th>PRICE</th>
                    <th>CATEGORY</th>
                    <th>PROMOS</th>
                    <th>EDIT/DEL</th>
                    
                </tr>
            </thead>
             <tfoot> 
                <tr>
                    <th>MORE</th>
                    <th>GO2</th>
                    <th>NAME</th>
                    <th>PRICE</th>
                    <th>CATEGORY</th>
                    <th>PROMOS</th>
                    <th>EDIT/DEL</th>
                    
                </tr>
            </tfoot>
        </table>
    </div>
   
</div>
@stop

@push('scripts')
          
<!--          Modal-->
           <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>      

<!-- DataTables -->
    <script src="{{url('/js/dataTables.min.js')}}"></script>
<script src="http://malsup.github.com/jquery.form.js"></script> 
<script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>

<script>


$(document).ready(function () {
    
    // Edit record
    $('#items-table').on('click', 'a.editor_edit', function (e) {
        e.preventDefault();
 
        editor.edit( $(this).closest('tr'), {
            title: 'Edit record',
            buttons: 'Update'
        } );
    } );
 
    // Delete a record
    $('#items-table').on('click', 'a.editor_remove', function (e) {
        e.preventDefault();
 
        editor.remove( $(this).closest('tr'), {
            title: 'Delete record',
            message: 'Are you sure you wish to remove this record?',
            buttons: 'Delete'
        } );
    } );


//tabela glowna

var table = $('#items-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        "ajax": {
        "url": "{{route('datatables.data')}}",
        "data": function (d) {
                d.categories = [];
                $('.kateg:checked').each(function () {
                   d.categories.push(this.value);
                });
                d.tags = [];
                $('.tagi:checked').each(function () {
                d.tags.push(this.value);
                });


                
                }
        },
     
        columns: [
             {
                "className":      'details-control',

                "orderable":      false,
              "data":           null,
                "defaultContent": ''
            },
        {data: 'id',
                 "orderable": false,
                render: function (data, type, row) {
                return '<a href="{{ url('item/:data')}}">\n\
                                      <img class="images" src="{{url('/photos/click.png')}}" alt="icon name"> \n\
                \n\</a>'.replace(':data', data);
                }},
        {data: 'name'},
        {data: 'price',
       render: 
         function (data, type, row) {
           var num = $.fn.dataTable.render.number( ',', '.', 2, '$' ).display(data); 
           if(data<10)
               return '<strong>'+num+'</strong>';
           else
           return '<span>'+num+'</span>';
           
       }
                                  },
        {data: 'category.name'},
        {data: 'tags[].name',
         "orderable": false,
         render: function (data, type, row) {
             var html = "";
                    for (i = 0; i < data.length; i++){
                          if(data.toString() == "Promocja")
                                html+='<span style="color:red">'+data[i]+'</span><br>';
                         else
                               html+= data[i]+'<br>';
                       }
            return html;
    }
        },
                           {
                data: 'id',
                               "orderable": false,
            
                 render: function (data, type, row) { return '<div class="row">&emsp;<a class="btn btn-info" href="{{route('item.edit', ['id' => ':data'])}}">Edit</a>&emsp; {{Form::open(array('method' => 'DELETE', 'url' => 'item/'.':data')) }}  {{ Form::submit('DEL', ['class' => 'btn btn-danger']) }}          {{ Form::close() }}</div>'.replace(':data', data).replace(':data2', data);
                                                    }}
            
                ],
                        "columnDefs": [
                        { "targets": 5},
                           {"width": "20%", "targets": 5},
                            {"width": "17%", "targets": 6},
                            {"className": "dt-center", "targets": "_all"}
                        ]

                });
    
    
                
        $('.kateg, .tagi').click(function (e) {
        table.draw();
        });   
        
        
         
             //informacje o zamówieniach
        $('#items-table tbody').on('click', 'td.details-control', function () {           
            
            var tr = $(this).closest('tr');
            var row = table.row( tr );
            
            if ( row.child.isShown() ) {
                row.child.hide();
                tr.removeClass('details');
            }
            else {
                row.child( format(row.data()) ).show();
                tr.addClass('details');
            }
        } );

        function format ( rowData ) {
            var div = $('<div/>')
                .addClass( 'loading' )
                .text( 'Loading...' );

            $.ajax( {
                url: "{{route('order.info')}}",
                data: {
                    id: rowData.id
                },  
                //dataType: 'json',
                success: function (response) {                           
                    div
                        .html(response )
                        .removeClass( 'loading' );
                }
            } );

            return div;
        }
        
              

             } );   
        </script>


@endpush