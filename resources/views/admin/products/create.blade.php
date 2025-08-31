@extends('layouts.app')

@section('content')
<div class="container">
	<h2 class="h2">Create Product</h2>
	<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
		@csrf

		<div class="mb-3">
			<label class="form-label">Product Name</label>
			<input type="text" name="name" class="form-control" 
				   value="{{ old('name') }}" placeholder="Enter your product name">
			@error('name') <small class="text-danger">{{ $message }}</small> @enderror
		</div>

		<div class="mb-3">
			<label class="form-label">Description</label>
			<textarea name="description" class="form-control" placeholder="Enter your description">{{ old('description') }}</textarea>
			@error('description') <small class="text-danger">{{ $message }}</small> @enderror

		</div>

		<div class="mb-3">
			<label class="form-label">Price</label>
			<input type="number" step="0.01" name="price" class="form-control" 
				   value="{{ old('price') }}" placeholder="Enter your price">
			@error('price') <small class="text-danger">{{ $message }}</small> @enderror
		</div>

		<div class="mb-3">
			<label class="form-label">Stock</label>
			<input type="number" name="stock" class="form-control" 
				   value="{{ old('stock') }}" placeholder="Enter your available stock">
			@error('stock') <small class="text-danger">{{ $message }}</small> @enderror
		</div>

		<div class="mb-3">
			<label class="form-label">Category</label>
			<select name="category_id" class="form-select">
				<option value="">-- Select Category --</option>
				@foreach($categories as $id => $name)
					<option value="{{ $id }}" {{ old('category_id') == $id ? 'selected' : '' }}>
						{{ $name }}
					</option>
				@endforeach
			</select>
			@error('category_id') <small class="text-danger">{{ $message }}</small> @enderror
		</div>

		<div class="mb-3">
			<label class="form-label">Product Image</label>
			<input type="file" name="image" class="form-control" accept="image/*">
			@error('image') <small class="text-danger">{{ $message }}</small> @enderror
		</div>

		<button type="submit" class="btn btn-primary">Add Product</button>
		<a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
	</form>
</div>
@endsection