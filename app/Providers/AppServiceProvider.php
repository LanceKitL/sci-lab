<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate; // <--- This imports the Gate tool
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // This defines the 'admin' rule
        Gate::define('admin', function (User $user) {
            return $user->role === 'admin';
        });

        ResetPassword::createUrlUsing(function ($user, $token) {
            
            // DEFAULT: Start with localhost
            $serverIp = 'http://localhost:8000'; 

            // METHOD 1: Try the Socket Trick (Fastest)
            try {
                if(extension_loaded('sockets')) {
                    $socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
                    socket_connect($socket, '8.8.8.8', 53);
                    socket_getsockname($socket, $localIp);
                    socket_close($socket);
                    $serverIp = 'http://' . $localIp . ':8000';
                } else {
                    throw new \Exception('Sockets not enabled');
                }
            } catch (\Exception $e) {
                // METHOD 2: Windows IPConfig Fallback (Works if Sockets are off)
                try {
                    $output = [];
                    // Run ipconfig and verify we get output
                    exec('ipconfig', $output);
                    
                    foreach ($output as $line) {
                        // Look for "IPv4 Address" pattern
                        if (preg_match('/IPv4 Address.*: ([\d\.]+)/', $line, $matches)) {
                            // Check if it's NOT localhost (127.0.0.1)
                            if ($matches[1] !== '127.0.0.1') {
                                $serverIp = 'http://' . $matches[1] . ':8000';
                                break;
                            }
                        }
                    }
                } catch (\Exception $ex) {
                    // If everything fails, stay on localhost
                }
            }

            // Generate the link
            $originalUrl = route('password.reset', [
                'token' => $token,
                'email' => $user->email,
            ]);

            // Swap localhost with the Real IP
            return str_replace(url('/'), $serverIp, $originalUrl);
        });
    }
}