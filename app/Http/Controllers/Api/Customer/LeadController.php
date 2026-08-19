<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use App\Models\PotentialClient;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LeadController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'listing_uuid'   => ['required', 'string', 'exists:listings,uuid'],
            'check_in_date'  => ['required', 'date'],
            'check_out_date' => ['required', 'date', 'after:check_in_date'],
            'step'           => ['required', 'string', 'in:date_selected,checkout_started'],
            'device_id'      => ['nullable', 'string'],
            'guests_count'   => ['nullable', 'integer', 'min:1'],
        ]);

        $listing = Listing::where('uuid', $validated['listing_uuid'])->firstOrFail();
        $userId = auth('sanctum')->id();
        $deviceId = $validated['device_id'] ?? null;

        // Removed grouping logic for testing so every attempt shows up
        $lead = null;

        if ($lead) {
            // Update existing lead dates/guests
            $lead->update([
                'check_in_date'  => $validated['check_in_date'],
                'check_out_date' => $validated['check_out_date'],
                'guests_count'   => $validated['guests_count'] ?? $lead->guests_count,
            ]);
        } else {
            // Create new lead
            $lead = PotentialClient::create([
                'uuid'           => (string) Str::uuid(),
                'user_id'        => $userId,
                'listing_id'     => $listing->id,
                'check_in_date'  => $validated['check_in_date'],
                'check_out_date' => $validated['check_out_date'],
                'step'           => $validated['step'],
                'device_id'      => $deviceId,
                'guests_count'   => $validated['guests_count'] ?? null,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Lead registered successfully.',
            'data'    => $lead,
        ]);
    }
}
