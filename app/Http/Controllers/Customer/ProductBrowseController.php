<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;

class ProductBrowseController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index(Request $request)
	{
		if ($request->ajax()) {
			$products = Product::select('id','name','price','stock','image','category_id','created_at')
				->with('category');

			return DataTables::of($products)
				->addIndexColumn()
				->addColumn('image', function ($product) {
					$imagePath = $product->image && Storage::disk('public')->exists('products/'.$product->image)
						? 'storage/products/'.$product->image
						: 'storage/products/default.png';

					return "<img src='".asset($imagePath)."' style='width:60px;height:60px;object-fit:cover' />";
				})
				->rawColumns(['image'])
				->make(true);
		}

		return view('customer.products.index');
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request)
	{
		//
	}

	/**
	 * Display the specified resource.
	 */
	public function show(string $id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(string $id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, string $id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(string $id)
	{
		//
	}
}
