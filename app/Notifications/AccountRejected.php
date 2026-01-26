<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class AccountRejected extends Notification
{
    use Queueable;

    public function __construct()
    {
        //
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Helper to get the registration URL dynamically
     */
    private function getRegistrationUrl()
    {
        try {
            // Try to find the local IP to help them register again easily
            $socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
            socket_connect($socket, '8.8.8.8', 53);
            socket_getsockname($socket, $localIp);
            socket_close($socket);
            return 'http://' . $localIp . ':8000/register';
        } catch (\Exception $e) {
            return route('register');
        }
    }

    public function toMail(object $notifiable): MailMessage
    {
        $registerUrl = $this->getRegistrationUrl();

        return (new MailMessage)
            ->subject('⚠️ Registration Update - Action Required')
            ->greeting('Hello ' . $notifiable->name . ',')
            
            ->line('We appreciate your interest in the Sci-Lab System. We have reviewed your account application.')
            
            // THE BAD NEWS (Polite)
            ->line(new HtmlString('<div style="background-color: #fee2e2; padding: 15px; border-left: 4px solid #ef4444; color: #991b1b;">
                <strong>Application Status: Declined</strong><br>
                We could not verify your identity based on the School ID photo provided.
            </div>'))

            // THE REASON
            ->line('Common reasons for rejection include:')
            ->line('• The ID photo was blurry or unreadable.')
            ->line('• The ID is expired or does not match the account details.')
            ->line('• The photo was not a valid School ID.')

            // THE CLEANUP NOTICE
            ->line('For security purposes and to keep our database clean, your account details and the uploaded image have been removed from our system.')

            // THE SOLUTION
            ->line('You are welcome to register again immediately using a clear, readable photo of your School ID.')

            ->action('Register Again', $registerUrl)

            ->line('Thank you,')
            ->line('The Sci-Lab Admin Team');
    }

    public function toArray(object $notifiable): array
    {
        return [];
    }
}