@extends('layouts.app')

@section('content')
<div class="container">
	<div class="d-flex justify-content-between align-items-center mb-4">
		<h3 class="mb-0 h3">Place New Order</h3>
	</div>
	<form action="{{ route('orders.store') }}" method="POST">
		@csrf

		<div class="mb-3">
			<label>Product</label>
			<select name="product_id" class="form-control" required>
				<option value="">-- Select Product --</option>
				@foreach($products as $product)
					<option value="{{ $product->id }}">
						{{ $product->name }} (₹{{ $product->price }})
					</option>
				@endforeach
			</select>
			@error('product_id') <small class="text-danger">{{ $message }}</small> @enderror
		</div>

		<div class="mb-3">
			<label>Quantity</label>
			<input type="number" name="quantity" class="form-control" min="1" required>
			@error('quantity') <small class="text-danger">{{ $message }}</small> @enderror
		</div>

		<button type="submit" class="btn btn-primary">Place Order</button>
	</form>
</div>
@endsection
