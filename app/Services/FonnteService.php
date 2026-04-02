<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FonnteService
{
    protected $token;

    public function __construct()
    {
        $this->token = env('FONNTE_TOKEN');
    }

    /**
     * Send a WhatsApp message using Fonnte API.
     *
     * @param string $target The destination phone number (e.g., 08123456789)
     * @param string $message The message content
     * @return array
     */
    public function sendMessage($target, $message)
    {
        if (!$this->token) {
            Log::warning('Fonnte token not set. Message not sent.');
            return ['status' => false, 'reason' => 'token_not_set'];
        }

        // Clean target: replace leading '0' with '62'
        $target = preg_replace('/^0/', '62', $target);
        // Remove any non-numeric characters
        $target = preg_replace('/[^0-9]/', '', $target);

        try {
            $response = Http::withHeaders([
                'Authorization' => $this->token,
            ])->post('https://api.fonnte.com/send', [
                'target' => $target,
                'message' => $message,
            ]);

            $result = $response->json();

            if ($response->successful() && ($result['status'] ?? false)) {
                return ['status' => true, 'data' => $result];
            }

            Log::error('Fonnte Error: ' . ($result['reason'] ?? $response->body()));
            return ['status' => false, 'reason' => $result['reason'] ?? 'api_error'];

        } catch (\Exception $e) {
            Log::error('Fonnte Exception: ' . $e->getMessage());
            return ['status' => false, 'reason' => 'exception'];
        }
    }
}
