<?php

namespace Database\Seeders;

use App\Models\Amenity;
use App\Models\AvailabilityBlock;
use App\Models\Booking;
use App\Models\Destination;
use App\Models\Listing;
use App\Models\Media;
use App\Models\Payment;
use App\Models\Review;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Wishlist;
use App\Enums\UserRole;
use App\Enums\ListingType;
use App\Enums\PropertyType;
use App\Enums\ListingStatus;
use App\Enums\BookingStatus;
use App\Enums\PaymentStatus;
use App\Enums\PaymentGateway;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class HugeIntegrationSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // 1. Create Amenities
        $amenityData = [
            // Property Amenities
            ['name' => 'WiFi', 'icon' => 'wifi'],
            ['name' => 'Pool', 'icon' => 'pool'],
            ['name' => 'Air Conditioning', 'icon' => 'ac_unit'],
            ['name' => 'Kitchen', 'icon' => 'kitchen'],
            ['name' => 'Free Parking', 'icon' => 'local_parking'],
            ['name' => 'TV', 'icon' => 'tv'],
            ['name' => 'Beach Access', 'icon' => 'beach_access'],
            ['name' => 'Gym', 'icon' => 'fitness_center'],
            ['name' => 'Pet Friendly', 'icon' => 'pets'],
            ['name' => 'BBQ Grill', 'icon' => 'outdoor_grill'],
            ['name' => 'Breakfast Included', 'icon' => 'restaurant'],
            ['name' => 'Hot Tub', 'icon' => 'hot_tub'],
            // Car Amenities
            ['name' => 'Automatic Transmission', 'icon' => 'settings'],
            ['name' => 'GPS Navigation', 'icon' => 'navigation'],
            ['name' => 'Bluetooth Audio', 'icon' => 'bluetooth'],
            ['name' => 'Leather Seats', 'icon' => 'airline_seat_recline_extra'],
            ['name' => 'Sunroof', 'icon' => 'wb_sunny'],
            ['name' => 'Backup Camera', 'icon' => 'camera_alt'],
        ];

        $amenityIds = [];
        foreach ($amenityData as $am) {
            $amenity = Amenity::firstOrCreate(['name' => $am['name']], $am);
            $amenityIds[] = $amenity->id;
        }

        // 2. Create Destinations
        $destinationsData = [
            ['name' => 'Cairo', 'subtitle' => 'The City of a Thousand Minarets', 'icon' => 'business-outline', 'icon_color' => '#003d9b', 'icon_bg' => 'rgba(0, 61, 155, 0.10)', 'lat' => 30.0444, 'lng' => 31.2357],
            ['name' => 'Alexandria', 'subtitle' => 'Pearl of the Mediterranean', 'icon' => 'water-outline', 'icon_color' => '#009b8c', 'icon_bg' => 'rgba(0, 155, 140, 0.10)', 'lat' => 31.2001, 'lng' => 29.9187],
            ['name' => 'Sharm El Sheikh', 'subtitle' => 'City of Peace', 'icon' => 'sunny-outline', 'icon_color' => '#e89c0e', 'icon_bg' => 'rgba(232, 156, 14, 0.10)', 'lat' => 27.9158, 'lng' => 34.3299],
            ['name' => 'Hurghada', 'subtitle' => 'Red Sea Riviera', 'icon' => 'boat-outline', 'icon_color' => '#0e9ce8', 'icon_bg' => 'rgba(14, 156, 232, 0.10)', 'lat' => 27.2579, 'lng' => 33.8116],
            ['name' => 'Gouna', 'subtitle' => 'Life as it should be', 'icon' => 'wine-outline', 'icon_color' => '#9b003d', 'icon_bg' => 'rgba(155, 0, 61, 0.10)', 'lat' => 27.3942, 'lng' => 33.6782],
            ['name' => 'North Coast', 'subtitle' => 'Summer Capital', 'icon' => 'umbrella-outline', 'icon_color' => '#009b4d', 'icon_bg' => 'rgba(0, 155, 77, 0.10)', 'lat' => 30.8266, 'lng' => 28.9530],
            ['name' => 'Luxor', 'subtitle' => 'World\'s Greatest Open-Air Museum', 'icon' => 'map-outline', 'icon_color' => '#7a009b', 'icon_bg' => 'rgba(122, 0, 155, 0.10)', 'lat' => 25.6872, 'lng' => 32.6396],
            ['name' => 'Aswan', 'subtitle' => 'Jewel of the Nile', 'icon' => 'image-outline', 'icon_color' => '#9b3d00', 'icon_bg' => 'rgba(155, 61, 0, 0.10)', 'lat' => 24.0889, 'lng' => 32.8998],
        ];

        foreach ($destinationsData as $index => $dest) {
            Destination::firstOrCreate([
                'name' => $dest['name'],
            ], [
                'uuid' => Str::uuid(),
                'subtitle' => $dest['subtitle'],
                'icon' => $dest['icon'],
                'icon_color' => $dest['icon_color'],
                'icon_bg' => $dest['icon_bg'],
                'is_active' => true,
                'sort_order' => $index,
            ]);
        }

        // 3. Create Users
        $admins = [];
        for ($i = 1; $i <= 15; $i++) {
            $user = User::create([
                'uuid'     => Str::uuid(),
                'name'     => "Host {$faker->firstName}",
                'email'    => "host{$i}@example.com",
                'password' => bcrypt('password'),
                'phone'    => "+20110" . $faker->randomNumber(6, true),
                'role'     => UserRole::Admin,
                'avatar_url' => "https://i.pravatar.cc/150?u=host{$i}",
            ]);
            Wallet::create(['uuid' => Str::uuid(), 'user_id' => $user->id, 'balance_cents' => 0]);
            $admins[] = $user;
        }

        $customers = [];
        for ($i = 1; $i <= 50; $i++) {
            $user = User::create([
                'uuid'     => Str::uuid(),
                'name'     => "Customer {$faker->firstName}",
                'email'    => "customer{$i}@example.com",
                'password' => bcrypt('password'),
                'phone'    => "+20120" . $faker->randomNumber(6, true),
                'role'     => UserRole::Customer,
                'avatar_url' => "https://i.pravatar.cc/150?u=customer{$i}",
            ]);
            Wallet::create(['uuid' => Str::uuid(), 'user_id' => $user->id, 'balance_cents' => random_int(10000, 1000000)]);
            $customers[] = $user;
        }

        // Image Pools
        $villaImages = [
            'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=800&q=80',
            'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=800&q=80',
            'https://images.unsplash.com/photo-1613977257363-707ba9348227?w=800&q=80',
            'https://images.unsplash.com/photo-1580587771525-78b9dba3b914?w=800&q=80',
            'https://images.unsplash.com/photo-1600607686527-6fb886090705?w=800&q=80',
            'https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3?w=800&q=80',
            'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?w=800&q=80',
            'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=800&q=80',
        ];

        $aptImages = [
            'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=800&q=80',
            'https://images.unsplash.com/photo-1502672260266-1c15a8223041?w=800&q=80',
            'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?w=800&q=80',
            'https://images.unsplash.com/photo-1513694203232-719a280e022f?w=800&q=80',
            'https://images.unsplash.com/photo-1493809842364-78817add7ffb?w=800&q=80',
            'https://images.unsplash.com/photo-1502005229762-cf1b2da7c5d6?w=800&q=80',
            'https://images.unsplash.com/photo-1560448205-4d9b3e6bb6db?w=800&q=80',
        ];

        $hotelImages = [
            'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=800&q=80',
            'https://images.unsplash.com/photo-1551882547-ff40c0d5b5df?w=800&q=80',
            'https://images.unsplash.com/photo-1445019980597-93fa8acb246c?w=800&q=80',
            'https://images.unsplash.com/photo-1582719508461-905c673771fd?w=800&q=80',
            'https://images.unsplash.com/photo-1571501443893-0c3188d6b177?w=800&q=80',
            'https://images.unsplash.com/photo-1542314831-c6a4d1424b9c?w=800&q=80',
            'https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=800&q=80',
        ];

        $luxuryCars = [
            'https://images.unsplash.com/photo-1563720223185-11003d516935?w=800&q=80',
            'https://images.unsplash.com/photo-1609521263047-f8f205293f24?w=800&q=80',
            'https://images.unsplash.com/photo-1555626906-fcf10d6851b4?w=800&q=80',
            'https://images.unsplash.com/photo-1583121274602-3e2820c69888?w=800&q=80',
            'https://images.unsplash.com/photo-1614200187524-dc4b892acf16?w=800&q=80',
            'https://images.unsplash.com/photo-1592198084033-aade902d1aae?w=800&q=80',
            'https://images.unsplash.com/photo-1503376710356-70e68c857732?w=800&q=80',
        ];

        $normalCars = [
            'https://images.unsplash.com/photo-1541899481282-d53bffe3c35d?w=800&q=80',
            'https://images.unsplash.com/photo-1590362891991-f700075c1973?w=800&q=80',
            'https://images.unsplash.com/photo-1605810731427-da28892d1921?w=800&q=80',
            'https://images.unsplash.com/photo-1550130635-c3cbf4c1eb16?w=800&q=80',
            'https://images.unsplash.com/photo-1519641471654-76ce0107ad1b?w=800&q=80',
            'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?w=800&q=80',
            'https://images.unsplash.com/photo-1568605117036-5fe5e7bab0b7?w=800&q=80',
        ];

        $propertyPrefixes = ['Beautiful', 'Stunning', 'Luxury', 'Cozy', 'Modern', 'Spacious', 'Oceanview', 'Downtown'];
        $carNames = ['Mercedes S-Class', 'BMW X5', 'Range Rover Sport', 'Toyota Corolla', 'Hyundai Tucson', 'Porsche 911', 'Nissan Sunny', 'Kia Sportage'];

        $listings = [];
        $totalListings = 100;

        for ($i = 0; $i < $totalListings; $i++) {
            $admin = $admins[array_rand($admins)];
            $dest = $destinationsData[array_rand($destinationsData)];
            
            $isCar = $faker->boolean(30); // 30% cars, 70% properties
            
            $type = $isCar ? ListingType::Car : ListingType::Property;
            $propType = null;
            $carCat = null;
            $images = [];
            $title = '';

            if ($isCar) {
                $carCat = $faker->randomElement(['luxury', 'economy', 'sports', 'family']);
                $title = $faker->randomElement($carNames) . ' ' . $faker->year;
                $pool = in_array($carCat, ['luxury', 'sports']) ? $luxuryCars : $normalCars;
                $images = $faker->randomElements($pool, random_int(3, 5));
            } else {
                $propType = $faker->randomElement([PropertyType::Villa, PropertyType::Apartment, PropertyType::Hotel, PropertyType::Room]);
                $title = $faker->randomElement($propertyPrefixes) . ' ' . ucfirst(strtolower($propType->value)) . ' in ' . $dest['name'];
                
                if ($propType === PropertyType::Villa) {
                    $images = $faker->randomElements($villaImages, random_int(3, 5));
                } elseif ($propType === PropertyType::Apartment) {
                    $images = $faker->randomElements($aptImages, random_int(3, 5));
                } else {
                    $images = $faker->randomElements($hotelImages, random_int(3, 5));
                }
            }

            // Scatter lat/lng slightly around destination
            $lat = $dest['lat'] + (lcg_value() - 0.5) / 10;
            $lng = $dest['lng'] + (lcg_value() - 0.5) / 10;

            $listing = Listing::create([
                'uuid'                  => Str::uuid(),
                'created_by'            => $admin->id,
                'title'                 => $title,
                'description'           => $faker->paragraph(random_int(3, 6)),
                'type'                  => $type,
                'property_type'         => $propType,
                'category'              => $carCat,
                'status'                => $faker->randomElement([ListingStatus::Active, ListingStatus::Active, ListingStatus::Active, ListingStatus::Hidden, ListingStatus::Disabled, ListingStatus::Archived]),
                'base_price_cents'      => random_int(3000, 120000), // 30 EGP to 1200 EGP per night/day
                'cleaning_fee_cents'    => $isCar ? 0 : random_int(1000, 10000),
                'extra_guest_fee_cents' => $isCar ? 0 : random_int(500, 2500),
                'max_guests'            => $isCar ? random_int(2, 7) : random_int(1, 12),
                'country'               => 'Egypt',
                'city'                  => $dest['name'],
                'address'               => $faker->streetAddress,
                'latitude'              => $lat,
                'longitude'             => $lng,
                'is_instant_bookable'   => $faker->boolean(80),
            ]);

            // Attach 3-6 random amenities
            $randomKeys = (array) array_rand($amenityIds, random_int(3, 6));
            $selectedAmenities = [];
            foreach ($randomKeys as $rk) {
                $selectedAmenities[] = $amenityIds[$rk];
            }
            $listing->amenities()->attach($selectedAmenities);

            // Attach media
            foreach ($images as $index => $imgUrl) {
                Media::create([
                    'uuid'        => Str::uuid(),
                    'entity_type' => 'listing',
                    'entity_id'   => $listing->id,
                    'type'        => 'image',
                    'url'         => $imgUrl,
                    'public_id'   => 'seeded/' . $listing->uuid . '/' . $index,
                    'provider'    => 'local',
                    'is_primary'  => $index === 0,
                    'order'       => $index,
                ]);
            }

            // Create Availability Blocks (Unavailability)
            $blocksCount = random_int(0, 3);
            for ($b = 0; $b < $blocksCount; $b++) {
                $start = now()->addDays(random_int(1, 60));
                AvailabilityBlock::create([
                    'listing_id' => $listing->id,
                    'start_date' => $start->format('Y-m-d'),
                    'end_date' => $start->addDays(random_int(1, 5))->format('Y-m-d'),
                    'reason' => 'host_blocked'
                ]);
            }

            $listings[] = $listing;
        }

        // 4. Create Bookings, Payments, Reviews
        $bookingStatuses = [BookingStatus::Completed, BookingStatus::Confirmed, BookingStatus::Pending, BookingStatus::Cancelled];
        
        foreach ($listings as $listing) {
            $bookingCount = random_int(3, 8);
            for ($b = 0; $b < $bookingCount; $b++) {
                $customer = $customers[array_rand($customers)];
                
                // Past or Future booking
                $isPast = $faker->boolean(60); 
                
                if ($isPast) {
                    $checkInDate = now()->subDays(random_int(5, 90));
                    $status = $faker->randomElement([BookingStatus::Completed, BookingStatus::Cancelled]);
                } else {
                    $checkInDate = now()->addDays(random_int(5, 60));
                    $status = $faker->randomElement([BookingStatus::Confirmed, BookingStatus::Pending]);
                }
                
                $checkOutDate = (clone $checkInDate)->addDays(random_int(1, 10));
                $nights = $checkInDate->diffInDays($checkOutDate);
                $total = $listing->base_price_cents * $nights + $listing->cleaning_fee_cents;
                $platFee = (int) round($total * 0.10);

                $booking = Booking::create([
                    'uuid'               => Str::uuid(),
                    'booking_reference'  => 'SEED-' . strtoupper(Str::random(8)),
                    'listing_id'         => $listing->id,
                    'customer_id'        => $customer->id,
                    'check_in_date'      => $checkInDate->format('Y-m-d'),
                    'check_out_date'     => $checkOutDate->format('Y-m-d'),
                    'guests_count'       => random_int(1, min($listing->max_guests, 4)),
                    'total_amount_cents' => $total,
                    'platform_fee_cents' => $platFee,
                    'status'             => $status,
                    'payment_status'     => in_array($status, [BookingStatus::Completed, BookingStatus::Confirmed]) ? PaymentStatus::Paid : PaymentStatus::Pending,
                    'pricing_snapshot'   => json_encode([
                        'nights'                => $nights,
                        'base_total_cents'      => $listing->base_price_cents * $nights,
                        'cleaning_fee_cents'    => $listing->cleaning_fee_cents,
                        'extra_guest_fee_cents' => 0,
                        'platform_fee_cents'    => $platFee,
                        'grand_total_cents'     => $total,
                    ]),
                ]);

                // Create payment
                if (in_array($status, [BookingStatus::Completed, BookingStatus::Confirmed])) {
                    Payment::create([
                        'uuid'                   => Str::uuid(),
                        'booking_id'             => $booking->id,
                        'amount_cents'           => $total,
                        'gateway'                => PaymentGateway::Paymob,
                        'status'                 => PaymentStatus::Paid,
                        'gateway_transaction_id' => 'SEED_' . strtoupper(Str::random(10)),
                        'provider_response'      => ['seeded' => true],
                    ]);

                    // Generate a notification for the customer
                    DB::table('notifications')->insert([
                        'id' => Str::uuid(),
                        'type' => 'App\Notifications\BookingConfirmed',
                        'notifiable_type' => User::class,
                        'notifiable_id' => $customer->id,
                        'data' => json_encode(['message' => "Your booking for {$listing->title} is confirmed!"]),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                // Add a review for completed bookings
                if ($status === BookingStatus::Completed && $faker->boolean(70)) {
                    $rating = $faker->randomElement([4, 4, 5, 5, 5, 3]); // mostly good ratings
                    Review::create([
                        'uuid'        => Str::uuid(),
                        'booking_id'  => $booking->id,
                        'reviewer_id' => $customer->id,
                        'listing_id'  => $listing->id,
                        'rating'      => $rating,
                        'comment'     => $faker->sentence(random_int(4, 10)),
                        'status'      => $faker->randomElement([\App\Enums\ReviewStatus::Approved, \App\Enums\ReviewStatus::Approved, \App\Enums\ReviewStatus::Pending, \App\Enums\ReviewStatus::Hidden]),
                    ]);
                }
            }
        }

        // 5. Populate Wishlists
        foreach ($customers as $customer) {
            $wishlistCount = random_int(3, 10);
            $randomListings = $faker->randomElements($listings, $wishlistCount);
            foreach ($randomListings as $randList) {
                Wishlist::firstOrCreate([
                    'user_id' => $customer->id,
                    'listing_id' => $randList->id,
                ]);
            }
            
            // Random general notifications
            for ($n = 0; $n < random_int(1, 3); $n++) {
                DB::table('notifications')->insert([
                    'id' => Str::uuid(),
                    'type' => 'App\Notifications\GeneralNotification',
                    'notifiable_type' => User::class,
                    'notifiable_id' => $customer->id,
                    'data' => json_encode(['message' => "Check out our new listings in Gouna!"]),
                    'created_at' => now()->subDays(random_int(1, 10)),
                    'updated_at' => now(),
                ]);
            }
        }

        // 6. Recalculate average ratings
        foreach ($listings as $listing) {
            $stats = Review::where('listing_id', $listing->id)
                ->where('status', \App\Enums\ReviewStatus::Approved)
                ->selectRaw('COUNT(*) as total, AVG(rating) as average')
                ->first();

            if ($stats && $stats->total > 0) {
                $listing->update([
                    'average_rating' => round((float) $stats->average, 2),
                    'total_reviews'  => (int) $stats->total,
                ]);
            }
        }
    }
}
