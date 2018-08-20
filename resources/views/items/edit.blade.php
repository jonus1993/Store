@extends('layouts.master')
@section('title')
Add Colour
@endsection
@section('content')
<h1>Edit Colour</h1>
@if ($errors->any())
<h4 style="color: red">Something wents wrong... check it!</h4>
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<!--wyświetlnia wiadomości-->
@if (Session::has('message'))
<div class="alert alert-info">{{ Session::get('message') }}</div>
@endif
<div>
    @if($item->photo_name == null)
    <img  class="img-fluid rounded-circle mx-auto d-block" src="{{url('/photos/421.png')}}" alt="No Image"/>
    @else
    <img  class="img-fluid rounded-circle mx-auto d-block" src="{{url('/photos/'.$item->photo_name)}}" alt="No Image"/>
    @endif
</div>
<form action="{{route('item.edit', $item->id)}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="name">colour name:</label>
        <input type="text" class="form-control" name="name" value="{{ old('name', $item->name) }}" id="name">
    </div>
    <div class="form-group">
        <label for="price">price:</label>
        <input type="number" min="0.00" max="10000.00" step="0.01" value="{{old('price', $item->price)}}" class="form-control" name="price" id="price">
    </div>
    <div class="form-group">
        <label for="category">category:</label>
        <select class="form-control" name="category_id" id="category">
            @foreach($categories as $cat)
            <option value="{{ $cat->id }}" @if ($cat->id == old('category_id', $item->category_id))) 
                    selected="selected"
                    @endif 
                    >{{ $cat->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <?php
        $itemTags = old('tags');
        if (!is_array($itemTags)) {
            $itemTags = array_keys($item->tags->getDictionary());
            //$itemTags = $item->tags->pluck('id');
            //dd($tags);
        }
        ?>
        @foreach($tags as $tag)

        <label class="checkbox-inline"><input name="tags[]" type="checkbox" value="{{ $tag->id }}" 
                                              {{ (in_array($tag->id, $itemTags) ? 'checked' : '' ) }}>{{ $tag->name }}</label>
        @endforeach
    </div>
    <div class="form-group">
        <label for="photo">Photo</label>
        <input type="file" class="form-control-file" name="photo_name" id="photo">
    </div>

    <button type="submit" class="btn btn-primary">Edit</button>

</form>
@endsection