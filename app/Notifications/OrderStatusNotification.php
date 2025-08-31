<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;

use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushMessage;


class OrderStatusNotification extends Notification
{
	use Queueable;

	/**
	 * Create a new notification instance.
	 */
	public function __construct($order)
	{
		$this->order = $order;
	}

	/**
	 * Get the notification's delivery channels.
	 *
	 * @return array<int, string>
	 */
	public function via($notifiable): array
	{
		return ['database', 'webpush'];
	}

	/**
	 * Get the mail representation of the notification.
	 */
	public function toWebPush($notifiable, $notification)
	{
		return (new WebPushMessage)
			->title('Order Status Updated')
			->body("Your order #{$this->order->id} is now {$this->order->status}")
			->action('View Order', url('/orders/' . $this->order->id));
	}

	/**
	 * Get the array representation of the notification.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray($notifiable): array
	{
		return [
			'order_id' => $this->order->id,
			'status' => $this->order->status,
		];
	}
}
