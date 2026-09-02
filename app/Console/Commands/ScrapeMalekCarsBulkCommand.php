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
                'title' => 'Nissan صني 2022',
                'title_ar' => 'نيسان صني 2022',
                'description' => 'A well-maintained Nissan صني 2022, offering great performance and comfort for city driving or long trips. Enjoy a premium driving experience.',
                'description_ar' => 'سيارة نيسان صني 2022 بحالة ممتازة، تقدم أداء رائع وراحة في القيادة داخل المدينة أو في الرحلات الطويلة. استمتع بتجربة قيادة متميزة.',
                'type' => 'car',
                'category' => 'daily',
                'address' => 'Maadi',
                'address_ar' => 'المعادي',
                'city' => 'Cairo',
                'city_ar' => 'القاهرة',
                'country' => 'Egypt',
                'country_ar' => 'مصر',
                'latitude' => 30.061187769599893,
                'longitude' => 31.22860426638036,
                'transmission' => 'automatic',
                'fuel_type' => 'petrol',
                'max_guests' => 5,
                'base_price_cents' => 68000,
                'monthly_price_cents' => 2040000,
                'status' => 'active',
                'images' => [
                    'https://malekcars.com/wp-content/uploads/2026/08/fzFxFGAcz3vqaBA1m694xjytkTyhtqgQljEvLyZB.jpg',
                    'https://malekcars.com/wp-content/uploads/2026/08/QPYtGS2HofnjU2n9SNsqOtRJL7Csr6YNJhcPaHUN.jpg',
                    'https://malekcars.com/wp-content/uploads/2026/08/FwqP4xW1tJ6pmumPs9JEx7h6yxbA5GWS6whBpci9.jpg',
                    'https://malekcars.com/wp-content/uploads/2026/08/QdTlp5TZKU4aqkK5BU8U8w5MM8PLrTiiprrgP050.jpg',
                    'https://malekcars.com/wp-content/uploads/2026/08/efJyFQhAxSVMASytI215JdcTmey67qtF6nwNCANV.jpg'
                ],
                'amenities' => [
                    'Bluetooth',
                    'Leather Seats',
                    'Rear Camera',
                    'Touchscreen Display',
                    'Parking Sensors',
                    'Air Conditioning'
                ]
            ],
            [
                'title' => 'Hyundai اكسنت RB 2026',
                'title_ar' => 'هيونداي اكسنت RB 2026',
                'description' => 'A well-maintained Hyundai اكسنت RB 2026, offering great performance and comfort for city driving or long trips. Enjoy a premium driving experience.',
                'description_ar' => 'سيارة هيونداي اكسنت RB 2026 بحالة ممتازة، تقدم أداء رائع وراحة في القيادة داخل المدينة أو في الرحلات الطويلة. استمتع بتجربة قيادة متميزة.',
                'type' => 'car',
                'category' => 'daily',
                'address' => 'Nasr City',
                'address_ar' => 'مدينة نصر',
                'city' => 'Cairo',
                'city_ar' => 'القاهرة',
                'country' => 'Egypt',
                'country_ar' => 'مصر',
                'latitude' => 30.044310124607616,
                'longitude' => 31.266006333853678,
                'transmission' => 'automatic',
                'fuel_type' => 'petrol',
                'max_guests' => 5,
                'base_price_cents' => 102000,
                'monthly_price_cents' => 3060000,
                'status' => 'active',
                'images' => [
                    'https://malekcars.com/wp-content/uploads/2026/08/M2GiXJtVP1PlDoIuI97g5ZVoqVslbx5OiZkJNLRe.jpg',
                    'https://malekcars.com/wp-content/uploads/2026/08/gCtb5k5Nbm58Ffot1ieI6INH1s0QaTBNbeAVj7OL.jpg',
                    'https://malekcars.com/wp-content/uploads/2026/08/2Kju2nQS5epaLlYZtl3VZbaopKZyPJq74EzsofqA.jpg',
                    'https://malekcars.com/wp-content/uploads/2026/08/EL2Ik3n1dobeoKLvn4oYGRflwUZPZdtJaAGc3jqI.jpg'
                ],
                'amenities' => [
                    'USB Charging Ports',
                    'Air Conditioning',
                    'Parking Sensors',
                    'GPS Navigation',
                    'Rear Camera'
                ]
            ],
            [
                'title' => 'Toyota كورولا 2022',
                'title_ar' => 'تويوتا كورولا 2022',
                'description' => 'A well-maintained Toyota كورولا 2022, offering great performance and comfort for city driving or long trips. Enjoy a premium driving experience.',
                'description_ar' => 'سيارة تويوتا كورولا 2022 بحالة ممتازة، تقدم أداء رائع وراحة في القيادة داخل المدينة أو في الرحلات الطويلة. استمتع بتجربة قيادة متميزة.',
                'type' => 'car',
                'category' => 'daily',
                'address' => 'Nasr City',
                'address_ar' => 'مدينة نصر',
                'city' => 'Cairo',
                'city_ar' => 'القاهرة',
                'country' => 'Egypt',
                'country_ar' => 'مصر',
                'latitude' => 30.07832531744715,
                'longitude' => 31.2419167709902,
                'transmission' => 'automatic',
                'fuel_type' => 'petrol',
                'max_guests' => 5,
                'base_price_cents' => 85000,
                'monthly_price_cents' => 2550000,
                'status' => 'active',
                'images' => [
                    'https://malekcars.com/wp-content/uploads/2026/08/IuNgAntc8FQaRBJIGs716omIoXmRPiC53rT23SIX.jpg',
                    'https://malekcars.com/wp-content/uploads/2026/08/d4jK1mMr2bZB3yW7dXteCBjRBnXheCl0mXTEqoqQ.jpg',
                    'https://malekcars.com/wp-content/uploads/2026/08/x3KrsAbPT349sQ27fycskwTjIhjtUcOF8uBP5OHP.jpg',
                    'https://malekcars.com/wp-content/uploads/2026/08/156QZ0r8cAkrZmbEE4Rt4DNBfSnQqXwxRlFQYHXA.jpg',
                    'https://malekcars.com/wp-content/uploads/2026/08/JaIzzX1S1I83OnHVv4V3obAwAmzFhavenMrufcxG.jpg',
                    'https://malekcars.com/wp-content/uploads/2026/08/TLgmgipOmznR18c6007V4E9XsKdZKNcIma7z9Guy.jpg',
                    'https://malekcars.com/wp-content/uploads/2026/08/ofbxrEtkyg5mPn10l18eyR1hCZ7IegkpnyJ0654P.jpg',
                    'https://malekcars.com/wp-content/uploads/2026/08/laiZEHcXe5t7kdS0D7nggtFqI0iugLSSjT2M4qSV.jpg'
                ],
                'amenities' => [
                    'Parking Sensors',
                    'Cruise Control',
                    'Rear Camera',
                    'GPS Navigation',
                    'Bluetooth'
                ]
            ],
            [
                'title' => 'BMW 318 1999',
                'title_ar' => 'بي ام دبليو 318 1999',
                'description' => 'A well-maintained BMW 318 1999, offering great performance and comfort for city driving or long trips. Enjoy a premium driving experience.',
                'description_ar' => 'سيارة بي ام دبليو 318 1999 بحالة ممتازة، تقدم أداء رائع وراحة في القيادة داخل المدينة أو في الرحلات الطويلة. استمتع بتجربة قيادة متميزة.',
                'type' => 'car',
                'category' => 'luxury',
                'address' => 'Mohandeseen',
                'address_ar' => 'المهندسين',
                'city' => 'Cairo',
                'city_ar' => 'القاهرة',
                'country' => 'Egypt',
                'country_ar' => 'مصر',
                'latitude' => 30.049674635308367,
                'longitude' => 31.18705211296435,
                'transmission' => 'automatic',
                'fuel_type' => 'petrol',
                'max_guests' => 5,
                'base_price_cents' => 31000,
                'monthly_price_cents' => 930000,
                'status' => 'active',
                'images' => [
                    'https://malekcars.com/wp-content/uploads/2026/08/MsIit6I0YCJI1jmp8BKWwMORixO8zYpookvy8rjq.jpg',
                    'https://malekcars.com/wp-content/uploads/2026/08/vrQDE65ms4a3ebbA4b9PXUu0fmmb4GpvTewbGBIL.jpg',
                    'https://malekcars.com/wp-content/uploads/2026/08/JMyqDbpMOHHPXLOK6vvBJ6hdAVxAz7f7kSFsAyZX.jpg',
                    'https://malekcars.com/wp-content/uploads/2026/08/GKre0ntfmRCEbWYXqQMf82TfGcWkWP9TRnOaf5LS.jpg',
                    'https://malekcars.com/wp-content/uploads/2026/08/uTI70fV5vUOOsPwGw0c7GQ6SrHXndNjHRY7GxJT4.jpg'
                ],
                'amenities' => [
                    'Parking Sensors',
                    'GPS Navigation',
                    'Air Conditioning',
                    'USB Charging Ports',
                    'Cruise Control'
                ]
            ],
            [
                'title' => 'شانجان السفن 2022',
                'title_ar' => 'شانجان السفن 2022',
                'description' => 'A well-maintained شانجان السفن 2022, offering great performance and comfort for city driving or long trips. Enjoy a premium driving experience.',
                'description_ar' => 'سيارة شانجان السفن 2022 بحالة ممتازة، تقدم أداء رائع وراحة في القيادة داخل المدينة أو في الرحلات الطويلة. استمتع بتجربة قيادة متميزة.',
                'type' => 'car',
                'category' => 'daily',
                'address' => 'Nasr City',
                'address_ar' => 'مدينة نصر',
                'city' => 'Cairo',
                'city_ar' => 'القاهرة',
                'country' => 'Egypt',
                'country_ar' => 'مصر',
                'latitude' => 30.03219747841436,
                'longitude' => 31.25136445212004,
                'transmission' => 'automatic',
                'fuel_type' => 'petrol',
                'max_guests' => 5,
                'base_price_cents' => 47500,
                'monthly_price_cents' => 1425000,
                'status' => 'active',
                'images' => [
                    'https://malekcars.com/wp-content/uploads/2026/08/4JL2TeFZmdElDi0cvXl1ISGf4rdNsNO8FRl4oiFy.jpg',
                    'https://malekcars.com/wp-content/uploads/2026/08/P2R8h4SOcKKU5OXVwCc3ugJCQzM8HGsHMckkkrXS.jpg',
                    'https://malekcars.com/wp-content/uploads/2026/08/fkSW5XPQVjmMNovax7kZ5quljRrSjtpetX8NGBSr.jpg'
                ],
                'amenities' => [
                    'Air Conditioning',
                    'ABS Brakes',
                    'USB Charging Ports',
                    'Bluetooth',
                    'Parking Sensors',
                    'Rear Camera',
                    'GPS Navigation'
                ]
            ],
            [
                'title' => 'لادا جرانتا 2021',
                'title_ar' => 'لادا جرانتا 2021',
                'description' => 'A well-maintained لادا جرانتا 2021, offering great performance and comfort for city driving or long trips. Enjoy a premium driving experience.',
                'description_ar' => 'سيارة لادا جرانتا 2021 بحالة ممتازة، تقدم أداء رائع وراحة في القيادة داخل المدينة أو في الرحلات الطويلة. استمتع بتجربة قيادة متميزة.',
                'type' => 'car',
                'category' => 'daily',
                'address' => 'Nasr City',
                'address_ar' => 'مدينة نصر',
                'city' => 'Cairo',
                'city_ar' => 'القاهرة',
                'country' => 'Egypt',
                'country_ar' => 'مصر',
                'latitude' => 30.00113516640382,
                'longitude' => 31.26875739502774,
                'transmission' => 'automatic',
                'fuel_type' => 'petrol',
                'max_guests' => 5,
                'base_price_cents' => 45000,
                'monthly_price_cents' => 1350000,
                'status' => 'active',
                'images' => [
                    'https://malekcars.com/wp-content/uploads/2026/08/nsCLCY1cjgbnrO5cGnnR2UJiCOAsQPsW4dMGu1M3.jpg',
                    'https://malekcars.com/wp-content/uploads/2026/08/pp7qEn6ZYCCvHACxu5hC0lTjkALF6WyrCBkUKK3Y.jpg',
                    'https://malekcars.com/wp-content/uploads/2026/08/183gafrSv6ftxBfMCzVdkHyhM3ClyvaUwroJh6f8.jpg',
                    'https://malekcars.com/wp-content/uploads/2026/08/ws48juO3RWjE4NwMK7j9hwlB6XuGrxCItsoO1pQs.jpg',
                    'https://malekcars.com/wp-content/uploads/2026/08/XcLXzUBr7f4ditFqlUp90W4UL4Io2uxGZ5WrZcdV.jpg',
                    'https://malekcars.com/wp-content/uploads/2026/08/J3D54YYNlpALdhBCC5T39sXc6NdGJNQxrjab4ErN.jpg',
                    'https://malekcars.com/wp-content/uploads/2026/08/HJ4kQRW08PMtne9SVzPTQjrVzJzol9uUYFqLHeVb.jpg',
                    'https://malekcars.com/wp-content/uploads/2026/08/YqbOgUcas1Lbf3dHpEF1Tw1nmlgY7RYMWzsYTv19.jpg'
                ],
                'amenities' => [
                    'Bluetooth',
                    'Rear Camera',
                    'Parking Sensors',
                    'Leather Seats',
                    'Air Conditioning',
                    'Touchscreen Display'
                ]
            ],
            [
                'title' => 'شيفروليه كروز 2012',
                'title_ar' => 'شيفروليه كروز 2012',
                'description' => 'A well-maintained شيفروليه كروز 2012, offering great performance and comfort for city driving or long trips. Enjoy a premium driving experience.',
                'description_ar' => 'سيارة شيفروليه كروز 2012 بحالة ممتازة، تقدم أداء رائع وراحة في القيادة داخل المدينة أو في الرحلات الطويلة. استمتع بتجربة قيادة متميزة.',
                'type' => 'car',
                'category' => 'daily',
                'address' => 'Mohandeseen',
                'address_ar' => 'المهندسين',
                'city' => 'Cairo',
                'city_ar' => 'القاهرة',
                'country' => 'Egypt',
                'country_ar' => 'مصر',
                'latitude' => 30.04711078547042,
                'longitude' => 31.256779492144602,
                'transmission' => 'automatic',
                'fuel_type' => 'petrol',
                'max_guests' => 5,
                'base_price_cents' => 41000,
                'monthly_price_cents' => 1230000,
                'status' => 'active',
                'images' => [
                    'https://malekcars.com/wp-content/uploads/2026/08/BAJNsa1oiPLEbIrlCdcfZytzzxal3vZoHvQlwt4k.jpg',
                    'https://malekcars.com/wp-content/uploads/2026/08/YWuMa1nsA1VNaQwY9t6rvAJoIr8bySbpfv8UaoMX.jpg',
                    'https://malekcars.com/wp-content/uploads/2026/08/8avZCd5s3ftHsXvoPBVDPlJHCZVbdWERiqMiHFns.jpg',
                    'https://malekcars.com/wp-content/uploads/2026/08/n2pRiajMh8OwIef9sk2zljhR9IaWY28Xt0cAex7I.jpg',
                    'https://malekcars.com/wp-content/uploads/2026/08/OsD1jLI1IN8TBASEGhjgGNbjku2FQ4WypUeOgECb.jpg',
                    'https://malekcars.com/wp-content/uploads/2026/08/yO9Th7lCUcPNdE9eiFPOB46MIXsDWfivO8NToBgr.jpg',
                    'https://malekcars.com/wp-content/uploads/2026/08/n5V1lhuhuSUjxwqRLIgejw6YibMcBA72yLnK3jiW.jpg',
                    'https://malekcars.com/wp-content/uploads/2026/08/LeN0NJkmwgl9CRGJJCKqxwDkQ2b6BVBHaeHr1asq.jpg'
                ],
                'amenities' => [
                    'Parking Sensors',
                    'USB Charging Ports',
                    'ABS Brakes',
                    'Air Conditioning',
                    'Leather Seats',
                    'GPS Navigation',
                    'Rear Camera'
                ]
            ],
            [
                'title' => 'Renault لوجان 2010',
                'title_ar' => 'رينو لوجان 2010',
                'description' => 'A well-maintained Renault لوجان 2010, offering great performance and comfort for city driving or long trips. Enjoy a premium driving experience.',
                'description_ar' => 'سيارة رينو لوجان 2010 بحالة ممتازة، تقدم أداء رائع وراحة في القيادة داخل المدينة أو في الرحلات الطويلة. استمتع بتجربة قيادة متميزة.',
                'type' => 'car',
                'category' => 'daily',
                'address' => 'Nasr City',
                'address_ar' => 'مدينة نصر',
                'city' => 'Cairo',
                'city_ar' => 'القاهرة',
                'country' => 'Egypt',
                'country_ar' => 'مصر',
                'latitude' => 30.055776288514426,
                'longitude' => 31.196773508889773,
                'transmission' => 'automatic',
                'fuel_type' => 'petrol',
                'max_guests' => 5,
                'base_price_cents' => 28000,
                'monthly_price_cents' => 840000,
                'status' => 'active',
                'images' => [
                    'https://malekcars.com/wp-content/uploads/2026/08/Ybd8a9gtcE1iu5OUYgrguLitsNi7WuESCXUPVasQ.jpg',
                    'https://malekcars.com/wp-content/uploads/2026/08/2RaU6jAGWcbyCPloTcpxal0Ks0ltlOefXprftqI7.jpg',
                    'https://malekcars.com/wp-content/uploads/2026/08/g3kcplvd1txsqLOhIVIW3fmutVA9UAQiguCmt0eN.jpg',
                    'https://malekcars.com/wp-content/uploads/2026/08/2MwtaZPocfX2rd0m43HvFOvIWW5XowZU8KcUaz37.jpg',
                    'https://malekcars.com/wp-content/uploads/2026/08/QKmetyE8zqU5LbLVerJ4oQ0nCuldFJpn5Lf3JKET.jpg'
                ],
                'amenities' => [
                    'GPS Navigation',
                    'Touchscreen Display',
                    'Air Conditioning',
                    'Leather Seats',
                    'USB Charging Ports',
                    'Cruise Control'
                ]
            ],
            [
                'title' => 'Honda HRV 2004',
                'title_ar' => 'هوندا HRV 2004',
                'description' => 'A well-maintained Honda HRV 2004, offering great performance and comfort for city driving or long trips. Enjoy a premium driving experience.',
                'description_ar' => 'سيارة هوندا HRV 2004 بحالة ممتازة، تقدم أداء رائع وراحة في القيادة داخل المدينة أو في الرحلات الطويلة. استمتع بتجربة قيادة متميزة.',
                'type' => 'car',
                'category' => 'daily',
                'address' => 'Maadi',
                'address_ar' => 'المعادي',
                'city' => 'Cairo',
                'city_ar' => 'القاهرة',
                'country' => 'Egypt',
                'country_ar' => 'مصر',
                'latitude' => 30.054294702414705,
                'longitude' => 31.251487034204125,
                'transmission' => 'automatic',
                'fuel_type' => 'petrol',
                'max_guests' => 5,
                'base_price_cents' => 60000,
                'monthly_price_cents' => 1800000,
                'status' => 'active',
                'images' => [
                    'https://malekcars.com/wp-content/uploads/2026/08/yLcJZriu7PTFg4TkMDks1iIC9UJVSNah07U7VZA4.jpg',
                    'https://malekcars.com/wp-content/uploads/2026/08/iItQmHJYo9S1HgtEtcFGqIbvcU19TJVKjDTPKZJU.jpg',
                    'https://malekcars.com/wp-content/uploads/2026/08/YhIhCyu84NhOjFJh5xAADfD5bGTh4DQnfu9B0P62.jpg',
                    'https://malekcars.com/wp-content/uploads/2026/08/FC5PUs6vkN1uWQZmAiGcucIMteo4kP4mysbJTAB1.jpg',
                    'https://malekcars.com/wp-content/uploads/2026/08/r3ms4vWbtfZIGgjVwoO2vXHVcuGfqKudRAkvLR9T.jpg'
                ],
                'amenities' => [
                    'USB Charging Ports',
                    'Touchscreen Display',
                    'Rear Camera',
                    'Bluetooth'
                ]
            ],
            [
                'title' => 'BMW اى اكس 2023',
                'title_ar' => 'بي ام دبليو اى اكس 2023',
                'description' => 'A well-maintained BMW اى اكس 2023, offering great performance and comfort for city driving or long trips. Enjoy a premium driving experience.',
                'description_ar' => 'سيارة بي ام دبليو اى اكس 2023 بحالة ممتازة، تقدم أداء رائع وراحة في القيادة داخل المدينة أو في الرحلات الطويلة. استمتع بتجربة قيادة متميزة.',
                'type' => 'car',
                'category' => 'luxury',
                'address' => 'Nasr City',
                'address_ar' => 'مدينة نصر',
                'city' => 'Cairo',
                'city_ar' => 'القاهرة',
                'country' => 'Egypt',
                'country_ar' => 'مصر',
                'latitude' => 30.069360370001686,
                'longitude' => 31.18904272737579,
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
                    'USB Charging Ports',
                    'Rear Camera',
                    'ABS Brakes',
                    'Air Conditioning',
                    'Bluetooth'
                ]
            ],
            [
                'title' => 'Porsche كاريرا 2013',
                'title_ar' => 'بورش كاريرا 2013',
                'description' => 'A well-maintained Porsche كاريرا 2013, offering great performance and comfort for city driving or long trips. Enjoy a premium driving experience.',
                'description_ar' => 'سيارة بورش كاريرا 2013 بحالة ممتازة، تقدم أداء رائع وراحة في القيادة داخل المدينة أو في الرحلات الطويلة. استمتع بتجربة قيادة متميزة.',
                'type' => 'car',
                'category' => 'sports',
                'address' => 'Maadi',
                'address_ar' => 'المعادي',
                'city' => 'Cairo',
                'city_ar' => 'القاهرة',
                'country' => 'Egypt',
                'country_ar' => 'مصر',
                'latitude' => 30.02481865434659,
                'longitude' => 31.27049547468383,
                'transmission' => 'automatic',
                'fuel_type' => 'petrol',
                'max_guests' => 5,
                'base_price_cents' => 399900,
                'monthly_price_cents' => 11997000,
                'status' => 'active',
                'images' => [
                    ''
                ],
                'amenities' => [
                    'Touchscreen Display',
                    'Bluetooth',
                    'Cruise Control',
                    'Rear Camera'
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
