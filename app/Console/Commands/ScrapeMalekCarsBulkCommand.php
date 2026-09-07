<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Listing;
use App\Models\User;
use App\Models\Amenity;
use App\Services\AmenityService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ScrapeMalekCarsBulkCommand extends Command
{
    protected $signature = 'scrape:cars';
    protected $description = 'Scrape and insert bulk cars from array';

    public function handle(AmenityService $amenityService)
    {
        $this->info('Starting bulk car insertion...');

        // Pre-seed all car amenities with Arabic translations and icons
        $carAmenities = [
            ['name' => 'Air Conditioning', 'name_ar' => 'تكييف هواء', 'icon' => 'ac_unit'],
            ['name' => 'Bluetooth', 'name_ar' => 'بلوتوث', 'icon' => 'bluetooth'],
            ['name' => 'Rear Camera', 'name_ar' => 'كاميرا خلفية', 'icon' => 'camera_rear'],
            ['name' => 'Cruise Control', 'name_ar' => 'مثبت سرعة', 'icon' => 'speed'],
            ['name' => 'Leather Seats', 'name_ar' => 'مقاعد جلدية', 'icon' => 'airline_seat_recline_extra'],
            ['name' => 'GPS Navigation', 'name_ar' => 'نظام خرائط (GPS)', 'icon' => 'explore'],
            ['name' => 'Parking Sensors', 'name_ar' => 'حساسات ركن', 'icon' => 'sensors'],
            ['name' => 'USB Charging Ports', 'name_ar' => 'منافذ شحن USB', 'icon' => 'usb'],
            ['name' => 'Touchscreen Display', 'name_ar' => 'شاشة لمس', 'icon' => 'touch_app'],
            ['name' => 'ABS Brakes', 'name_ar' => 'فرامل ABS', 'icon' => 'car_crash'],
        ];

        foreach ($carAmenities as $am) {
            Amenity::updateOrCreate(
                ['name' => $am['name'], 'type' => 'car'],
                ['name_ar' => $am['name_ar'], 'icon' => $am['icon']]
            );
        }

        $owner = User::where('role', 'customer')->first() ?? User::factory()->create(['role' => 'customer']);

        $listingsData = [
            [
                'title' => 'Volkswagen Tiguan 2025',
                'title_ar' => 'فولكس فاجن تيجوان 2025',
                'description' => 'A well-maintained Volkswagen Tiguan 2025, offering great performance and comfort for city driving or long trips. Enjoy a premium driving experience.',
                'description_ar' => 'سيارة فولكس فاجن تيجوان 2025 بحالة ممتازة، تقدم أداء رائع وراحة في القيادة داخل المدينة أو في الرحلات الطويلة. استمتع بتجربة قيادة متميزة.',
                'type' => 'car',
                'category' => 'daily',
                'address' => 'Nasr City',
                'address_ar' => 'مدينة نصر',
                'city' => 'Cairo',
                'city_ar' => 'القاهرة',
                'country' => 'Egypt',
                'country_ar' => 'مصر',
                'latitude' => 30.08916614969993,
                'longitude' => 31.211754120525658,
                'transmission' => 'automatic',
                'fuel_type' => 'petrol',
                'max_guests' => 5,
                'base_price_cents' => 237500,
                'monthly_price_cents' => 7125000,
                'status' => 'active',
                'images' => [
                    'https://malekcars.com/wp-content/uploads/2026/08/23B2fmRDdZS3EVw3RxTvRNoBgV3SOJI9tkbmsDrH.jpg',
                    'https://malekcars.com/wp-content/uploads/2026/08/yrT4mlDjVEI1NUHWCRQ2mrqUzOtVeXKA52oP6y1m.jpg',
                    'https://malekcars.com/wp-content/uploads/2026/08/0lWef17r8nienfjhnZxhlTQ8f9j2orZ22c2Sq5oy.jpg',
                    'https://malekcars.com/wp-content/uploads/2026/08/M9ceEvdTZnZ52l8hNembIFP7mNSYklRtXKhz4KTB.jpg',
                    'https://malekcars.com/wp-content/uploads/2026/08/NsFKJycJau9vOF0doKPwg5uD0m0rbn6R14fT1geW.jpg',
                    'https://malekcars.com/wp-content/uploads/2026/08/lXBzW3MEVL1tMhmV1s3aK4bVeIK6Q9OTOOTEBgCG.jpg'
                ],
                'amenities' => [
                    'Bluetooth',
                    'Touchscreen Display',
                    'GPS Navigation',
                    'Parking Sensors',
                    'Rear Camera'
                ]
            ],
            [
                'title' => 'Land Rover Discovery Sport 2020',
                'title_ar' => 'لاند روفر ديسكفري سبورت 2020',
                'description' => 'A well-maintained Land Rover Discovery Sport 2020, offering great performance and comfort for city driving or long trips. Enjoy a premium driving experience.',
                'description_ar' => 'سيارة لاند روفر ديسكفري سبورت 2020 بحالة ممتازة، تقدم أداء رائع وراحة في القيادة داخل المدينة أو في الرحلات الطويلة. استمتع بتجربة قيادة متميزة.',
                'type' => 'car',
                'category' => 'luxury',
                'address' => '5th Settlement',
                'address_ar' => 'التجمع الخامس',
                'city' => 'Cairo',
                'city_ar' => 'القاهرة',
                'country' => 'Egypt',
                'country_ar' => 'مصر',
                'latitude' => 30.081066699742557,
                'longitude' => 31.26879050100209,
                'transmission' => 'automatic',
                'fuel_type' => 'petrol',
                'max_guests' => 5,
                'base_price_cents' => 270000,
                'monthly_price_cents' => 8100000,
                'status' => 'active',
                'images' => [
                    'https://malekcars.com/wp-content/uploads/2026/08/Y6Qc1yikhO38OKod81ArsKwyVAyUWEh6svAxbpbr.jpg',
                    'https://malekcars.com/wp-content/uploads/2026/08/UpjEKTPKG7NXyPiqf0KT2vUQfXYNmkFDCi53FAzE.jpg',
                    'https://malekcars.com/wp-content/uploads/2026/08/ebSXi6tAKaSWQL71fEbze8GDTZEdZ4RaSiA6MIlU.jpg',
                    'https://malekcars.com/wp-content/uploads/2026/08/htC5BccBUFSj2tHQoPpkjUjg1QhPJ6xcYbwlVfLH.jpg',
                    'https://malekcars.com/wp-content/uploads/2026/08/HIOGNo6Iv1j1cZXSY739aExX6AFWixOwUL2MzDCn.jpg',
                    'https://malekcars.com/wp-content/uploads/2026/08/1h6FLupIWBbabLRWHebZHNRBDbPshAebZILWg1El.jpg',
                    'https://malekcars.com/wp-content/uploads/2026/08/ETsTcKQyX4K06OifhHll09UHTzeSK1FcIlDoVhRH.jpg',
                    'https://malekcars.com/wp-content/uploads/2026/08/cKHA4XyQAEy01fGiBAtqvcE5TBmRtbWjMYI8AO28.jpg'
                ],
                'amenities' => [
                    'GPS Navigation',
                    'Parking Sensors',
                    'Rear Camera',
                    'USB Charging Ports',
                    'Air Conditioning'
                ]
            ],
            [
                'title' => 'Mercedes-Benz 200 2022',
                'title_ar' => 'مرسيدس 200 2022',
                'description' => 'A well-maintained Mercedes-Benz 200 2022, offering great performance and comfort for city driving or long trips. Enjoy a premium driving experience.',
                'description_ar' => 'سيارة مرسيدس 200 2022 بحالة ممتازة، تقدم أداء رائع وراحة في القيادة داخل المدينة أو في الرحلات الطويلة. استمتع بتجربة قيادة متميزة.',
                'type' => 'car',
                'category' => 'luxury',
                'address' => 'Maadi',
                'address_ar' => 'المعادي',
                'city' => 'Cairo',
                'city_ar' => 'القاهرة',
                'country' => 'Egypt',
                'country_ar' => 'مصر',
                'latitude' => 30.081633698087337,
                'longitude' => 31.2362543675728,
                'transmission' => 'automatic',
                'fuel_type' => 'petrol',
                'max_guests' => 5,
                'base_price_cents' => 287500,
                'monthly_price_cents' => 8625000,
                'status' => 'active',
                'images' => [
                    'https://malekcars.com/wp-content/uploads/2025/12/dogjSaTGTDXUjleyePVn9EpP86PXRvlkwjG079fW.jpg',
                    'https://malekcars.com/wp-content/uploads/2025/12/PL0XhFupN8bb38jadPifV1xNOQS8DRmBqt1pxrro.jpg',
                    'https://malekcars.com/wp-content/uploads/2025/12/eFOeMkX2O5Pp3dOiMo1Y9lFKCwz0hlIi4FKGhfUv.jpg',
                    'https://malekcars.com/wp-content/uploads/2025/12/84MzMLSzROTpfjYs5r9XPeIC4jQf289GmsPsL0vA.jpg',
                    'https://malekcars.com/wp-content/uploads/2025/12/gLFK7UGHu4HpOAEIB3eErAmMhJsoSZpewoXsPAUN.jpg',
                    'https://malekcars.com/wp-content/uploads/2025/12/iEoqqNYknAWt0r1OKQO499iMDKFFK8mRapcc5mBd.jpg',
                    'https://malekcars.com/wp-content/uploads/2025/12/mTLvjhLbJfFpPTMqF9CtRgLWUmwDOTIZwZXMqg3c.jpg',
                    'https://malekcars.com/wp-content/uploads/2025/12/pZobbEUW13CZ4UpE5AvsQpuPUV731bx45gOPQ2F3.jpg'
                ],
                'amenities' => [
                    'USB Charging Ports',
                    'Leather Seats',
                    'Cruise Control',
                    'GPS Navigation',
                    'Bluetooth',
                    'Rear Camera'
                ]
            ],
            [
                'title' => 'BMW iX 2023',
                'title_ar' => 'بي ام دبليو اى اكس 2023',
                'description' => 'A well-maintained BMW iX 2023, offering great performance and comfort for city driving or long trips. Enjoy a premium driving experience.',
                'description_ar' => 'سيارة بي ام دبليو اى اكس 2023 بحالة ممتازة، تقدم أداء رائع وراحة في القيادة داخل المدينة أو في الرحلات الطويلة. استمتع بتجربة قيادة متميزة.',
                'type' => 'car',
                'category' => 'luxury',
                'address' => 'Mohandeseen',
                'address_ar' => 'المهندسين',
                'city' => 'Cairo',
                'city_ar' => 'القاهرة',
                'country' => 'Egypt',
                'country_ar' => 'مصر',
                'latitude' => 30.01632309560301,
                'longitude' => 31.264543689563716,
                'transmission' => 'automatic',
                'fuel_type' => 'petrol',
                'max_guests' => 5,
                'base_price_cents' => 550000,
                'monthly_price_cents' => 16500000,
                'status' => 'active',
                'images' => [
                    ''
                ],
                'amenities' => [
                    'Bluetooth',
                    'GPS Navigation',
                    'Touchscreen Display',
                    'Cruise Control'
                ]
            ],
            [
                'title' => 'Toyota Land Cruiser 2023',
                'title_ar' => 'تويوتا لاند كروزر 2023',
                'description' => 'A well-maintained Toyota Land Cruiser 2023, offering great performance and comfort for city driving or long trips. Enjoy a premium driving experience.',
                'description_ar' => 'سيارة تويوتا لاند كروزر 2023 بحالة ممتازة، تقدم أداء رائع وراحة في القيادة داخل المدينة أو في الرحلات الطويلة. استمتع بتجربة قيادة متميزة.',
                'type' => 'car',
                'category' => 'daily',
                'address' => 'Heliopolis',
                'address_ar' => 'مصر الجديدة',
                'city' => 'Cairo',
                'city_ar' => 'القاهرة',
                'country' => 'Egypt',
                'country_ar' => 'مصر',
                'latitude' => 30.04508360918137,
                'longitude' => 31.214219726518667,
                'transmission' => 'automatic',
                'fuel_type' => 'petrol',
                'max_guests' => 5,
                'base_price_cents' => 660000,
                'monthly_price_cents' => 19800000,
                'status' => 'active',
                'images' => [
                    'https://malekcars.com/wp-content/uploads/2025/05/5934009683708855100.jpg',
                    'https://malekcars.com/wp-content/uploads/2025/05/5934009683708855094.jpg',
                    'https://malekcars.com/wp-content/uploads/2025/05/5934009683708855097.jpg',
                    'https://malekcars.com/wp-content/uploads/2025/05/5934009683708855095.jpg',
                    'https://malekcars.com/wp-content/uploads/2025/05/5934009683708855099.jpg',
                    'https://malekcars.com/wp-content/uploads/2025/05/5934009683708855096.jpg',
                    'https://malekcars.com/wp-content/uploads/2025/05/5934009683708855098.jpg'
                ],
                'amenities' => [
                    'Touchscreen Display',
                    'GPS Navigation',
                    'Air Conditioning',
                    'Parking Sensors',
                    'Cruise Control'
                ]
            ],
        ];

        foreach ($listingsData as $data) {
            $this->info("Creating listing: {$data['title']}");

            DB::transaction(function () use ($owner, $data, $amenityService) {
                $listing = Listing::forceCreate([
                    'uuid' => Str::uuid()->toString(),
                    'created_by' => $owner->id,
                    'title' => $data['title'],
                    'title_ar' => $data['title_ar'],
                    'description' => $data['description'],
                    'description_ar' => $data['description_ar'],
                    'type' => $data['type'],
                    'category' => $data['category'],
                    'address' => $data['address'],
                    'address_ar' => $data['address_ar'] ?? null,
                    'city' => $data['city'],
                    'city_ar' => $data['city_ar'] ?? null,
                    'country' => $data['country'],
                    'country_ar' => $data['country_ar'] ?? null,
                    'latitude' => $data['latitude'],
                    'longitude' => $data['longitude'],
                    'transmission' => $data['transmission'],
                    'fuel_type' => $data['fuel_type'],
                    'base_price_cents' => $data['base_price_cents'],
                    'monthly_price_cents' => $data['monthly_price_cents'],
                    'status' => $data['status'],
                    'max_guests' => $data['max_guests'],
                ]);

                $this->info("Attaching images...");
                
                $mediaData = [];
                foreach ($data['images'] as $index => $imageUrl) {
                    if (empty($imageUrl)) continue;
                    $mediaData[] = [
                        'url' => $imageUrl,
                        'type' => 'image',
                        'order' => $index + 1,
                        'is_primary' => $index === 0,
                    ];
                }
                $listing->media()->createMany($mediaData);

                // Amenities
                $amenityIds = [];
                foreach ($data['amenities'] as $amenityName) {
                    $amenity = $amenityService->matchOrCreate($amenityName, 'car');
                    $amenityIds[] = $amenity->id;
                }
                $listing->amenities()->sync($amenityIds);

                // Car specific fake reviews
                $egyptianNames = ['أحمد مجدي', 'عمر كمال', 'يوسف طارق', 'محمود عادل', 'حازم إمام', 'مصطفى حسين', 'كريم فهمي', 'رامي صبري', 'عمرو دياب', 'تامر حسني'];
                $khaleejiNames = ['فهد الدوسري', 'عبدالله المطيري', 'سلطان القحطاني', 'خالد السبيعي', 'فيصل الشمري', 'سعود العتيبي', 'محمد الرشيدي', 'نواف العنزي', 'تركي اليامي'];
                $foreignNames = ['John Smith', 'Michael Johnson', 'David Williams', 'James Brown', 'Robert Jones', 'William Miller', 'Thomas Davis', 'Daniel Garcia', 'Paul Martinez'];

                $egyptianComments = [
                    'العربية ممتازة جدا وسحبها قوي ومريحة في السواقة.',
                    'تكييفها تلاجة بجد، ومناسبة جدا لزحمة القاهرة.',
                    'استهلاك البنزين معقول جدا، مريحة للسفر العائلي.',
                    'حالتها ممتازة واستلمتها نضيفة جدا من جوه ومن بره.',
                    'أداء العربية كان رائع على الطريق السريع.',
                    'تجربة مريحة جدا، العربية واسعة والمقاعد مريحة.',
                    'صوت الموتور هادي ومفيش أي مشاكل واجهتني.',
                    'سهلة جدا في الركنة، وفرملتها قوية.',
                    'العربية شيك جدا وتنفع للمشاوير المهمة.',
                    'أحسن عربية أجرتها من فترة طويلة، حالة الموتور ممتازة.'
                ];

                $khaleejiComments = [
                    'ما شاء الله الموتر نظيف جداً ومريح في زحمة القاهرة. أنصح بالتعامل.',
                    'السيارة جداً مريحة وتصلح للعوائل الخليجية.',
                    'أداء ممتاز ومكيف يبرد من قلب.',
                    'استأجرتها لمدة أسبوع وكانت تجربة مميزة جداً.',
                    'نظافة السيارة واهتمام المالك شيء يشكر عليه.',
                    'أنصح فيها بقوة، صرفية البنزين ممتازة.',
                    'السيارة فخمة جداً والمقاعد مريحة لمسافات طويلة.',
                    'وايد حلوة وعملية في استخدامها اليومي.',
                    'سواقتها سلسة ومافيها أي مشاكل تقنية.',
                    'يعطيكم العافية، الموتر بحالة الوكالة.'
                ];

                $foreignComments = [
                    'Great experience. The car was very clean and easy to drive in the city.',
                    'The ride was smooth and fuel economy was excellent.',
                    'Perfect car for getting around Cairo, highly recommend.',
                    'The vehicle was in pristine condition, just like new.',
                    'Air conditioning worked perfectly during the hot days.',
                    'Very spacious interior and comfortable seats for long trips.',
                    'The transmission is very smooth, no issues at all.',
                    'Excellent choice for a business trip, very professional vehicle.',
                    'Loved driving this car, it felt very safe and reliable.',
                    'Five stars. Will definitely rent this exact car again.'
                ];

                shuffle($egyptianNames);
                shuffle($egyptianComments);
                shuffle($khaleejiNames);
                shuffle($khaleejiComments);
                shuffle($foreignNames);
                shuffle($foreignComments);

                $numReviews = rand(3, 7);
                $totalRating = 0;

                for ($j = 0; $j < $numReviews; $j++) {
                    $rating = rand(4, 5);
                    $totalRating += $rating;
                    
                    $randVal = rand(1, 100);
                    if ($randVal <= 40) {
                        $name = array_pop($egyptianNames);
                        $comment = array_pop($egyptianComments);
                    } elseif ($randVal <= 70) {
                        $name = array_pop($khaleejiNames);
                        $comment = array_pop($khaleejiComments);
                    } else {
                        $name = array_pop($foreignNames);
                        $comment = array_pop($foreignComments);
                    }
                    
                    \App\Models\Review::create([
                        'uuid' => Str::uuid()->toString(),
                        'listing_id' => $listing->id,
                        'reviewer_name' => $name,
                        'rating' => $rating,
                        'comment' => $comment,
                        'status' => 'approved',
                        'booking_id' => null,
                        'reviewer_id' => null,
                    ]);
                }

                $averageRating = round($totalRating / $numReviews, 2);
                
                $listing->update([
                    'total_reviews' => $numReviews,
                    'average_rating' => $averageRating
                ]);

                $this->info("--- Completed {$data['title']} ---");
            });
        }
        
        $this->info("Done all cars.");
    }
}
