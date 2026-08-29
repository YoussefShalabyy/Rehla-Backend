<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ActiveCategoryController extends Controller
{
    private array $categoryDefinitions = [
        'villa' => ['name' => 'Villas', 'name_ar' => 'فيلات', 'icon' => 'home-outline', 'type' => 'property'],
        'apartment' => ['name' => 'Apartments', 'name_ar' => 'شقق', 'icon' => 'business-outline', 'type' => 'property'],
        'hotel' => ['name' => 'Hotels', 'name_ar' => 'فنادق', 'icon' => 'business-outline', 'type' => 'property'],
        'room' => ['name' => 'Rooms', 'name_ar' => 'غرف', 'icon' => 'bed-outline', 'type' => 'property'],
        'luxury' => ['name' => 'Luxury Cars', 'name_ar' => 'سيارات فارهة', 'icon' => 'car-sport-outline', 'type' => 'car'],
        'sports' => ['name' => 'Sports Cars', 'name_ar' => 'سيارات رياضية', 'icon' => 'car-sport-outline', 'type' => 'car'],
        'economy' => ['name' => 'Economy Cars', 'name_ar' => 'سيارات اقتصادية', 'icon' => 'car-outline', 'type' => 'car'],
        'daily' => ['name' => 'Daily Cars', 'name_ar' => 'سيارات يومية', 'icon' => 'car-outline', 'type' => 'car'],
        'suv' => ['name' => 'SUVs & Crossovers', 'name_ar' => 'SUV وكروس أوفر', 'icon' => 'car-outline', 'type' => 'car'],
    ];

    public function __invoke(Request $request): JsonResponse
    {
        $lang = $request->header('Accept-Language', 'en');

        $activePropertyTypes = Listing::where('status', \App\Enums\ListingStatus::Active)
            ->whereNotNull('property_type')
            ->select('property_type')
            ->distinct()
            ->pluck('property_type')
            ->toArray();

        $activeCategories = Listing::where('status', \App\Enums\ListingStatus::Active)
            ->whereNotNull('category')
            ->select('category')
            ->distinct()
            ->pluck('category')
            ->toArray();

        $mergedIds = array_values(array_unique(array_merge($activePropertyTypes, $activeCategories)));

        $formattedCategories = [];
        foreach ($mergedIds as $id) {
            if (isset($this->categoryDefinitions[$id])) {
                $def = $this->categoryDefinitions[$id];
                $resolvedName = ($lang === 'ar' && !empty($def['name_ar'])) ? $def['name_ar'] : $def['name'];
                
                $formattedCategories[] = [
                    'id' => $id,
                    'name' => $resolvedName,
                    'name_en' => $def['name'],
                    'name_ar' => $def['name_ar'],
                    'icon' => $def['icon'],
                    'type' => $def['type'],
                ];
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Active categories retrieved.',
            'data'    => $formattedCategories,
            'meta'    => null,
            'errors'  => null,
        ]);
    }
}
