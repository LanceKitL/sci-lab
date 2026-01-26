<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class AccountApproved extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
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

    private function getLocalIpAddress()
    {
        try {
            // Create a fake socket connection to Google DNS (8.8.8.8)
            // We don't actually send data, we just want the OS to tell us our IP
            $socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
            socket_connect($socket, '8.8.8.8', 53);
            socket_getsockname($socket, $localIp);
            socket_close($socket);

            return 'http://' . $localIp . ':8000';
        } catch (\Exception $e) {
            // Fallback if the socket trick fails
            return 'http://' . gethostbyname(gethostname()) . ':8000';
        }
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        // 1. Get IP Dynamically
        $serverIp = $this->getLocalIpAddress(); 

        // 2. Generate QR Code
        $qrCodeUrl = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($serverIp);

        return (new MailMessage)
            ->subject('✅ Account Approved - Sci-Lab Access')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Your ID verification was successful! You now have access to the Sci-Lab System.')

            ->line(new HtmlString('<strong>⚠️ IMPORTANT NETWORK REQUIREMENT:</strong>'))
            ->line('To access the system, your device must be connected to the School Wi-Fi or the same network as the Admin.')
            
            // Show the detected IP clearly to the user
            ->line('System Address: ' . $serverIp)

            ->line('Scan this QR code to open the system on your phone:')
            ->line(new HtmlString('<div style="text-align: center; margin: 20px 0;"><img src="'.$qrCodeUrl.'" alt="Scan QR Code" style="border: 4px solid #fff; box-shadow: 0 4px 6px rgba(0,0,0,0.1);"></div>'))
            
            ->action('Or Click Here to Login', $serverIp . '/login')

            ->line(new HtmlString('<strong>📝 NOTE ON BORROWING:</strong>'))
            ->line('Submitting a borrow request does NOT mean you can take the equipment immediately.')
            ->line('You must wait for the Admin to approve your specific request in the system before retrieving any items.')

            ->line('Thank you,')
            ->line('The Sci-Lab Admin Team');
    }
    
    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
