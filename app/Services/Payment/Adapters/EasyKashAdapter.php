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
        $this->baseUrl = config('payment.easykash.base_url', 'https://back.easykash.net/api/directpayv1');
    }

    public function charge(array $payload): array
    {
        try {
            // Uniquely identify this payment attempt
            $customerReference = $payload['booking_reference'] . '-' . uniqid();

            $response = Http::withHeaders([
                'authorization' => $this->apiKey,
            ])->post("{$this->baseUrl}/pay", [
                'amount' => $payload['amount_cents'] / 100, // Amount must be in EGP
                'currency' => $payload['currency'] ?? 'EGP',
                'name' => $payload['customer_name'] ?? 'Guest',
                'email' => $payload['customer_email'] ?? 'guest@example.com',
                'mobile' => $payload['customer_phone'] ?? '01000000000',
                'redirectUrl' => config('app.url') . '/api/v1/payments/redirect',
                'customerReference' => $customerReference,
            ]);

            if (! $response->successful()) {
                throw new Exception('EasyKash charge failed: ' . $response->body());
            }

            $checkoutUrl = $response->json('redirectUrl');

            return [
                'success' => true,
                'transaction_id' => $customerReference, // Store our reference as transaction_id to match later
                'checkout_url' => $checkoutUrl,
                'raw' => $response->json(),
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
        // The webhook documentation specifies sorting these exactly:
        $dataToSecure = [
            $payload['ProductCode'] ?? '',
            $payload['Amount'] ?? '',
            $payload['ProductType'] ?? '',
            $payload['PaymentMethod'] ?? '',
            $payload['status'] ?? '',
            $payload['easykashRef'] ?? '',
            $payload['customerReference'] ?? '',
        ];

        $dataStr = implode('', $dataToSecure);
        
        // It's possible the secret key is used instead of a separate webhook secret
        $secret = $this->webhookSecret ?: $this->secretKey;
        
        $calculatedSignature = hash_hmac('sha512', $dataStr, $secret);

        return hash_equals($calculatedSignature, $signature);
    }

    public function extractWebhookData(array $payload): array
    {
        // We stored customerReference as the transaction_id when initiating
        $transactionId = (string) ($payload['customerReference'] ?? '');
        $status = $payload['status'] ?? '';
        $success = $status === 'PAID';

        return [
            'transaction_id' => $transactionId ?: null,
            'success' => $success,
        ];
    }
}
