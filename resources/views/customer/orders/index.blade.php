@extends('layouts.app')

@section('content')
<div class="container">

	<div class="d-flex justify-content-between align-items-center mb-4">
		<a href="{{ route('orders.create') }}" class="btn btn-primary">
			<i class="bi bi-plus-circle"></i> Place Your Order
		</a>
	</div>

	@if(session('success'))
		<div class="alert alert-success">{{ session('success') }}</div>
	@endif

	<table class="table table-bordered">
		<thead>
			<tr>
				<th>#</th>
				<th>Product</th>
				<th>Qty</th>
				<th>Total Price</th>
				<th>Status</th>
				<th>Date</th>
			</tr>
		</thead>
		<tbody>
			@foreach($orders as $order)
			<tr>
				<td>{{ $order->id }}</td>
				<td>{{ $order->product->name }}</td>
				<td>{{ $order->quantity }}</td>
				<td>₹ {{ $order->total_price }}</td>
				<td>{{ ucfirst($order->status) }}</td>
				<td>{{ $order->created_at->format('d M Y') }}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endsection
