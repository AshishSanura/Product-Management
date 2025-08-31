@extends('layouts.app')

@section('content')
<div class="container">
	<h2 class="mb-4">Order #{{ $order->id }}</h2>

	<div class="card mb-3">
		<div class="card-body">
			<p><strong>Customer:</strong> {{ $order->user->name ?? 'N/A' }}</p>
			<p><strong>Email:</strong> {{ $order->user->email ?? '-' }}</p>
			<p><strong>Status:</strong> <span class="badge bg-primary">{{ $order->status }}</span></p>
			<p><strong>Total:</strong> ₹ {{ number_format($order->total_price, 2) }}</p>
		</div>
	</div>

	<div class="card p-3">
		<h5>Update Order Status</h5>
		@include('admin.orders.order_update', ['order' => $order])
	</div>
</div>
@endsection
