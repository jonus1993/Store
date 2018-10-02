@extends('layouts.master')
@section('title', 'Admit Discount')
@section('styles')
@endsection
@section('content')
<strong>{{ $promo->code }}</strong> <br>
<td>{{ $promo->value }}%</td>
<td>{{ $promo->item->name }}</td>

<form action="{{ route('promo.update', $promo->id) }}" method="post">
     @csrf
    <input type="hidden" name="_method" value="put">
    <small class="form-text text-muted">Select the time interval for registering    users</small>
    <div class="input-group">
        <input type="date" class="form-control" name="start_date" placeholder="Signed from">
        <input type="date" class="form-control" name="end_date" placeholder="Signed to">
    </div>
 <br>
     <small class="form-text text-muted">Choose the range of money spent on orders</small>
    <div class="input-group">
        <input type="range" class="form-control" id="orderInputId" value="0" min="0" max="1000" name="start_order" oninput="orderOutputId.value = orderInputId.value">
        <output name="orderOutputName" id="orderOutputId"></output>

        <input type="range" class="form-control" id="orderInputId2" value="0" min="0" max="10000" name="end_order" oninput="orderOutputId2.value = orderInputId2.value">
        <output name="orderOutputName2" id="orderOutputId2"></output>
    </div>
   
    <div class="form-group">
        <input type="submit" class="btn btn-primary" value="Admit">
    </div
    
</form> 
@endsection
