<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Listing;

class HomeSectionController extends Controller
{
    /**
     * List all home sections
     */
    public function index(): JsonResponse
    {
        $sections = DB::table('home_sections')->get();

        return $this->success($sections, 'Home sections retrieved successfully.');
    }

    /**
     * Get listings for a specific section
     */
    public function show(string $key): JsonResponse
    {
        $section = DB::table('home_sections')->where('key', $key)->first();
        
        if (!$section) {
            abort(404, 'Section not found');
        }

        $listings = DB::table('home_section_listing')
            ->join('listings', 'listings.id', '=', 'home_section_listing.listing_id')
            ->where('home_section_listing.home_section_key', $key)
            ->orderBy('home_section_listing.sort_order', 'asc')
            ->select('listings.uuid', 'listings.title', 'listings.type', 'listings.city', 'home_section_listing.sort_order')
            ->get();

        return $this->success([
            'section' => $section,
            'listings' => $listings,
        ], 'Section listings retrieved successfully.');
    }

    /**
     * Sync listings and their order for a section
     */
    public function sync(Request $request, string $key): JsonResponse
    {
        $request->validate([
            'listings' => ['required', 'array'],
            'listings.*.uuid' => ['required', 'uuid', 'exists:listings,uuid'],
            'listings.*.sort_order' => ['required', 'integer', 'min:0'],
        ]);

        $section = DB::table('home_sections')->where('key', $key)->first();
        if (!$section) {
            abort(404, 'Section not found');
        }

        DB::transaction(function () use ($request, $key) {
            // Delete existing
            DB::table('home_section_listing')->where('home_section_key', $key)->delete();

            // Prepare new batch
            $inserts = [];
            foreach ($request->input('listings') as $item) {
                $listing = Listing::where('uuid', $item['uuid'])->first();
                if ($listing) {
                    $inserts[] = [
                        'home_section_key' => $key,
                        'listing_id' => $listing->id,
                        'sort_order' => $item['sort_order'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }

            if (!empty($inserts)) {
                DB::table('home_section_listing')->insert($inserts);
            }
        });

        return $this->success(null, 'Home section synced successfully.');
    }
}
