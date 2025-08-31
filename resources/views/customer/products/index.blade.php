@extends('layouts.app')

@section('content')
<div class="container">

	<div class="d-flex justify-content-between align-items-center mb-4">
		<h3 class="mb-0 h3">Browse Products</h3>
	</div>

	<!-- Products Table -->
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
		ajax: '{!! route('products.index') !!}',
		columns: [
			{ data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
			{ data: 'image', name: 'image', orderable: false, searchable: false },
			{ data: 'name', name: 'name' },
			{ data: 'price', name: 'price' },
			{ data: 'stock', name: 'stock' },
			{ data: 'category.name', name: 'category.name', defaultContent: 'N/A' },

		]
	});
});
</script>
@endsection
