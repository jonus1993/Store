@extends('layouts.master')
@section('title')
Colours
@endsection
@section('styles')
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
@endsection
@section('content')
<div class="row">

    <div class="col-2">
        <h3 class="w3-bar-item">Filtry</h3>
        <h4 class="w3-bar-item">Tagi</h4>
        <form id="filtrForm" action="{{route('item.index')}}" method="get">
            @csrf

            @foreach($tags as $tag)
            <div class="form-check">
                <label class="form-check-label">
                    <input type="checkbox" class="form-check-input tagi" id="tagi{{ $tag->id }}" name="tags[]" value="{{ $tag->friend_name }}" @if(isset($_POST['tags'])) {{ in_array($tag->friend_name, $_POST['tags']) ? 'checked' : '' }} @endif>{{ $tag->name }}</label>
            </div>
            @endforeach

            <h4 class="w3-bar-item">Kategorie</h4>
            <?php $category = old('categories'); ?>

            @foreach($categories as $cat)
            <div class="form-check">
                <label class="form-check-label">
                    <input type="checkbox" class="form-check-input kateg" id="kateg{{ $cat->id }}" name="categories[]" value="{{ $cat->id }}" @if(isset($_POST['categories'])) {{  in_array($cat->id, $_POST['categories']) ? 'checked' : ''  }} @endif>{{ $cat->name }}</label>
            </div>
            @endforeach

            <br>
            <input class="btn btn-dark" type="submit" value="Filtruj">
        </form>
    </div>

    <div class="col-10">



        <h1>Kolorki</h1>
        <!--wyświetlnia wiadomości-->
        @if (Session::has('message'))
        <div class="alert alert-info">{{ Session::get('message') }}</div>
        @endif

        <table class="table table-hover">
            <tr>
                <th>ID</th>
                <th>NAME</th>
                <th>RATE</th>
                <th>PRICE</th>
                <th>CATEGORY</th>
                <th>PROMOS</th>
                <th>TO CART</th>

            </tr>

            @foreach($items as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ number_format($item->rate, 1).' / '.$item->rate_sum }}</td>
                <td>{{ $item->price }}</td>
                <td>{{ $item->category->name }}</td>
                <td>@foreach($item->tags as $tag){{
                    $tag->name }} <br>
                    @endforeach</td>

                <td>
                    @if(!$item->is_deleted)
                    <a class="btn btn-success" href="{{route('item'.(auth()->id() ? '2' : '').'.addToCart', ['item' => $item])}}">ADD</a>
                    @else
                    <button type="button" class="btn btn-dark" disabled>Out of stock</button>
                    @endif
                </td>



            </tr>
            @endforeach
        </table>
        {{ $items->links() }}

        @endsection
    </div>
</div>

@push('scripts')


<script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>
<script>
    $(document).ready(function() {
        //zaznaczanie checkboxów z kategoriami
        if (Cookies.get('categories'))
            $.each(Cookies.get('categories').split(','), function(i, val) {
                $("#kateg" + val).prop("checked", true);
            });
        else
            Cookies.remove('categories');

        //zaznaczanie checkboxów z tagami
        if (Cookies.get('tags'))
            $.each(Cookies.get('tags').split(','), function(i, val) {
                $("#" + val).prop("checked", true);
            });
        else
            Cookies.remove('tags');

        //tworzenie ciasteczek przed wysłaniem formularza

        $('#filtrForm').submit(function() {

            categories = [];
            $('.kateg:checked').each(function() {
                categories.push(this.value);
            });

            Cookies.set('categories', categories.join(','));

            tags = [];
            $('.tagi:checked').each(function() {
                tags.push(this.id);
            });

            Cookies.set('tags', tags.join(','));
            console.log(Cookies.get('tags').split(','));

            return true; // return false to cancel form action

        });

    });

</script>


@endpush
