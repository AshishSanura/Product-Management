<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Category;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\Storage;
use App\Jobs\ImportProductsJob;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index(Request $request)
	{
		if ($request->ajax()) {
			$products = Product::select('id', 'name', 'price', 'stock', 'image', 'category_id', 'created_at')
            ->with('category');

			return DataTables::of($products)
				->addIndexColumn()
				->addColumn('image', function ($product) {
					$imagePath = $product->image && Storage::disk('public')->exists('products/'.$product->image)
						? 'storage/products/'.$product->image
						: 'storage/products/default.png';

					return "<img src='".asset($imagePath)."' style='width:60px;height:60px;object-fit:cover' />";
				})
				->addColumn('action', function ($product) {
					$edit = '<a href="'.route('admin.products.edit', $product).'" class="btn btn-sm btn-primary">Edit</a>';
					$del = '<form method="POST" action="'.route('admin.products.destroy', $product).'" style="display:inline">'
						.csrf_field().method_field('DELETE')
						.'<button class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</button></form>';
					return $edit . ' ' . $del;
				})
				->rawColumns(['image','action'])
				->make(true);
		}
		return view('admin.products.index');
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create()
	{
		$categories = Category::pluck('name', 'id');
		return view('admin.products.create', compact('categories'));
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(StoreProductRequest $request)
	{
		$data = $request->validated();

		if ($request->hasFile('image')) {
			$path = $request->file('image')->store('products', 'public');
        	$data['image'] = basename($path);
		} else {
			$data['image'] = 'products/default.png';
		}
		
		Product::create($data);
		return redirect()->route('admin.products.index')
			->with('success', 'Product created successfully!');
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(Product $product)
	{
		$categories = Category::pluck('name', 'id');
		return view('admin.products.edit', compact('product', 'categories'));
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(UpdateProductRequest $request, Product $product)
	{
		$data = $request->validated();
		
		if ($request->hasFile('image')) {
			if ($product->image && Storage::disk('public')->exists('products/'.$product->image)) {
				Storage::disk('public')->delete('products/'.$product->image);
			}
			$path = $request->file('image')->store('products', 'public');
			$data['image'] = basename($path);
		}

		$product->update($data);
		return redirect()->route('admin.products.index')
			->with('success', 'Product updated successfully!');
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Product $product)
	{  
		if ($product->image && Storage::disk('public')->exists('products/'.$product->image)) {
        Storage::disk('public')->delete('products/'.$product->image);
    }
		$product->delete();
		return back()->with('success', 'Product deleted successfully!');
	}

	// Upload CSV and dispatch import job
	public function import(Request $request)
	{
		$request->validate([
			'file' => 'required|file|mimes:csv'
		]);
		$file = $request->file('file');
		$path = $file->store('imports', 'public');

		ImportProductsJob::dispatch($path, auth()->id());
		return back()->with('success', 'Import started. Processing in background via queue.');
	}
}