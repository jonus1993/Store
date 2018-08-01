@extends('layouts.master')
@section('title')
    Colours
@endsection
@section('content')
            <table class="table table-hover">
                <tr>
                    <th>ID</th>
                    <th>NAME</th>
                    <th>PRICE</th>
                    <th>TO CART</th>
                </tr>
                @foreach($items as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name  }}</td>
                        <td>{{ $item->price }}</td>
                        <td><a class="btn btn-info" href="{{route('item.addToCart', ['id' => $item->id])}}">ADD</a></td>
                     </tr>
                @endforeach
            </table>
            {{ $items->links() }}
@endsection