<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Listing;
use App\Models\Amenity;
use App\Models\Review;

echo "--- AMENITIES ANALYSIS ---\n";
$amenities = Amenity::all();
$missingTranslations = [];
foreach ($amenities as $amenity) {
    if (empty($amenity->name_ar)) {
        $missingTranslations[] = $amenity->name;
    }
}
echo "Total Amenities: " . $amenities->count() . "\n";
echo "Amenities missing Arabic translation: " . count($missingTranslations) . "\n";
if (count($missingTranslations) > 0) {
    echo "Examples: " . implode(', ', array_slice($missingTranslations, 0, 10)) . "\n";
}

echo "\n--- LISTINGS ANALYSIS ---\n";
$listings = Listing::with(['amenities', 'reviews'])->get();
echo "Total Listings: " . $listings->count() . "\n";

$issues = [];

foreach ($listings as $listing) {
    // Check address and city duplication
    $addressAr = $listing->address_ar;
    $cityAr = $listing->city_ar;
    
    if ($addressAr && $cityAr && str_contains($addressAr, $cityAr)) {
        $issues['duplicated_location'][] = $listing->id . " ({$listing->type}): Address '{$addressAr}', City '{$cityAr}'";
    }

    // Check if Arabic translations are missing
    if (empty($listing->title_ar) || empty($listing->description_ar)) {
        $issues['missing_listing_translations'][] = $listing->id . " ({$listing->type}) is missing title_ar or description_ar";
    }
    
    // Check Reviews logic
    foreach ($listing->reviews as $review) {
        if ($listing->city === 'Cairo' && str_contains($review->comment, 'الساحل')) {
            $issues['bad_reviews_sahel_in_cairo'][] = "Listing {$listing->id} in Cairo has Sahel review: '{$review->comment}'";
        }
    }
}

foreach ($issues as $issueType => $issueList) {
    echo "\nIssue: $issueType (Count: " . count($issueList) . ")\n";
    foreach (array_slice($issueList, 0, 5) as $example) {
        echo " - $example\n";
    }
}

echo "\n--- RAW SAMPLE CAR ---\n";
$car = Listing::where('type', 'car')->first();
if ($car) {
    echo json_encode($car->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";
}

echo "\n--- RAW SAMPLE APARTMENT ---\n";
$apartment = Listing::where('type', 'apartment')->first();
if ($apartment) {
    echo json_encode($apartment->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";
}
