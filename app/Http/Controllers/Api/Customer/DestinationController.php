<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use Illuminate\Http\JsonResponse;

class DestinationController extends Controller
{
    /**
     * Get suggested destinations
     */
    public function suggested(): JsonResponse
    {
        // Use a flexible subquery to allow fuzzy matching on city names (e.g. 'El Gouna' matches 'Gouna')
        $destinations = Destination::where('is_active', true)
            ->addSelect(['listings_count' => \App\Models\Listing::selectRaw('count(*)')
                ->whereRaw('listings.city LIKE CONCAT("%", destinations.name, "%")')
                ->active()
            ])
            ->having('listings_count', '>', 0)
            ->orderBy('sort_order', 'asc')
            ->orderBy('name', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Suggested destinations retrieved successfully.',
            'data'    => \App\Http\Resources\Destination\DestinationResource::collection($destinations),
            'meta'    => null,
            'errors'  => null,
        ]);
    }
}
