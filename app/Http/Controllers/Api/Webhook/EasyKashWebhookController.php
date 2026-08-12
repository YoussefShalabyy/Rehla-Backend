<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Webhook;

use App\Http\Controllers\Controller;
use App\Services\Payment\PaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EasyKashWebhookController extends Controller
{
    public function __construct(private readonly PaymentService $paymentService)
    {
    }

    public function handle(Request $request): JsonResponse
    {
        $payload = $request->all();
        // Typically EasyKash will send a signature in a specific header, e.g., 'X-EasyKash-Signature'
        $signature = $request->header('X-EasyKash-Signature', '');

        try {
            $this->paymentService->handleWebhook($payload, $signature);
            
            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            Log::error('EasyKash Webhook Failed: ' . $e->getMessage(), [
                'payload' => $payload,
                'signature' => $signature,
            ]);

            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }
}
