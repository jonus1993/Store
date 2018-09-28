@extends('layouts.master')
@section('title', 'Admit Discount')
@section('styles')
@endsection
@section('content')
<strong>{{ $promo->code }}</strong> <br>
<td>{{ $promo->value }}%</td>
<td>{{ $promo->item->name }}</td>
@endsection
