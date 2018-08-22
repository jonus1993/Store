@component('mail::message')


<div class="container">
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

</div>

@component('mail::button', ['url' => 'http://127.0.0.1:8000/login','color' => 'green'])
Login 
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
