<table id="child-items-table" class="display" style="width:100%">
    <thead> 
        <tr>
            <th>LP</th>
            <th>ORDER NO.</th>         
            <th>DATE</th>
            <th>QUANTYTY</th>
        </tr>
    </thead>
    <tbody>
        @php($i = 1)
        @foreach($orders as $order)
        <tr> 
            <td>{{ $i++ }}</td>
           
            <td>{{$order->id}}</td>
             <td>{{$order->updated_at}}</td>
            <td>{{$order->pivot->qty}}</td>

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
<script>
    $(document).ready(function () {
        $('#child-items-table').DataTable({
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
                        pageTotal + ' ( ' + total + ' total)'
                        );
            }

        });
    });

</script>


