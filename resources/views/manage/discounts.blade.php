@extends('layouts.master')
@section('title', 'Discounts')
@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" />
@endsection
@section('content')
<table id="items-table" class="display" style="width:100%">
    <thead>
        <tr>
            <th>CODE</th>
            <th>VALUE</th>
            <th>ITEM</th>
            <th>ACTIVE</th>
        </tr>
    </thead>
    <tbody>
        @foreach($promos as $promo)
        <tr>
            <td>
                <button class="btn btn-primary" onclick="location.href='{{ route ('promo.show', $promo->id)}}'"> {{ $promo->code }}</button>
            </td>
            <td>{{ $promo->value }}</td>
            <td>{{ $promo->item->name }}</td>
            <td>@if($promo->deleted_at == null)
                {{ Form::open(array('method' => 'DELETE', 'url' => 'promo/'.$promo->id)) }}
                {{ Form::submit('DELETE', ['class' => 'btn btn-danger']) }}
                {{ Form::close() }}
                @else
                <button class="btn btn-success" onclick="location.href='{{ route ('promo.restore', $promo->id)}}'">ACTIVE</button>
                @endif
            </td>
        </tr>
        @endforeach
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
    $(document).ready(function() {
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


        });
    });

</script>


<!--
<script>
    $(document).ready(function($) {
        $(".clickable-row").click(function() {
            window.location = $(this).data("href");
        });
    });

</script>
-->



@endpush
