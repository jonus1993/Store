@extends('layouts.master')
@section('title')
Colour
@endsection
@section('content')

    <div class="w3-container w3-teal">
        <h1>Kolorek {{ $item[0]->name  }}</h1>
    </div>
<div>
    @if($item[0]->photo_name == null)
    <h2>asdas</h2>
    <img  class="img-fluid rounded-circle mx-auto d-block" src="{{url('/photos/421.png')}}" alt="No Image"/>
    @else
    <img  class="img-fluid rounded-circle mx-auto d-block" src="{{url('/photos/'.$item[0]->photo_name)}}" alt="No Image"/>
    @endif
</div>
    <table class="table table-hover">
        <tr>
            <th>Paleta</th>
            <th>Cena</th>
            <th>Rodzaj</th>
            <th>PROMO</th>
            <th>Dodaj</th>
        </tr>
        <tr>
            <td>{{ $item[0]->id }}</td>
            <td>{{ $item[0]->price }}</td>
            <td>{{ $item[0]->category->name}}</td>
            <td>@foreach($item[0]->tags as $tag){{ 
                $tag->name }} <br>
                @endforeach</td>
            <td><a class="btn btn-info" href="{{route('item2.addToCart', ['id' => $item[0]->id])}}">ADD</a></td>
        </tr>
    </table>


@endsection