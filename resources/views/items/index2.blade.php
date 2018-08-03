@extends('layouts.master')
@section('title')
Colours
@endsection
@section('content')
<table class="table table-bordered" id="items-table">
    <thead> 
        <tr>
            <th>ID</th>
            <th>NAME</th>
            <th>PRICE</th>
            <th>TO CART</th>
        </tr>
    </thead>
</table>

@stop

@push('scripts')
<script src="//code.jquery.com/jquery.js"></script>
<!-- DataTables -->
<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
<!-- Bootstrap JavaScript -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<!-- App scripts -->
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
//                {defaultContent: "<button>ADD</button>"}
//              {defaultContent: "<a class='btn btn-info' href="{{ route('item2.addToCart', 'id' ) }}">ADD</a>"}

            {data: 'id',
                    render: function (data, type, row) {
                    return '<a href="{{ route('item2.addToCart', ':data')}}">ADD</a>'.replace(':data',data);
                    }
            }
            ]

    });
    });


</script>
@endpush

