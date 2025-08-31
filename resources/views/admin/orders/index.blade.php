@extends('layouts.app')

@section('content')
<div class="container">
	<div class="d-flex justify-content-between align-items-center mb-4">
		<h3 class="mb-0 h3">Orders Status Update</h3>
	</div>

	@if(session('success'))
		<div class="alert alert-success">{{ session('success') }}</div>
	@endif

	<table class="table table-bordered">
		<thead>
			<tr>
				<th>#</th>
				<th>Customer</th>
				<th>Status</th>
				<th>Total</th>
				<th>Updated Date</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			@forelse($orders as $order)
				<tr>
					<td>{{ $order->id }}</td>
					<td>{{ $order->user->name ?? 'N/A' }}</td>
					<td id="order-status-{{ $order->id }}">
						<span class="badge bg-info">{{ ucfirst($order->status) }}</span>
					</td>
					<td>₹ {{ number_format($order->total_price, 2) }}</td>
					<td>{{ $order->updated_at->format('d M, Y h:i') }}</td>
					<td>
						<a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-primary">
							Show / Update
						</a>
					</td>
				</tr>
			@empty
				<tr>
					<td colspan="6">No orders found.</td>
				</tr>
			@endforelse
		</tbody>
	</table>

	<div class="mt-3">
		{{ $orders->links() }}
	</div>
</div>
@endsection
