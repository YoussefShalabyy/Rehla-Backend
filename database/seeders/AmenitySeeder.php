<?php

namespace Database\Seeders;

use App\Models\Amenity;
use Illuminate\Database\Seeder;

class AmenitySeeder extends Seeder
{
    public function run(): void
    {
        // Delete relationships first
        \Illuminate\Support\Facades\DB::table('listing_amenity')->delete();
        \Illuminate\Support\Facades\DB::table('amenities')->delete();

        $amenities = [
            // Property Amenities
            ['name' => 'WiFi', 'name_ar' => 'واي فاي', 'icon' => 'wifi', 'type' => 'property'],
            ['name' => 'Pool', 'name_ar' => 'مسبح', 'icon' => 'pool', 'type' => 'property'],
            ['name' => 'Parking', 'name_ar' => 'موقف سيارات', 'icon' => 'local-parking', 'type' => 'property'],
            ['name' => 'Air Conditioning', 'name_ar' => 'تكييف', 'icon' => 'air-conditioner', 'type' => 'property'],
            ['name' => 'TV', 'name_ar' => 'تلفزيون', 'icon' => 'tv', 'type' => 'property'],
            ['name' => 'Kitchen', 'name_ar' => 'مطبخ', 'icon' => 'kitchen', 'type' => 'property'],
            ['name' => 'Washer', 'name_ar' => 'غسالة', 'icon' => 'washing-machine', 'type' => 'property'],
            
            // Car Amenities
            ['name' => 'Automatic Transmission', 'name_ar' => 'ناقل حركة أوتوماتيك', 'icon' => 'directions-car', 'type' => 'car'],
            ['name' => 'Manual Transmission', 'name_ar' => 'ناقل حركة يدوي', 'icon' => 'settings', 'type' => 'car'],
            ['name' => 'Leather Seats', 'name_ar' => 'مقاعد جلدية', 'icon' => 'airline-seat-recline-normal', 'type' => 'car'],
            ['name' => 'Sunroof / Panoramic', 'name_ar' => 'فتحة سقف / بانوراما', 'icon' => 'wb-sunny', 'type' => 'car'],
            ['name' => 'Apple CarPlay / Android Auto', 'name_ar' => 'آبل كار بلاي / أندرويد أوتو', 'icon' => 'smartphone', 'type' => 'car'],
            ['name' => 'Bluetooth', 'name_ar' => 'بلوتوث', 'icon' => 'bluetooth', 'type' => 'car'],
            ['name' => 'GPS Navigation', 'name_ar' => 'نظام خرائط (GPS)', 'icon' => 'navigation', 'type' => 'car'],
            ['name' => 'Rear Camera', 'name_ar' => 'كاميرا خلفية', 'icon' => 'camera-alt', 'type' => 'car'],
            ['name' => 'Parking Sensors', 'name_ar' => 'حساسات ركن', 'icon' => 'sensors', 'type' => 'car'],
            ['name' => 'Cruise Control', 'name_ar' => 'مثبت سرعة', 'icon' => 'speed', 'type' => 'car'],
        ];

        foreach ($amenities as $amenity) {
            Amenity::create([
                'name' => $amenity['name'],
                'name_ar' => $amenity['name_ar'],
                'icon' => $amenity['icon'],
                'type' => $amenity['type'],
            ]);
        }
    }
}
