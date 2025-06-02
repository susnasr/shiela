<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Order;

class OrderStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Your Order #' . $this->order->id . ' Status Update')
            ->line('Your order status has been updated to: ' . ucfirst($this->order->status))
            ->line('Order Total: $' . number_format($this->order->total_amount, 2))
            ->action('View Order', url('/orders/' . $this->order->id))
            ->line('Thank you for shopping with Sheila!');
    }
}
