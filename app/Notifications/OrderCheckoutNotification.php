<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCheckoutNotification extends Notification
{

    /**
     * Create a new notification instance.
     */
    public function __construct(public Order $order)
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Order Confirmation - Funshirt')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Thank you for your order! We have received it and will process it shortly.')
            ->line('')
            ->line('**Order Details:**')
            ->line('Order ID: ' . $this->order->id)
            ->line('Order Date: ' . $this->order->date->format('d/m/Y'))
            ->line('Total: €' . number_format($this->order->total_price, 2))
            ->line('Status: ' . ucfirst($this->order->status))
            ->line('')
            ->line('**Items:**')
            ->line($this->formatOrderItems())
            ->line('')
            ->line('**Shipping Address:**')
            ->line($this->order->address)
            ->line('')
            ->line('**Payment Method:**')
            ->line(ucfirst(str_replace('_', ' ', $this->order->payment_type)))
            ->when($this->order->notes, function ($mail) {
                return $mail->line('')->line('**Notes:**')->line($this->order->notes);
            })
            ->line('')
            ->action('View Order', url('/'))
            ->line('If you have any questions, please contact our support team.')
            ->salutation('Best regards, Funshirt Team');
    }

    /**
     * Format the order items as a readable string.
     */
    private function formatOrderItems(): string
    {
        $items = $this->order->items;
        $formatted = [];

        foreach ($items as $item) {
            $tshirt = $item->tshirtImage;
            $color = $item->color;

            $line = sprintf(
                '%s - %s, Size: %s, Color: %s, Qty: %d × €%.2f',
                $tshirt?->name ?? 'Product',
                $tshirt?->customer_id !== null ? '(Personalized)' : '(Catalog)',
                $item->size,
                $color?->name ?? $item->color_code,
                $item->qty,
                $item->unit_price
            );

            $formatted[] = $line;
        }

        return implode("\n", $formatted);
    }
}
