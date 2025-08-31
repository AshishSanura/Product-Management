<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class OrderPlaceController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		$orders = Order::where('user_id', Auth::id())->with('product')->latest()->get();
		return view('customer.orders.index', compact('orders'));
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create()
	{
		$products = Product::all();
		return view('customer.orders.create', compact('products'));
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request)
	{
		$request->validate([
			'product_id' => 'required|exists:products,id',
			'quantity'   => 'required|integer|min:1',
		]);

		$product = Product::findOrFail($request->product_id);

		$total = $product->price * $request->quantity;

		Order::create([
			'user_id'     => Auth::id(),
			'product_id'  => $product->id,
			'quantity'    => $request->quantity,
			'total_price' => $total,
			'status'      => 'pending',
		]);

		return redirect()->route('orders.index')->with('success', 'Order placed successfully!');
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
