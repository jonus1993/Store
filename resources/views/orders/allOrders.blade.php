@extends('layouts.master')
@section('title', 'All yourd orders')
@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"/>
@endsection
@section('content')
<table id="items-table" class="display" style="width:100%">
    <thead> 
        <tr>
            <th>NUMBER</th>
            <th>DATE</th>
            <th>ITEMS AMOUNT</th>
            <th>ORDER COST</th>
            <th>WHO</th>
        </tr>
    </thead>
    <tbody>
           @if(auth()->user()->isAdmin())
          @foreach($orders as $order)
            <tr class='clickable-row' data-href="{{ route('showOrderA', $order->id) }}"> 
            <td>{{ $order->id }}</td>
            <td>{{ $order->created_at }}</td>
            <td>{{ $order->total_qty }}</td>
            <td>{{ $order->total_cost }}</td>
            <td>{{ $order->user_id }}</td>
        </tr>

        @endforeach
        @else
         <tr class='clickable-row' data-href="{{ route('showOrderU', $order->id) }}"> 
            <td>{{ $order->id }}</td>
            <td>{{ $order->created_at }}</td>
            <td>{{ $order->total_qty }}</td>
            <td>{{ $order->total_cost }}</td>
            <td>ME</td>
        </tr>
        
         @endif
    </tbody>
    <tfoot> 
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        </tfood>
</table>

@stop

@push('scripts')

<!-- DataTables -->
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function () {
    $('#items-table').DataTable({
        serverSide: false,
        "language": {
            "lengthMenu": "Wyświetl _MENU_ pozycji na stronie",
            "zeroRecords": "Nic nie znaleziono",
            "info": "Strona _PAGE_ z _PAGES_",
            "infoEmpty": "Pusty rekord",
            "infoFiltered": "(wyciągnięto z _MAX_ wszystkich pozycji)",
            "search": "Wyszukaj:",
        },
        "pagingType": "full_numbers",

        "footerCallback": function (row, data, start, end, display) {
            var api = this.api(), data;

            // Remove the formatting to get integer data for summation
            var intVal = function (i) {
                return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '') * 1 :
                        typeof i === 'number' ?
                        i : 0;
            };

            // Total over all pages
            total = api
                    .column(3)
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

            // Total over this page
            pageTotal = api
                    .column(3, {page: 'current'})
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

            // Update footer
            $(api.column(3).footer()).html(
                    '$' + pageTotal + ' ( $' + total + ' total)'
                    );
        }

    });
});

</script>


<script>
    $(document).ready(function ($) {
        $(".clickable-row").click(function () {
            window.location = $(this).data("href");
        });
    });</script>


@endpush

