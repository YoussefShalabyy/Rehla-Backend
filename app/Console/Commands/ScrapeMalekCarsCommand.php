<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Listing;
use App\Models\User;
use App\Models\Review;
use App\Services\AmenityService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ScrapeMalekCarsCommand extends Command
{
    protected $signature = 'scrape:malekcars-mgzs';
    protected $description = 'Scrape and insert MG ZS 2021 SUV listing from MalekCars';

    public function handle(AmenityService $amenityService)
    {
        $this->info('Starting MalekCars MG ZS 2021 listing insertion...');

        $owner = User::where('role', 'customer')->first() ?? User::factory()->create(['role' => 'customer']);

        DB::transaction(function () use ($owner, $amenityService) {
            $listing = Listing::forceCreate([
                'uuid'                      => Str::uuid()->toString(),
                'created_by'                => $owner->id,
                'title'                     => 'MG ZS 2021 – 1.5L SUV',
                'title_ar'                  => 'ام جي ZS 2021 – 1.5 لتر SUV',
                'description'               => "A pristine 2021 MG ZS crossover SUV, perfect for navigating Cairo or enjoying weekend getaways. Features a smooth automatic transmission, spacious interior for 5, and excellent fuel economy. Includes modern tech like Bluetooth, backup camera, and cruise control.",
                'description_ar'            => "سيارة ام جي ZS موديل 2021 بحالة ممتازة، مثالية للتنقل داخل القاهرة أو لرحلات عطلة نهاية الأسبوع. تتميز بناقل حركة أوتوماتيكي سلس، مقصورة واسعة تتسع لـ 5 أفراد، واقتصاد ممتاز في استهلاك الوقود. مزودة بكاميرا خلفية وشاشة وبلوتوث.",
                'type'                      => 'car',
                'category'                  => 'suv',
                'address'                   => 'المقطم، القاهرة',
                'city'                      => 'Cairo',
                'country'                   => 'Egypt',
                'latitude'                  => 30.0285,
                'longitude'                 => 31.3148,
                'transmission'              => 'automatic',
                'fuel_type'                 => 'petrol',
                'year'                      => 2021,
                'max_guests'                => 5,
                'base_price_cents'          => 200000,   // 2,000 EGP/day
                'original_base_price_cents' => null,     
                'weekly_price_cents'        => 1200000,  // 12,000 EGP/week
                'monthly_price_cents'       => 4500000,  // 45,000 EGP/month
                'cleaning_fee_cents'        => 0,
                'extra_guest_fee_cents'     => 0,
                'bedrooms'                  => null,
                'bathrooms'                 => null,
                'status'                    => 'active',
                'is_instant_bookable'       => true,
            ]);

            $this->info('Listing created: ' . $listing->id);

            // ── Images from MalekCars ─────────────────────────────────────
            $images = [
                'https://malekcars.com/wp-content/uploads/2025/12/o2TxuH8RyqsLC3ROwMJSShjVm5D1qXil5BJCZbbq.jpg',
                'https://malekcars.com/wp-content/uploads/2025/12/mQrH2md7IaAqSPkzWi0JB91ZKE5W3XnJQQpkIO75.jpg',
                'https://malekcars.com/wp-content/uploads/2025/12/Yu8JivoRxkDrJYwut9B01ZfeRS9GvHPN3Wz4zgYy.jpg',
                'https://malekcars.com/wp-content/uploads/2025/12/15BZdcdKYRxLe8bYLqU9kaFOSoLo5sPd8Z8QAw7o.jpg',
                'https://malekcars.com/wp-content/uploads/2025/12/2z2THpV4gknTFmD1991EGggB8BXBpFG4JG994k6I.jpg',
                'https://malekcars.com/wp-content/uploads/2025/12/h2MzqkIi2BatqLqjs5XkC0igNYRTjLXFqUtAYv5K.jpg'
            ];

            $mediaData = [];
            foreach ($images as $index => $url) {
                $mediaData[] = [
                    'url'        => $url,
                    'type'       => 'image',
                    'order'      => $index + 1,
                    'is_primary' => $index === 0,
                ];
            }
            $listing->media()->createMany($mediaData);
            $this->info('Attached ' . count($mediaData) . ' real images.');

            // ── Amenities ──────────────────────────────────────────────────
            $scrapedAmenities = [
                'Air Conditioning', 'Bluetooth', 'Backup Camera',
                'Touchscreen Display', 'Cruise Control', 'Parking Sensors',
                'ABS Brakes', 'USB Charging Ports',
            ];

            $amenityIds = [];
            foreach ($scrapedAmenities as $amenityName) {
                $amenity = $amenityService->matchOrCreate($amenityName, 'car');
                $amenityIds[] = $amenity->id;
            }

            $listing->amenities()->sync($amenityIds);
            $this->info('Synced ' . count($amenityIds) . ' amenities.');

            // ── Reviews ────────────────────────────────────────────────────
            // 50% Egyptian (2), 30% Khaleeji (1), 20% Foreign (1) = 4 reviews total
            $reviews = [
                // Egyptian
                ['reviewer_name' => 'أحمد سعيد', 'rating' => 5, 'comment' => 'عربية ممتازة جدا وسحبها قوي، وتكييفها تلاجة بجد.'],
                ['reviewer_name' => 'محمود عادل', 'rating' => 4, 'comment' => 'استهلاك البنزين معقول جدا، مريحة للسفر العائلي.'],
                // Khaleeji
                ['reviewer_name' => 'فهد الدوسري', 'rating' => 5, 'comment' => 'ما شاء الله الموتر نظيف جداً ومريح في زحمة القاهرة. أنصح بالتعامل.'],
                // Foreign
                ['reviewer_name' => 'Thomas Müller', 'rating' => 5, 'comment' => 'Great experience. The car was very clean and easy to drive in the city.'],
            ];

            foreach ($reviews as $r) {
                Review::create([
                    'uuid'          => Str::uuid()->toString(),
                    'listing_id'    => $listing->id,
                    'reviewer_name' => $r['reviewer_name'],
                    'rating'        => $r['rating'],
                    'comment'       => $r['comment'],
                    'status'        => 'approved',
                ]);
            }

            // Recalculate listing rating
            $stats = Review::where('listing_id', $listing->id)
                ->where('status', 'approved')
                ->selectRaw('COUNT(*) as total, AVG(rating) as average')
                ->first();

            $listing->update([
                'average_rating' => $stats->average ? round((float) $stats->average, 2) : 0.00,
                'total_reviews'  => (int) $stats->total,
            ]);

            $this->info('Reviews generated. Average rating: ' . $listing->fresh()->average_rating);
            $this->info('✅ MG ZS 2021 (MalekCars) listing created successfully! UUID: ' . $listing->uuid);
        });
    }
}
