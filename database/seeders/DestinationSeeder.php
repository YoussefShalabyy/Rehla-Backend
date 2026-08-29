<?php

namespace Database\Seeders;

use App\Models\Destination;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DestinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $destinations = [
            [
                'uuid'        => (string) Str::uuid(),
                'name'        => 'Sheikh Zayed',
                'name_ar'     => 'الشيخ زايد',
                'country'     => 'Egypt',
                'country_ar'  => 'مصر',
                'subtitle'    => 'Giza Governorate, Egypt',
                'subtitle_ar' => 'محافظة الجيزة، مصر',
                'icon'        => 'business-outline',
                'icon_color'  => '#003d9b',
                'icon_bg'     => 'rgba(0, 61, 155, 0.10)',
                'is_active'   => true,
                'sort_order'  => 10,
            ],
            [
                'uuid'        => (string) Str::uuid(),
                'name'        => 'Dubai',
                'name_ar'     => 'دبي',
                'country'     => 'United Arab Emirates',
                'country_ar'  => 'الإمارات العربية المتحدة',
                'subtitle'    => 'United Arab Emirates',
                'subtitle_ar' => 'الإمارات العربية المتحدة',
                'icon'        => 'sunny-outline',
                'icon_color'  => '#b45309',
                'icon_bg'     => 'rgba(180, 83, 9, 0.10)',
                'is_active'   => true,
                'sort_order'  => 20,
            ],
            [
                'uuid'        => (string) Str::uuid(),
                'name'        => 'Ain Sokhna',
                'name_ar'     => 'العين السخنة',
                'country'     => 'Egypt',
                'country_ar'  => 'مصر',
                'subtitle'    => 'Suez Governorate, Egypt',
                'subtitle_ar' => 'محافظة السويس، مصر',
                'icon'        => 'water-outline',
                'icon_color'  => '#0069a5',
                'icon_bg'     => 'rgba(0, 105, 165, 0.10)',
                'is_active'   => true,
                'sort_order'  => 30,
            ],
            [
                'uuid'        => (string) Str::uuid(),
                'name'        => 'North Coast',
                'name_ar'     => 'الساحل الشمالي',
                'country'     => 'Egypt',
                'country_ar'  => 'مصر',
                'subtitle'    => 'Matrouh Governorate, Egypt',
                'subtitle_ar' => 'محافظة مطروح، مصر',
                'icon'        => 'umbrella-outline',
                'icon_color'  => '#1a7f4b',
                'icon_bg'     => 'rgba(26, 127, 75, 0.10)',
                'is_active'   => true,
                'sort_order'  => 40,
            ],
        ];

        foreach ($destinations as $dest) {
            Destination::updateOrCreate(
                ['name' => $dest['name']], // Unique key for seed
                $dest
            );
        }
    }
}
