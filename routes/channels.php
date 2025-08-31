<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
*/

Broadcast::channel('orders.{userId}', function ($user, $userId) {
	// Sirf wahi user join kar sake jiska id match karta ho
	return (int) $user->id === (int) $userId;
});