@extends('layouts.master')
@section('title')
Colours
@endsection
@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"/>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
@endsection
@section('sidebar')
<div class="w3-sidebar w3-bar-block" style="width:10%"> 
    <h3 class="w3-bar-item">Filtry</h3>
    <h4 class="w3-bar-item">Tagi</h4>
    <form id="frm" >
        @csrf
        @foreach($tags as $tag)
        <div class="form-check">
            <input type="checkbox" class="tagi" id="tagi" name="tags[]" value="{{ $tag->friend_name }}">
            <label class="form-check-label" for="exampleCheck1">{{ $tag->name }}</label>
        </div>
        @endforeach

        <h4 class="w3-bar-item">Kategorie</h4>
        @foreach($categories as $cat)
        <div class="form-check">
            <input type="checkbox" class="kateg" id="kateg" name="categories[]" value="{{ $cat->id }}">
            <label class="form-check-label" for="exampleCheck1">{{ $cat->name }}</label>
        </div>
        @endforeach
        <br>
        <!--<input class="btn btn-dark" type="submit" value="Filtruj" />-->
    </form>
</div>
@endsection

@section('content')


<div style="margin-left:5%">
    <div class="w3-container w3-teal">
        <h1>Kolorki</h1>
    </div>

    <table class="table table-active table-bordered" id="items-table">
        <thead> 
            <tr>
                <th>ID</th>
                <th>NAME</th>
                <th>PRICE</th>
                <th>CATEGORY</th>
                <th>PROMOS</th>
                <th>AMOUNT</th>

            </tr>
        </thead>
    </table>
</div>
@stop

@push('scripts')

<!-- DataTables -->
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="http://malsup.github.com/jquery.form.js"></script> 

<script>


$(document).ready(function () {
//
//    $(function () {
//        $("#frm").ajaxSubmit({url: 'http://127.0.0.1:8000/items2/datatables.data', type: 'get'})
//    });


var table = $('#items-table').DataTable({
processing: true,
        serverSide: true,
        responsive: true,
//        ajax: "http://127.0.0.1:8000/items2/datatables.data",
//        "ajax": {
//            "url": "http://127.0.0.1:8000/items2/datatables.data",
//            "type": "POST",
//
//            "data": function (d) {
//                $('frm').submit(function () {
//                    var frm_data = $('frm').serializeArray();
//                    $.each(frm_data, function (key, val) {
//                        d[val.name] = val.value;
//                        console.log(val.value);
//                    });
//                });
//            }
//        },
        "ajax": {
        "url": "http://127.0.0.1:8000/items2/datatables.data",
                "data": function (d) {
//                    return $.extend({}, d, {
                console.log($('.kateg'));
                d.categories = [];
                $('.kateg:checked').each(function () {
                d.categories.push(this.value);
                });
                d.tags = [];
                $('.tagi:checked').each(function () {
                d.tags.push(this.value);
                });
                console.log(d.categories);
//                    });
                }
        },
        columns: [
        {data: 'id',
                render: function (data, type, row) {
                return '<a href="{{ route('item.get', ':data')}}"> show</a>'.replace(':data', data);
                }},
        {data: 'name'},
        {data: 'price'},
        {data: 'category.name'},
        {data: 'tags[].name'},
//              {defaultContent: "<button>ADD</button>"}
//              {defaultContent: "<a class='btn btn-info' href="{{ route('item2.addToCart', 'id' ) }}">ADD</a>"}
        {data: 'id',
                render: function (data, type, row) {
                return '<input id="input' + data + '" type="number"><a class=add2cart href="{{ route('item'.(auth()->id() ? '2' : '').'.addToCart', ':data')}}"> add to cart</a>'.replace(':data', data);
                }},
        ],
        "columnDefs": [
        {"orderable": false, "targets": 4}
        ]

});
$('.kateg, .tagi').click(function (e) {
table.draw();
});
});</script>


<!--dodawanie do koszyk-->
<script>
    $('#items-table').on('click', 'a.add2cart', function (e) {
//         If this method is called, the default action of the event will not be triggered.
//        e.preventDefault();

//        var cd = this.href.match(/^http(s)?:\/\/(www\.)?127.0.0.1:8000\/items2\/[0-9]+/)[0];
//        var id = cd.substring(29);

    var id = this.href.match(/\d+$/)[0];
//        console.log(id);

    var url = this.href + '/' + getInputValue(id);
//        console.log(url);
    //przekierowanie
//        window.location = url;
    $.get(url, function (data) {
    //            $(".result").html(data);
    //            alert("Successfully added to Your Own Cart");
    //            autoClose: 'cancelAction|8000',
    });
    return false;
    });</script>

<!--pobieranie wartości inputa-->
<script>
    function getInputValue(numb) {
    return $('#input' + numb).val();
    var value = document.getElementById('input' + numb).value;
    return value;
    }
</script>

@endpush

