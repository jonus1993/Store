@extends('layouts.master')
@section('title')
Your order
@endsection
@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"/>
@endsection
@section('content')
<table id="items-table" class="display" style="width:100%">
    <thead> 
        <tr>
            <th>LP</th>
            <th>NAME</th>
            <th>PRICE</th>
            <th>QUANTYTY</th>
            <th>COST</th>

        </tr>
    </thead>
    <tbody>
        @php($i = 1)
        @foreach($order as $item)

        <tr class='clickable-row' data-href=''> 
            <td>{{ $i++ }}</td>
            <td>{{ $item->item->name }}</td>
            <td>{{ $item->item->price }}</td>
            <td>{{ $item->qty }}</td>
            <td>{{ $item->item->price*$item->qty }}</td>


        </tr>

        @endforeach
    </tbody>
    <tfoot> 
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        </tfood>
</table>

@stop

@push('scripts')

<!-- DataTables 
--><script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function () {
    $('#items-table').DataTable({
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
                    .column(4)
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

            // Total over this page
            pageTotal = api
                    .column(4, {page: 'current'})
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

            // Update footer
            $(api.column(4).footer()).html(
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



