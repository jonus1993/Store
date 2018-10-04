@extends('layouts.master')
@section('title')
NBP
@endsection
@section('head')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"/>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
@endsection
@section('content')

<h1>Waluty</h1>
<table class="table table-active table-bordered" id="items-table">
    <thead> 
        <tr>
            <th>currency</th>
            <th>code</th>
            <th>mid</th>
        </tr>
    </thead>
</table>

@stop

@push('scripts')

<script src="{{asset('js/app.js')}}"></script>

<!-- DataTables -->
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script>

    $(document).ready(function () {

//tabela glowna
        var table = $('#items-table').DataTable({
            processing: true,
            serverSide: false,
            responsive: true,
            "ajax": {
                "url": "http://api.nbp.pl/api/exchangerates/tables/A/?format=json",
                "type": "GET",
                "dataType": "json",
                "dataSrc": function (json) { 
                    console.log(json[0]['rates']);
                    return json[0]['rates'];
                }
            },
            columns: [
                {data: 'currency'},
                {data: 'code'},
                {data: 'mid'}
            ]

        });
    });

</script> 
@endpush



