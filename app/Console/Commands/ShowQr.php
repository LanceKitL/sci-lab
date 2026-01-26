<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

class ShowQr extends Command
{
    protected $signature = 'sci:qr {url}';
    protected $description = 'Generate a QR Code in the terminal';

    public function handle()
    {
        $url = $this->argument('url');

        // Configure for TEXT output (Best for Windows CMD)
        $options = new QROptions([
            'version'      => 5, // Fixes the size to make it scannable
            'outputType'   => QRCode::OUTPUT_STRING_TEXT,
            'eccLevel'     => QRCode::ECC_L,
        ]);

        $this->info("");
        $this->info("  SCAN THIS TO CONNECT:");
        $this->info("  " . $url);
        $this->info("");

        // Generate and Print
        $qrcode = (new QRCode($options))->render($url);
        
        // Output the QR code line by line
        $this->line($qrcode);
        
        $this->info("");
        return 0;
    }
}