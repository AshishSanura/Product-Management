<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Events\OrderStatusUpdated;
use App\Notifications\OrderStatusNotification;

class OrderController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		$orders = Order::with('user','product')->latest()->paginate(10);
		return view('admin.orders.index', compact('orders'));
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create(Order $order)
	{
		return view('admin.orders.show', compact('order'));
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
	public function show(Order $order)
	{
		return view('admin.orders.show', compact('order'));
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
	public function update(Request $request, Order $order)
	{
		$request->validate([
			'status' => 'required|in:Pending,Shipped,Delivered'
		]);

		$order->update([
			'status' => $request->status
		]);

		// Fire Event (Websocket Broadcast)
		broadcast(new OrderStatusUpdated($order))->toOthers();

		// Notify Customer (Push Notification)
		if($order->user){
			$order->user->notify(new OrderStatusNotification($order));
		}

		return back()->with('success', 'Order status updated!');
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(string $id)
	{
		//
	}
}
