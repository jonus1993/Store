@extends('layouts.master')
@section('title')
Colours
@endsection
@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"/>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
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
            <!--<input class="btn btn-dark" type="submit" value="Filtruj" />-->
        </form>
    </div>
    <div  class="col-10">
        <h1>Kolorki</h1>
       
        <div id="cartnfo" class="alert alert-info" style="display: none;">
            <span>{{ Lang::get('messages.item2cart') }}</span>
        </div>
        
        <table class="table table-active table-bordered" id="items-table">
            <thead> 
                <tr>
                    <th>ORDERS</th>
                    <th>SHOW</th>
                    <th>NAME</th>
                    <th>PRICE</th>
                    <th>CATEGORY</th>
                    <th>PROMOS</th>
                    <th>AMOUNT</th>

                </tr>
            </thead>
        </table>
    </div>
</div>
@stop

@push('scripts')

<!-- DataTables -->
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="http://malsup.github.com/jquery.form.js"></script> 
<!--<script src="/path/to/jquery.cookie.js"></script>-->
<script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>
<script>



$(document).ready(function () {
    
//czy sa ciasteczka i zaznaczyć checkboxy

if(Cookies.get('categories')) 
    $.each(Cookies.get('categories').split(','), function(i, val) {
           $("#kateg"+val).prop("checked", true);       
});
else
    Cookies.remove('categories');

$(".kateg").change(function() {
    categories = [];
    $('.kateg:checked').each(function () {
        categories.push(this.value);           
    });
    
    Cookies.set('categories', categories.join(','));
});

if(Cookies.get('tags'))
    $.each(Cookies.get('tags').split(','), function(i, val) {
           $("#"+val).prop("checked", true);       
    });
else
    Cookies.remove('tags');

$(".tagi").change(function() {
    tags = [];
    $('.tagi:checked').each(function () {
        tags.push(this.id);           
    });
    
    Cookies.set('tags', tags.join(','));
    console.log(Cookies.get('tags').split(','));
});

//tabela glowna

var table = $('#items-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        "ajax": {
        "url": "http://127.0.0.1:8000/items2/datatables.data",
        "data": function (d) {
                d.categories = [];
                $('.kateg:checked').each(function () {
                   d.categories.push(this.value);
                });
                d.tags = [];
                $('.tagi:checked').each(function () {
                d.tags.push(this.value);
                });
                console.log(d.categories);
                
                //zpais do ciasteczek
                //Cookies.set('categories', d.categories.join(','));

                
                }
        },
        rowId: 'photo_name',
        columns: [
             {
                "className":      'details-control',
                "orderable":      false,
                "data":           'null',
                "defaultContent": 'more'
            },
        {data: 'id',
                render: function (data, type, row) {
                return '<a href="{{ route('item.get', ':data')}}">click!</a>'.replace(':data', data);
                }},
        {data: 'name'},
        {data: 'price'},
        {data: 'category.name'},
        {data: 'tags[].name'},
                //              {defaultContent: "<button>ADD</button>"}
                        //              {defaultContent: "<a class='btn btn-info' href="{{ route('item2.addToCart', 'id' ) }}">ADD</a>"}
                        {data: 'id',
                                render: function (data, type, row) {
                                return '<input id="input' + data + '" type="number"><a class=add2cart href="{{ route('item'.(auth()->id() ? '2' : '').'.addToCart', ':data')}}"><br> add to cart</a>'.replace(':data', data);
                                }},
                ],
                        "columnDefs": [
                        {"orderable": false, "targets": 5}
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
                tr.removeClass('shown');
            }
            else {
                row.child( format(row.data()) ).show();
                tr.addClass('shown');
            }
        } );

        function format ( rowData ) {
            var div = $('<div/>')
                .addClass( 'loading' )
                .text( 'Loading...' );

            $.ajax( {
                url: "http://127.0.0.1:8000/items2/order.info",
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
        
              
        
        //pokazywanie zdjęcia
        $('#items-table').on( 'click', 'tr', function () {           
            var id = table.row( this ).id();
            if (!id || id == 'null'){
                id = "421.png";
            }
            
            $('#myImage').attr('src', '/photos/'+id);
        } );
        
        
        });
        </script>
        


<!--dodawanie do koszyk-->
<script>
            $('#items-table').on('click', 'a.add2cart', function (e) {
            //         If this method is called, the default action of the event will not be triggered.
                     e.preventDefault();

            var id = this.href.match(/\d+$/)[0];
            var qty =  getInputValue(id);
            if(!qty)
                qty=1;
            
            var url = this.href + '/' + qty;
           
            
            qty = parseInt(qty)
            var cartQty = $("#cartQty").html();
            qty += parseInt(cartQty);
       
            //przekierowanie
            //window.location = url;
        
            $.get(url)
                    .done(function() {             
                             $("#cartnfo").show().delay( 2000 ).hide(2000);                                     
                      $("#cartQty").html(qty);
                    })
                    .fail(function() {
                      alert( "error" );
                    })
               
            });
        </script>
        
        

<!--pobieranie wartości inputa-->
<script>
            function getInputValue(numb) {
            return $('#input' + numb).val();
            var value = document.getElementById('input' + numb).value;
            return value;
            }
</script>



   <img id="myImage"  class="img-fluid rounded-circle mx-auto d-block" src="" />
@endpush



