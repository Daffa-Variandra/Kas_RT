<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class WhatsAppService
{
    /**
     * Mockup for sending WhatsApp message.
     * In a real world scenario, you would integrate with providers like Fonnte, Watzap, Twilio, etc.
     * 
     * @param string $phone
     * @param string $message
     * @return bool
     */
    public function sendMessage(string $phone, string $message): bool
    {
        // Remove non-numeric characters (except maybe +)
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // Convert leading 0 to 62 (Indonesian code)
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }

        // Mock integration
        Log::channel('single')->info("MOCK WA SENDED TO [$phone]:\n$message\n---");

        /*
        // Example with Fonnte
        $response = Http::withHeaders([
            'Authorization' => env('FONNTE_TOKEN'),
        ])->post('https://api.fonnte.com/send', [
            'target' => $phone,
            'message' => $message,
            'countryCode' => '62',
        ]);

        return $response->successful();
        */

        return true;
    }
}
