<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Listing;
use App\Models\User;
use App\Models\Amenity;
use App\Models\Review;
use App\Services\AmenityService;
use Illuminate\Support\Str;

class ScrapeTestCommand extends Command
{
    protected $signature = 'scrape:villa';
    protected $description = 'Test scraping and inserting the Garana Villa listing';

    public function handle(AmenityService $amenityService)
    {
        $this->info('Starting Villa listing insertion...');

        $owner = User::where('role', 'customer')->first() ?? User::factory()->create(['role' => 'customer']);

        $listing = Listing::forceCreate([
            'uuid' => Str::uuid()->toString(),
            'created_by' => $owner->id,
            'title' => 'Luxury 1-Bedroom Apartment in V Residence, Villette',
            'title_ar' => 'شقة فاخرة بغرفة نوم واحدة للإيجار في في ريزيدنس، فيليت',
            'description' => "Experience upscale living in this brand new, luxurious apartment located in the prestigious V Residence, Villette, New Cairo. Spanning 110 square meters, this elegant unit offers an exceptional lifestyle with premium finishes and stunning open landscape views.\n\nProperty Highlights:\n- 1 spacious master bedroom complete with a private bathroom and TV\n- Large, beautifully designed reception area\n- 2 modern bathrooms\n- Expansive terrace offering unobstructed landscape views\n- First use (Brand new property)\n\nResidents of Villette enjoy access to top-tier amenities, ensuring comfort, privacy, and a vibrant community atmosphere in the heart of the 5th Settlement.",
            'description_ar' => "استمتع بالرقي والفخامة في هذه الشقة الجديدة كلياً والواقعة في أرقى مجمعات القاهرة الجديدة، في ريزيدنس (V Residence) بفيليت. تمتد هذه الوحدة الأنيقة على مساحة 110 متر مربع، وتقدم أسلوب حياة استثنائي بتشطيبات فاخرة وإطلالات مفتوحة على المساحات الخضراء.\n\nمميزات العقار:\n- غرفة نوم رئيسية واسعة (ماستر) مزودة بحمام خاص وتلفزيون\n- منطقة استقبال (ريسبشن) كبيرة ومصممة بأناقة\n- حمامان بتصميم عصري\n- تراس واسع يوفر إطلالة مفتوحة وخلابة على اللاند سكيب\n- أول سكن (لم يسبق استخدامها)\n\nيتميز سكان فيليت بإمكانية الوصول إلى مرافق وخدمات عالية المستوى، مما يضمن الراحة والخصوصية وتجربة سكنية متكاملة في قلب التجمع الخامس.",
            'type' => 'property',
            'property_type' => 'apartment',
            'address' => 'فيليت, كمبوندات التجمع الخامس, التجمع الخامس, مدينة القاهرة الجديدة',
            'city' => 'القاهرة الجديدة',
            'country' => 'Egypt',
            'latitude' => 30.022596359253,
            'longitude' => 31.545814514160,
            'base_price_cents' => 250000, 
            'monthly_price_cents' => 7000000, 
            'original_base_price_cents' => null,
            'status' => 'active',
            'bedrooms' => 1,
            'bathrooms' => 2,
            'max_guests' => 2,
        ]);

        $this->info('Listing created: ' . $listing->id);

        // Add media
        $listing->media()->createMany([
            ['url' => 'https://static.shared.propertyfinder.eg/media/images/listing/23RVTR967NQV6K7718R3BVGVHW/afe69f26-9ebf-4331-8e32-33b6853c685a/668x452.jpg', 'type' => 'image', 'order' => 1, 'is_primary' => true],
            ['url' => 'https://static.shared.propertyfinder.eg/media/images/listing/23RVTR967NQV6K7718R3BVGVHW/9a092c06-29f3-46d2-8da0-61bd8088386e/668x452.jpg', 'type' => 'image', 'order' => 2],
            ['url' => 'https://static.shared.propertyfinder.eg/media/images/listing/23RVTR967NQV6K7718R3BVGVHW/53710aa6-a613-4d1a-828c-927ed277ef12/668x452.jpg', 'type' => 'image', 'order' => 3],
        ]);

        $this->info('Processing amenities...');

        $scrapedAmenities = [
            'تكييف مركزي', 'موقف مغطى', 'تجهيزات مطبخ', 'مسبح مشترك',
            'نادي صحي مشترك', 'صالة رياضة مشتركة', 'مطل على معلم رئيسي',
            'حوض سباحة للأطفال'
        ];

        $customTranslations = [
            'تكييف مركزي' => ['name' => 'Central AC', 'name_ar' => 'تكييف مركزي', 'icon' => 'ac-unit'],
            'موقف مغطى' => ['name' => 'Covered Parking', 'name_ar' => 'موقف مغطى', 'icon' => 'directions-car'],
            'تجهيزات مطبخ' => ['name' => 'Kitchen Appliances', 'name_ar' => 'تجهيزات مطبخ', 'icon' => 'kitchen'],
            'مسبح مشترك' => ['name' => 'Shared Pool', 'name_ar' => 'مسبح مشترك', 'icon' => 'pool'],
            'نادي صحي مشترك' => ['name' => 'Shared Spa', 'name_ar' => 'نادي صحي مشترك', 'icon' => 'spa'],
            'صالة رياضة مشتركة' => ['name' => 'Shared Gym', 'name_ar' => 'صالة رياضة مشتركة', 'icon' => 'fitness-center'],
            'مطل على معلم رئيسي' => ['name' => 'Landmark View', 'name_ar' => 'مطل على معلم رئيسي', 'icon' => 'location-city'],
            'حوض سباحة للأطفال' => ['name' => 'Kids Pool', 'name_ar' => 'حوض سباحة للأطفال', 'icon' => 'child-care'],
        ];

        $amenityIds = [];
        foreach ($scrapedAmenities as $scrapedName) {
            if (isset($customTranslations[$scrapedName])) {
                $trans = $customTranslations[$scrapedName];
                
                $existing = Amenity::where('name', $trans['name'])
                                 ->orWhere('name_ar', $trans['name_ar'])
                                 ->first();
                
                if (!$existing) {
                    $existing = Amenity::create([
                        'name' => $trans['name'],
                        'name_ar' => $trans['name_ar'],
                        'icon' => $trans['icon'],
                        'type' => 'property'
                    ]);
                    $this->info("Created NEW amenity: {$trans['name']} ({$trans['name_ar']})");
                } else {
                    $this->info("Matched existing amenity: {$existing->name}");
                }
                $amenityIds[] = $existing->id;
            } else {
                $matched = $amenityService->matchOrCreate($scrapedName, 'property');
                $this->info("Matched existing amenity via service: {$matched->name}");
                $amenityIds[] = $matched->id;
            }
        }

        $listing->amenities()->sync(array_unique($amenityIds));
        
        $this->generateReviews($listing);

        $this->info('Done! Listing added successfully with reviews.');
    }

    private function generateReviews(Listing $listing): void
    {
        $this->info('Generating realistic reviews...');

        $egyptianNames = ['Ahmed Tarek', 'Mahmoud Hassan', 'Mostafa Kamal', 'Nourhan Adel', 'Youssef Ibrahim', 'Salma Ahmed', 'Omar Saeed', 'Menna Ali', 'Kareem Nabil'];
        $egyptianComments = [
            'المكان تحفة بجد ونظيف جدا، هنيجي تاني اكيد',
            'بصراحة المكان روعة وموقعه يجنن، والناس ذوق جدا',
            'Very nice place and clean, we enjoyed our stay.',
            'كل حاجة كانت بيرفكت، شكرا جدا على الاستضافة',
            'Nice property, very clean, highly recommended.',
            'المكان هادي جدا والفيو حلو اوي'
        ];

        $khaleejiNames = ['Faisal Al-Dosari', 'Khaled Al-Qahtani', 'Nouf Al-Mutairi', 'Saud Al-Otaibi', 'Fatima Al-Jaber', 'Abdullah Al-Marri', 'Mona Al-Shamsi', 'Ali Al-Harthy'];
        $khaleejiComments = [
            'المكان وايد حلو ومرتب، يعطيكم العافية',
            'صراحة المكان ممتاز ويصلح للعوائل الخليجية',
            'ما شاء الله المكان يفتح النفس وكل شي متوفر',
            'Amazing property, very private and suitable for families.',
            'المكان نظيف ووايد روعة، انصح فيه بشدة',
            'خوش مكان والله، استانسنا وايد'
        ];

        $foreignNames = ['Thomas Muller', 'Sophie Martin', 'James Anderson', 'Elena Rodriguez', 'Liam O\'Connor', 'Chloe Davies', 'Oliver Wright', 'Emma Hansen'];
        $foreignComments = [
            'Absolutely loved our stay here, the host was super helpful.',
            'Great place for a family vacation. The stay was amazing.',
            'Place was spotless and exactly like the pictures.',
            'Awesome location, very peaceful and quiet.',
            'Had a brilliant time, would definitely come back!',
            'The amenities were great and check-in was a breeze.'
        ];

        $numReviews = rand(3, 8);
        $totalRating = 0;

        for ($i = 0; $i < $numReviews; $i++) {
            $rating = rand(4, 5);
            $totalRating += $rating;
            
            $rand = rand(1, 100);
            if ($rand <= 50) {
                // 50% Egyptian
                $name = $egyptianNames[array_rand($egyptianNames)];
                $comment = $egyptianComments[array_rand($egyptianComments)];
            } elseif ($rand <= 80) {
                // 30% Khaleeji
                $name = $khaleejiNames[array_rand($khaleejiNames)];
                $comment = $khaleejiComments[array_rand($khaleejiComments)];
            } else {
                // 20% Foreign
                $name = $foreignNames[array_rand($foreignNames)];
                $comment = $foreignComments[array_rand($foreignComments)];
            }
            
            Review::create([
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

        $this->info("Added {$numReviews} realistic reviews (Average Rating: {$averageRating}).");
    }
}
