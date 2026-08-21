<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Listing;
use App\Models\User;
use App\Models\Amenity;
use App\Models\Review;
use App\Services\AmenityService;
use Illuminate\Support\Str;

class ScrapeMgZsCommand extends Command
{
    protected $signature = 'scrape:mg-zs';
    protected $description = 'Scrape and insert MG ZS 2020 SUV listing';

    public function handle(AmenityService $amenityService)
    {
        $this->info('Starting MG ZS 2020 listing insertion...');

        $owner = User::where('role', 'customer')->first() ?? User::factory()->create(['role' => 'customer']);

        $listing = Listing::forceCreate([
            'uuid'                      => Str::uuid()->toString(),
            'created_by'                => $owner->id,
            'title'                     => 'MG ZS 2020 – 1.5L COM Crossover SUV',
            'title_ar'                  => 'إم جي ZS 2020 – 1.5 لتر COM كروس أوفر',
            'description'               => "Experience the perfect blend of style, comfort, and practicality with the MG ZS 2020 1.5L COM. This feature-packed crossover SUV is ideal for navigating Cairo's streets or heading out on a weekend escape.\n\nCar Highlights:\n- 2020 Model Year | 1.5L Petrol Engine\n- Automatic Transmission — smooth and effortless drive\n- Seats up to 5 passengers comfortably\n- Full infotainment system with touchscreen and Bluetooth\n- Rear backup camera for easy parking in tight spaces\n- Cruise control for comfortable highway driving\n- Keyless entry & push-button start\n- Located in the 5th Settlement, New Cairo",
            'description_ar'            => "اختبر مزيجاً مثالياً من الأناقة والراحة والعملية مع إم جي ZS موديل 2020 سعة 1.5 لتر. هذا الكروس أوفر المميز مثالي للتنقل في شوارع القاهرة أو للرحلات القصيرة في نهاية الأسبوع.\n\nمميزات السيارة:\n- موديل 2020 | محرك 1.5 لتر بنزين\n- ناقل حركة أوتوماتيك - قيادة سلسة وبدون عناء\n- تتسع لـ 5 ركاب بشكل مريح\n- نظام معلومات ترفيهي كامل بشاشة تعمل باللمس وبلوتوث\n- كاميرا خلفية للركن بسهولة في الأماكن الضيقة\n- مثبت سرعة للقيادة المريحة على الطريق السريع\n- مفتاح ذكي وزر تشغيل\n- موقعها في التجمع الخامس، القاهرة الجديدة",
            'type'                      => 'car',
            'category'                  => 'suv',
            'address'                   => 'التجمع الخامس، القاهرة الجديدة، القاهرة',
            'city'                      => 'New Cairo',
            'country'                   => 'Egypt',
            'latitude'                  => 30.0074,
            'longitude'                 => 31.4913,
            'transmission'              => 'automatic',
            'fuel_type'                 => 'petrol',
            'year'                      => 2020,
            'max_guests'                => 5,
            'base_price_cents'          => 200000,   // 2,000 EGP/day
            'original_base_price_cents' => 250000,   // 2,500 EGP/day (crossed-out)
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

        // ── Images ────────────────────────────────────────────────────────
        // ContactCars doesn't expose direct image URLs via curl (Cloudflare)
        // Using MG ZS 2020 generic high-quality stock images as placeholder
        $listing->media()->createMany([
            [
                'url'        => 'https://upload.wikimedia.org/wikipedia/commons/thumb/2/2e/2020_MG_ZS_%28ZST%29_Excite_Plus_hatchback_%282020-07-23%29_01.jpg/1280px-2020_MG_ZS_%28ZST%29_Excite_Plus_hatchback_%282020-07-23%29_01.jpg',
                'type'       => 'image',
                'order'      => 1,
                'is_primary' => true,
            ],
            [
                'url'        => 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/f6/2020_MG_ZS_%28ZST%29_Excite_Plus_hatchback_%282020-07-23%29_02.jpg/1280px-2020_MG_ZS_%28ZST%29_Excite_Plus_hatchback_%282020-07-23%29_02.jpg',
                'type'       => 'image',
                'order'      => 2,
                'is_primary' => false,
            ],
        ]);

        $this->info('Media attached.');

        // ── Amenities ─────────────────────────────────────────────────────
        $this->info('Processing amenities...');
        $scrapedAmenities = [
            'Air Conditioning', 'Bluetooth', 'Backup Camera',
            'Touchscreen Display', 'Cruise Control', 'Parking Sensors',
            'USB Charging Ports', 'Keyless Entry', 'Push-Button Start',
            'Power Windows', 'Power Mirrors', 'Child Seat Ready',
        ];

        $amenityIds = [];
        foreach ($scrapedAmenities as $amenityName) {
            $amenity = $amenityService->matchOrCreate($amenityName, 'car');
            $amenityIds[] = $amenity->id;
        }

        $listing->amenities()->sync($amenityIds);
        $this->info('Synced ' . count($amenityIds) . ' amenities.');

        // ── Reviews ───────────────────────────────────────────────────────
        $this->info('Generating weighted reviews...');

        $egyptianReviews = [
            ['reviewer_name' => 'خالد محمود', 'rating' => 5, 'comment' => 'السيارة ممتازة والتكييف شغال تمام. القيادة سلسة جداً وراحة عالية. أنصح بيها بجد'],
            ['reviewer_name' => 'مروة السيد', 'rating' => 5, 'comment' => 'مش متوقعة الراحة دي! الأوتوماتيك ممتاز والمقاعد واسعة. هأجرها تاني بالتأكيد'],
            ['reviewer_name' => 'طارق إبراهيم', 'rating' => 4, 'comment' => 'سيارة كويسة وموفرة في البنزين. ليها اتساع مناسب. خدمة ممتازة وتسليم سريع'],
        ];

        $khaleejiReviews = [
            ['reviewer_name' => 'سلطان الزهراني', 'rating' => 5, 'comment' => 'سيارة راقية وتناسب تنقلات القاهرة. كاميرا الخلفية مفيدة جداً. تجربة لائقة'],
            ['reviewer_name' => 'نورة العتيبي', 'rating' => 4, 'comment' => 'استأجرناها لزيارة الأهرام والمتحف. مريحة للجلوس الطويل والتكييف ممتاز'],
        ];

        $foreignReviews = [
            ['reviewer_name' => 'Maria Schmidt', 'rating' => 5, 'comment' => 'Great car for exploring Cairo! Easy to drive in traffic, very comfortable and clean.'],
        ];

        // 50% Egyptian, 30% Khaleeji, 20% Foreign
        $allReviews = [
            ...$egyptianReviews,
            ...$khaleejiReviews,
            ...$foreignReviews,
        ];

        foreach ($allReviews as $r) {
            $review = Review::create([
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
        $this->info('✅ MG ZS 2020 listing created successfully! UUID: ' . $listing->uuid);
    }
}
