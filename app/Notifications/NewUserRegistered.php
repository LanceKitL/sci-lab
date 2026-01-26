<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class NewUserRegistered extends Notification
{
    use Queueable;

    public $newUser; // Variable to hold the new user's info

    /**
     * Create a new notification instance.
     */
    public function __construct($newUser)
    {
        $this->newUser = $newUser;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('🔔 New Registration: ' . $this->newUser->name)
            ->greeting('Hello Admin,')
            
            ->line('A new user has just registered and is waiting for ID verification.')

            // USER DETAILS CARD
            ->line(new HtmlString('<div style="background-color: #f9fafb; padding: 15px; border: 1px solid #e5e7eb; border-radius: 8px; margin-bottom: 20px;">
                <strong>Name:</strong> ' . $this->newUser->name . '<br>
                <strong>Email:</strong> ' . $this->newUser->email . '<br>
                <strong>Role:</strong> ' . ucfirst($this->newUser->role) . '<br>
                <strong>Time:</strong> ' . $this->newUser->created_at->format('M d, h:i A') . '
            </div>'))

            ->line('Please review their uploaded School ID to approve or reject this account.')

            // Link directly to the approval page
            ->action('Review Application', route('admin.users.index'))

            ->line('Thank you!');
    }

    public function toArray(object $notifiable): array
    {
        return [];
    }
}