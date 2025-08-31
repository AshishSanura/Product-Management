<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\Models\Order;

class OrderStatusUpdated
{
	use Dispatchable, SerializesModels;

	public $order;

	/**
	 * Create a new event instance.
	 */
	public function __construct(Order $order)
	{
		$this->order = $order;
	}

	/**
	 * Get the channels the event should broadcast on.
	 */
	public function broadcastOn(): Channel
	{
		return new PresenceChannel('orders.' . $this->order->user_id);
	}

	/**
	 * Get the channels the event should broadcast on.
	 *
	 * @return array<int, \Illuminate\Broadcasting\Channel>
	 */
	public function broadcastWith(): array
	{
		return [
			'order_id' => $this->order->id,
			'status' => $this->order->status,
		];
	}

	public function broadcastAs(): string
    {
        return 'OrderStatusUpdated';
    }
}
