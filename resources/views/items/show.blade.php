@extends('layouts.master')
@section('title')
Colour
@endsection
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
@section('content')

<div class="w3-container w3-teal">
    <h1>Kolorek {{ $item[0]->name  }}</h1>
</div>
<div>
    @if($item[0]->photo_name == null)
    <img  class="img-fluid rounded-circle mx-auto d-block" src="{{url('/photos/421.png')}}" alt="No Image"/>
    @else
    <img  class="img-fluid rounded-circle mx-auto d-block" src="{{url('/photos/'.$item[0]->photo_name)}}" alt="No Image"/>
    @endif
</div>
<div class="form-group" id="rating-ability-wrapper">
    <label class="control-label" for="rating">
        <span class="field-label-header">Jak byś ocenil? </span><br>
        <span class="field-label-info"></span>
        <input type="hidden" id="selected_rating" name="selected_rating" value="" required="required">
    </label>
    <h2 class="bold rating-header" style="">
        <span class="selected-rating">0</span><small> / 5</small>
    </h2>
    @for ($i = 1; $i <= 5; $i++)
    <a href="" type="button" class="btnrating btn btn-default btn-lg" data-attr="{{$i}}" id="rating-star-{{$i}}">
        <i class="fa fa-star" aria-hidden="true"></i>
    </a>
    @endfor
    <br>
    <a href="{{route('notifi.save', $item[0]->id)}}">Powiadom mnie kiedy cena spadnie</a>


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

@section('scripts')
<script>	jQuery(document).ready(function ($) {

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


    });</script>
@endsection