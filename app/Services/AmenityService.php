<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Amenity;
use Illuminate\Support\Str;

class AmenityService
{
    /**
     * Match a given amenity name with existing ones or create a new one.
     *
     * @param string $name The amenity name (e.g., from an external source)
     * @param string|null $type The type of listing (e.g., 'property' or 'car')
     * @param int $threshold The similarity threshold percentage (0-100)
     * @return Amenity
     */
    public function matchOrCreate(string $name, ?string $type = null, int $threshold = 75): Amenity
    {
        $name = trim($name);
        
        if (empty($name)) {
            throw new \InvalidArgumentException('Amenity name cannot be empty.');
        }

        $query = Amenity::query();
        if ($type) {
            $query->where('type', $type);
        }

        $existingAmenities = $query->get();

        $bestMatch = null;
        $highestSimilarity = 0;

        foreach ($existingAmenities as $amenity) {
            // Check similarity with English name
            similar_text(strtolower($name), strtolower($amenity->name), $percentEn);
            
            // Check similarity with Arabic name if it exists
            $percentAr = 0;
            if ($amenity->name_ar) {
                similar_text(mb_strtolower($name), mb_strtolower($amenity->name_ar), $percentAr);
            }

            $currentMax = max($percentEn, $percentAr);

            if ($currentMax > $highestSimilarity) {
                $highestSimilarity = $currentMax;
                $bestMatch = $amenity;
            }
        }

        if ($highestSimilarity >= $threshold && $bestMatch) {
            return $bestMatch;
        }

        // If no match above threshold, create a new amenity
        return Amenity::create([
            'name' => $name, // Assuming the input is likely English or we just store it as default
            'type' => $type ?? 'property',
        ]);
    }
}
