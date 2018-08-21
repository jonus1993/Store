@extends('layouts.master')
@section('title')
Finished order
@endsection
@section('content')
<h1>Order Completed!</h1>
<h4>Your order number: {{ $orderid }} successfully maded!</h4>
<input type="button" onclick="location.href ='{{ route('allOrders') }}';" value="Go to all Your orders" />
@endsection