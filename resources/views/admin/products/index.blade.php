@extends('layouts.app')

@section('content')
<div class="container">

	@if(session('success'))
		<div class="alert alert-success alert-dismissible fade show" role="alert">
			{{ session('success') }}
			<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
		</div>
	@endif

	<div class="d-flex justify-content-between align-items-center mb-4">
		<h3 class="mb-0 h3">Products</h3>
		<a href="{{ route('admin.products.create') }}" class="btn btn-primary">
			<i class="bi bi-plus-circle"></i> Add Product
		</a>
	</div>

	<!-- CSV Import Section -->
	<div class="card shadow-sm mb-4">
		<div class="card-header bg-light">
			<strong>Import Products via CSV</strong>
		</div>
		<div class="card-body">
			<form action="{{ route('admin.products.import') }}" method="POST" enctype="multipart/form-data">
				@csrf
				<div class="input-group">
					<input type="file" name="file" required accept=".csv" class="form-control">
					<button type="submit" class="btn btn-secondary">
						<i class="bi bi-upload"></i> Import
					</button>
				</div>
			</form>
		</div>
	</div>

	<!-- Products Table Section-->
	<div class="card shadow-sm">
		<div class="card-body">
			<table class="table table-striped table-bordered align-middle" id="products-table">
				<thead class="table-light">
					<tr>
						<th>#</th>
						<th>Image</th>
						<th>Name</th>
						<th>Price</th>
						<th>Stock</th>
						<th>Category</th>
						<th width="120">Action</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
$(function() {
	$('#products-table').DataTable({
		processing: true,
		serverSide: true,
		ajax: '{!! route('admin.products.index') !!}',
		columns: [
			{ data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
			{ data: 'image', name: 'image', orderable: false, searchable: false },
			{ data: 'name', name: 'name' },
			{ data: 'price', name: 'price' },
			{ data: 'stock', name: 'stock' },
			{ data: 'category.name', name: 'category.name', defaultContent: 'N/A' },
			{ data: 'action', name: 'action', orderable:false, searchable:false }
		]
	});
});
</script>
@endsection