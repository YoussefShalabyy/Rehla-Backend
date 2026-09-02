<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Listing;
use App\Models\Amenity;
use App\Models\Review;
use Illuminate\Support\Facades\DB;

class FixBadDataCommand extends Command
{
    protected $signature = 'data:fix-cars-reviews';
    protected $description = 'Deletes all cars, car amenities, and bad Sahel reviews in Cairo.';

    public function handle()
    {
        $this->info('Starting data cleanup...');

        DB::transaction(function () {
            // 1. Delete all bad reviews (Sahel in Cairo)
            $this->info('Cleaning up bad reviews...');
            $badReviewsCount = 0;
            $listings = Listing::with('reviews')->where('city', 'Cairo')->get();
            foreach ($listings as $listing) {
                foreach ($listing->reviews as $review) {
                    if (str_contains($review->comment, 'الساحل')) {
                        $review->forceDelete();
                        $badReviewsCount++;
                    }
                }
            }
            $this->info("Deleted {$badReviewsCount} bad reviews.");

            // 2. Force delete all Cars and their related data
            $this->info('Deleting all car listings...');
            $cars = Listing::where('type', 'car')->get();
            foreach ($cars as $car) {
                // Delete related records manually to ensure complete cleanup
                $car->reviews()->forceDelete();
                $car->amenities()->detach();
                $car->media()->forceDelete();
                $car->forceDelete();
            }
            $this->info("Deleted {$cars->count()} cars.");

            // 3. Delete all car amenities
            $this->info('Deleting all car amenities...');
            $amenitiesDeleted = Amenity::where('type', 'car')->forceDelete();
            $this->info("Deleted {$amenitiesDeleted} car amenities.");
        });

        $this->info('Data cleanup completed successfully!');
    }
}
