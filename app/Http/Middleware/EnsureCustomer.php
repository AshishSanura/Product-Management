<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Auth;

class EnsureCustomer
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
	 */
	public function handle(Request $request, Closure $next): Response
	{
		if (!Auth::guard('customer')->check()) {
			return redirect()->route('login');
		}
		$user = Auth::guard('customer')->user();
		if (!$user || $user->role !== 'user') {
			Auth::guard('customer')->logout();
			return redirect()->route('login')->with('error', 'Unauthorized access.');
		}
		return $next($request);
	}
}
