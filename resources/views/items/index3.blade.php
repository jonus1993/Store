@extends('layouts.master')
@section('title')
Colours
@endsection
@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"/>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
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
<!--            <input class="btn btn-dark" type="submit" value="Filtruj" />-->
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
                    <th>MORE</th>
                    <th>GO2</th>
                    <th>NAME</th>
                    <th>PRICE</th>
                    <th>CATEGORY</th>
                    <th>PROMOS</th>
                    <th>AMOUNT</th>
                    
                </tr>
            </thead>
        </table>
    </div>
    <img id="myImage"  class="img-fluid rounded-circle mx-auto d-block" src="" />
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


//zaznaczanie checkboxów z kategoriami
if(Cookies.get('categories')) 
    $.each(Cookies.get('categories').split(','), function(i, val) {
           $("#kateg"+val).prop("checked", true);       
});
else
    Cookies.remove('categories');

//$(".kateg").change(function() {
//    categories = [];
//    $('.kateg:checked').each(function () {
//        categories.push(this.value);           
//    });
//    
//    Cookies.set('categories', categories.join(','));
//});



//zaznaczanie checkboxów z tagami
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
                
                //zpais do ciasteczek
                //Cookies.set('categories', d.categories.join(','));

                
                }
        },
        rowId: 'photo_name',
        columns: [
             {
                "className":      'details-control',
//                "width":           "15%",
                "orderable":      false,
              "data":           null,
                "defaultContent": ''
            },
        {data: 'id',
                render: function (data, type, row) {
                return '<a href="{{ route('item.get', ':data')}}">\n\
                                      <img class="images" src="{{url('/photos/click.png')}}" alt="icon name"> \n\
                \n\</a>'.replace(':data', data);
                }},
        {data: 'name'},
        {data: 'price',
       render: function (data, type, row) {
           if(data<10)
               return '<strong>'+data+'</strong>';
           else
           return '<span>'+data+'</span>';
           
       }
                                  },
        {data: 'category.name'},
        {data: 'tags[].name',
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
                        {  "orderable":      false, data: 'id',
                                render: function (data, type, row) {
                                return '<div class="input-group">\n\
                                 <span class="input-group-btn">\n\
                                    <button  type="button" class="btn btn-danger btn-number"  data-type="minus" data-field="amount'+data+'">\n\
                                      <img src="{{url('/open-iconic/svg/minus.svg')}}" alt="icon name"> \n\
                                   </button>   \n\
                                    </span>             \n\
                                     <input style="text-align:center" type="text" name="amount'+data+'" class="form-control input-number" value="1" min="1" max="100">  \n\
                              <span class="input-group-btn">  \n\
                                <button  type="button" class="btn btn-success btn-number" data-type="plus" data-field="amount'+data+'">  \n\
                                      <img src="{{url('/open-iconic/svg/plus.svg')}}" alt="icon name"> \n\
                                </button>    \n\
                              </span>\n\
                              <a class="btn btn-primary btn-block add2cart" href="{{ route('item'.(auth()->id() ? '2' : '').'.addToCart', ':data')}}">   <img src="{{url('/open-iconic/svg/cart.svg')}}" alt="icon name"></a>               \n\
                             </div>  '.replace(':data', data);	
                                }},
                ],
                        "columnDefs": [
                        {"orderable": false, "targets": 5},
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
        
              
        
        //pokazywanie zdjęcia
        $('#items-table').on( 'click', 'tr', function () {           
            var id = table.row( this ).id();
            if (!id || id == 'null'){
                id = "noPhoto.png";
            }
            
             $('#myImage').attr('src', '{{ asset("photos")}}' +'/'+ id);
             } );
             
 
             } );   
        </script>
        


<!--dodawanie do koszyk-->
<script>
    
$(document).ready(function () {
            $('#items-table').on('click', '.btn-number', function (e) {
            e.preventDefault();
    
    fieldName = $(this).attr('data-field');
    
    type      = $(this).attr('data-type');
    var input = $("input[name='"+fieldName+"']");
    var currentVal = parseInt(input.val());
    if (!isNaN(currentVal)) {
        if(type == 'minus') {
            
            if(currentVal > input.attr('min')) {
                input.val(currentVal - 1).change();
            } 
            if(parseInt(input.val()) == input.attr('min')) {
                $(this).attr('disabled', true);
            }

        } else if(type == 'plus') {

            if(currentVal < input.attr('max')) {
                input.val(currentVal + 1).change();
            }
            if(parseInt(input.val()) == input.attr('max')) {
                $(this).attr('disabled', true);
            }

        }
    } else {
        input.val(1);
    }
});

 $('#items-table').on('click', 'a.add2cart', function (e) {
            //         If this method is called, the default action of the event will not be triggered.
           e.preventDefault();

            var id = this.href.match(/\d+$/)[0];
            var qty =  getInputValue(id);
            if(!qty)
                qty=1;
            
            var url = this.href + '/' + qty;
           
            
            qty = parseInt(qty);
            var cartQty = $("#cartQty").html();
            qty += parseInt(cartQty);
       
            //przekierowanie
            //window.location = url;
        
            $.get(url)
                    .done(function() {             
                             $("#cartnfo").show().delay(125).hide(1000);                                     
                      $("#cartQty").html(qty);
                    })
                    .fail(function() {
                      alert( "error" );
                    });
               
            });

$('.input-number').focusin(function(){
   $(this).data('oldValue', $(this).val());
});

$('#items-table').on('change','.input-number', function() {
    
    minValue =  parseInt($(this).attr('min'));
    maxValue =  parseInt($(this).attr('max'));
    valueCurrent = parseInt($(this).val());
    
    name = $(this).attr('name');
    if(valueCurrent >= minValue) {
        $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled');
    } else {
        alert('Sorry, the minimum value was reached');
        $(this).val(minValue);
    }
    if(valueCurrent <= maxValue) {
        $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled');
    } else {
        alert('Sorry, the maximum value was reached');
        $(this).val(maxValue);
    }
    
    
});

$('#items-table').on('keydown','.input-number',function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
             // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) || 
             // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
    
        
          
    
        });
    function getInputValue(numb) {
            return $("input[name='amount"+numb+"']").val();

            }
</script>



@endpush



