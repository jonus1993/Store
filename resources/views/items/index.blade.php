@extends('layouts.master')
@section('title')
Colours
@endsection
@section('styles')
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
@endsection
@section('sidebar')
<div class="w3-sidebar w3-bar-block" style="width:10%"> 
    <h3 class="w3-bar-item">Filtry</h3>
    <h4 class="w3-bar-item">Tagi</h4>
    <form action="{{route('filter.data')}}" method="post">
        @csrf
        @foreach($tags as $tag)
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1" name="tags[]" value="{{ $tag->friend_name }}">
            <label class="form-check-label" for="exampleCheck1">{{ $tag->name }}</label>
        </div>
        @endforeach

        <h4 class="w3-bar-item">Kategorie</h4>
        @foreach($categories as $cat)
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1" name="categories[]" value="{{ $cat->id }}">
            <label class="form-check-label" for="exampleCheck1">{{ $cat->name }}</label>
        </div>
        @endforeach
        <br>
        <input class="btn btn-dark" type="submit" value="Filtruj" />
    </form>
</div>
@endsection
@section('content')
<div style="margin-left:5%">
    <div class="w3-container w3-teal">
        <h1>Kolorki</h1>
    </div>
    <table class="table table-hover">
        <tr>
            <th>ID</th>
            <th>NAME</th>
            <th>RATE</th>
            <th>PRICE</th>
            <th>CATEGORY</th>
            <th>PROMOS</th>
            <th>ACTIONS</th>
        </tr>
        @foreach($items as $item)
        <tr>
            <td>{{ $item->id }}</td>
            <td>{{ $item->name  }}</td>
            <td></td>
            <td>{{ $item->price }}</td>
            <td>{{ $item->category->name }}</td>
            <td>@foreach($item->tags as $tag){{ 
                $tag->name }} <br>
                @endforeach</td>
            @auth
            @if(auth()->user()->isAdmin())
            
            <td><a class="btn btn-info" href="{{route('item.del', ['id' => $item->id])}}">DEL</a></td>
            
           
            @endif
            

            @can('moderator-allowed', Auth::user())
              <td><a class="btn btn-info" href="{{route('item.edit', ['id' => $item->id])}}">EDIT</a></td>
            @endcan
             @endauth
          
            
            <td><a class="btn btn-info" href="{{route('item'.(auth()->id() ? '2' : '').'.addToCart', ['id' => $item->id])}}">ADD</a></td>
            
        </tr>
        @endforeach
    </table>
    {{ $items->links() }}
</div>
@endsection