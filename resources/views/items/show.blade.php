@extends('layouts.master')
@section('title')
Colour
@endsection
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
@section('content')

<div class="w3-container w3-teal">
    <h1>Kolorek {{ $item->name  }}</h1>
</div>
<div>
    @if($item->photo_name == null)
    <img  class="img-fluid rounded-circle mx-auto d-block" src="{{url('/photos/421.png')}}" alt="No Image"/>
    @else
    <img  class="img-fluid rounded-circle mx-auto d-block" src="{{url('/photos/'.$item->photo_name)}}" alt="No Image"/>
    @endif
</div>
<div class="form-group" id="rating-ability-wrapper">
    <label class="control-label" for="rating">
        <span class="field-label-header">Jak byś ocenil? </span><br>
        <span class="field-label-info"></span>
        <input type="hidden" id="selected_rating" name="selected_rating" value="" required="required">
    </label>
    <h2 class="bold rating-header" style="">
        <span class="selected-rating">{{$avgrate}}</span><small> / 5</small>
    </h2>
    <span class="glyphicon glyphicon-user">Wszystkich ocen: {{$allrates}}</span><br>
    @for ($i = 1; $i <= 5; $i++)
    <a href="{{route('add.rate', ['item' => $item, 'star' => $i ])}}" type="button" class="btnrating btn btn-default btn-lg" data-attr="{{$i}}" id="rating-star-{{$i}}">
        <i class="fa fa-star" aria-hidden="true"></i>
    </a>
    @endfor
    <br>
    <a href="{{route('notifi.save', $item->id)}}">Powiadom mnie kiedy cena spadnie</a>


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
        <td>{{ $item->id }}</td>
        <td>{{ $item->price }}</td>
        <td>{{ $item->category->name}}</td>
        <td>@foreach($item->tags as $tag){{ 
                $tag->name }} <br>
            @endforeach</td>
        <td>
            @if(!$item->is_deleted)
            <a class="btn btn-info" href="{{route('item2.addToCart', $item)}}">ADD</a>
            @else
            <button type="button" class="btn btn-dark" disabled>Out of stock</button>
            @endif

        </td>
    </tr>
</table>


@endsection

@section('scripts')
<script>
    jQuery(document).ready(function ($) {

        $(".btnrating").on('click', (function (e) {

            var previous_value = $("#selected_rating").val();

            var selected_value = $(this).attr("data-attr");
            $("#selected_rating").val(selected_value);

            $(".selected-rating").empty();
            $(".selected-rating").html(selected_value);

            for (i = 1; i <= selected_value; ++i) {
                $("#rating-star-" + i).toggleClass('btn-warning');
                $("#rating-star-" + i).toggleClass('btn-default');
            }

            for (ix = 1; ix <= previous_value; ++ix) {
                $("#rating-star-" + ix).toggleClass('btn-warning');
                $("#rating-star-" + ix).toggleClass('btn-default');
            }

        }));


    });
</script>
@endsection