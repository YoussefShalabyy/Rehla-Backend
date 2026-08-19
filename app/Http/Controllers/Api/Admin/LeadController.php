<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\PotentialClient;
use App\Models\PlatformSetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LeadController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $perPage = (int) $request->query('per_page', 20);
        $step = $request->query('step');

        // Get aggregate counts
        $total = PotentialClient::count();
        $totalUnread = PotentialClient::where('is_read', false)->count();
        
        $dateSelectedTotal = PotentialClient::where('step', 'date_selected')->count();
        $dateSelectedUnread = PotentialClient::where('step', 'date_selected')->where('is_read', false)->count();
        
        $checkoutStartedTotal = PotentialClient::where('step', 'checkout_started')->count();
        $checkoutStartedUnread = PotentialClient::where('step', 'checkout_started')->where('is_read', false)->count();

        $leads = PotentialClient::with(['user', 'listing'])
            ->when($step, fn ($q) => $q->where('step', $step))
            ->latest()
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Leads retrieved successfully.',
            'data'    => $leads->items(),
            'meta'    => [
                'pagination' => [
                    'total'        => $leads->total(),
                    'per_page'     => $leads->perPage(),
                    'current_page' => $leads->currentPage(),
                    'last_page'    => $leads->lastPage(),
                ],
                'counts' => [
                    'total' => $total,
                    'total_unread' => $totalUnread,
                    'date_selected_total' => $dateSelectedTotal,
                    'date_selected_unread' => $dateSelectedUnread,
                    'checkout_started_total' => $checkoutStartedTotal,
                    'checkout_started_unread' => $checkoutStartedUnread,
                ]
            ],
        ]);
    }

    public function markRead(Request $request): JsonResponse
    {
        $step = $request->input('step');
        
        $query = PotentialClient::where('is_read', false);
        if ($step) {
            $query->where('step', $step);
        }
        
        $query->update(['is_read' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Leads marked as read.',
        ]);
    }

    public function updateStatus(Request $request, string $uuid): JsonResponse
    {
        $validStatuses = PlatformSetting::get('lead_statuses', ['pending', 'contacted', 'booked', 'lost']);

        $request->validate([
            'status' => ['required', Rule::in($validStatuses)],
        ]);

        $lead = PotentialClient::where('uuid', $uuid)->firstOrFail();
        $lead->update(['status' => $request->input('status')]);

        return response()->json([
            'success' => true,
            'message' => 'Lead status updated successfully.',
            'data'    => $lead,
        ]);
    }
}
