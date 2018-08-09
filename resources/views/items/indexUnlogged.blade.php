@extends('layouts.master')
@section('title')
Colours
@endsection
@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"/>
@endsection
@section('content')
<table class="table table-active table-bordered" id="items-table">
    <thead> 
        <tr>
            <th>ID</th>
            <th>NAME</th>
            <th>PRICE</th>
            <th>AMOUNT</th>
            <th>TO CART</th>
        </tr>
    </thead>
</table>

@stop

@push('scripts')

<!-- DataTables -->
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

<script>
    $(function () {
        $('#items-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: 'http://127.0.0.1:8000/items2/datatables.data',
            columns: [
                {data: 'id'},
                {data: 'name'},
                {data: 'price'},
//              {defaultContent: "<button>ADD</button>"}
//              {defaultContent: "<a class='btn btn-info' href="{{ route('item2.addToCart', 'id' ) }}">ADD</a>"}
                {data: 'id',
                    render: function (data, type, row) {
                        return '<input id="input' + data + '" type="number">'
                    }},
                {data: 'id',
                    render: function (data, type, row) {

                        return '<a class=add2cart href="{{ route('item.addToCart', ':data')}}">ADD</a>'.replace(':data', data);
                    }
                }
            ]

        });
    });


</script>


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
    });
</script>


<script>
    function getInputValue(numb) {
        return $('#input' + numb).val();

        var value = document.getElementById('input' + numb).value;
        return value;
    }
</script>
@endpush

