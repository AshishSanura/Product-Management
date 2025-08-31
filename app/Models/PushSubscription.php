<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use NotificationChannels\WebPush\HasPushSubscriptions;

class PushSubscription extends Model
{
	use HasPushSubscriptions;
	protected $fillable = [
		'user_id',
		'endpoint',
		'public_key',
		'auth_token',
		'content_encoding',
	];
	public function subscribable()
	{
		return $this->morphTo();
	}
}
