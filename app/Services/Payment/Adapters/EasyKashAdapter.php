<?php

declare(strict_types=1);

namespace App\Services\Payment\Adapters;

use App\Interfaces\PaymentGatewayInterface;
use Illuminate\Support\Facades\Http;
use Exception;

class EasyKashAdapter implements PaymentGatewayInterface
{
    private string $apiKey;
    private string $secretKey;
    private string $webhookSecret;
    private string $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('payment.easykash.api_key', '');
        $this->secretKey = config('payment.easykash.secret_key', '');
        $this->webhookSecret = config('payment.easykash.webhook_secret', '');
        // Default to a sandbox/production URL based on their docs when available
        $this->baseUrl = config('payment.easykash.base_url', 'https://api.easykash.net/v1');
    }

    public function charge(array $payload): array
    {
        try {
            // TODO: Implement EasyKash charge logic based on API documentation
            // Typical flow:
            // 1. Send POST request to EasyKash checkout endpoint
            // 2. Return the checkout URL for the frontend WebView
            
            /*
            $response = Http::withToken($this->secretKey)->post("{$this->baseUrl}/checkout", [
                'amount' => $payload['amount_cents'] / 100, // typically gateways expect main currency unit or cents
                'currency' => $payload['currency'] ?? 'EGP',
                'reference' => $payload['booking_reference'] . '-' . time(),
                'customer' => [
                    'name' => $payload['customer_name'] ?? 'Guest',
                    'email' => $payload['customer_email'] ?? 'test@example.com',
                    'phone' => $payload['customer_phone'] ?? '+201000000000',
                ]
            ]);

            if (! $response->successful()) {
                throw new Exception('EasyKash charge failed: ' . $response->body());
            }

            $checkoutUrl = $response->json('data.checkout_url');
            $transactionId = (string) $response->json('data.id');
            */
            
            // Placeholder return
            return [
                'success' => true,
                'transaction_id' => 'temp-txn-' . uniqid(),
                'checkout_url' => 'https://checkout.easykash.net/temp',
                'raw' => ['status' => 'pending_implementation'],
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'transaction_id' => null,
                'checkout_url' => null,
                'raw' => ['error' => $e->getMessage()],
            ];
        }
    }

    public function refund(string $transactionId, int $amountCents): array
    {
        try {
            // TODO: Implement EasyKash refund logic based on API documentation
            /*
            $response = Http::withToken($this->secretKey)->post("{$this->baseUrl}/refund", [
                'transaction_id' => $transactionId,
                'amount' => $amountCents / 100,
            ]);

            return [
                'success' => $response->successful(),
                'raw' => $response->json(),
            ];
            */

            return [
                'success' => true,
                'raw' => ['status' => 'refund_pending_implementation'],
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'raw' => ['error' => $e->getMessage()],
            ];
        }
    }

    public function verifyWebhook(array $payload, string $signature): bool
    {
        // TODO: Implement EasyKash webhook signature verification
        // Usually it involves hashing the payload with a secret and comparing to the signature header.
        /*
        $calculatedSignature = hash_hmac('sha256', json_encode($payload), $this->webhookSecret);
        return hash_equals($calculatedSignature, $signature);
        */

        return true; // Placeholder
    }

    public function extractWebhookData(array $payload): array
    {
        // TODO: Extract exact transaction ID and success state from EasyKash webhook payload
        /*
        $transactionId = (string) ($payload['data']['id'] ?? '');
        $status = $payload['data']['status'] ?? 'failed';
        $success = $status === 'successful' || $status === 'paid';
        */

        $transactionId = (string) ($payload['transaction_id'] ?? '');
        $success = ($payload['status'] ?? '') === 'success';

        return [
            'transaction_id' => $transactionId ?: null,
            'success' => $success,
        ];
    }
}
