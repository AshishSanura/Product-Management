<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PushSubscription;
use Illuminate\Support\Facades\Auth;

class PushSubscriptionController extends Controller
{
	/**
	 * Store a new subscription
	 */
	public function store(Request $request)
	{
		$user = Auth::user();

		$user->pushSubscriptions()->updateOrCreate(
			[
				'endpoint' => $request->endpoint,
			],
			[
				'public_key' => $request->keys['p256dh'],
				'auth_token' => $request->keys['auth'],
				'content_encoding' => $request->keys['contentEncoding'] ?? 'aesgcm',
			]
		);

		return response()->json(['success' => true]);
	}
}
