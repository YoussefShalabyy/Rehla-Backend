<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Listing;
use App\Models\User;
use App\Models\Review;
use App\Models\Amenity;
use App\Services\AmenityService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ScrapeBulkCommand extends Command
{
    protected $signature = 'scrape:bulk';
    protected $description = 'Scrape bulk listings with images stored locally';

    public function handle(AmenityService $amenityService)
    {
        $owner = User::where('role', 'customer')->first() ?? User::factory()->create(['role' => 'customer']);

        $listingsData = [
            [
                'title' => '2-Bedroom Apartment for Rent in Fanadir Bay',
                'title_ar' => 'شقة أنيقة بغرفتي نوم للإيجار في فنادير باي',
                'description' => 'A fully furnished apartment for rent in Fanadir Bay, offering a clean, modern, and comfortable living space in El Gouna, Hurghada.
The apartment features two well-sized bedrooms with practical furniture, a bright living area furnished with a modern sofa set, and a dining space suitable for everyday use. The American-style kitchen is fully equipped with essential appliances, providing a functional and open layout.
The unit is fully air-conditioned and ready to move in, making it suitable long-term stays.
 Fanadir Bay Resort features a Private Beach, 4 Swimming Pools, 1 Kids\' Pool, an Aqua Park, restaurants and cafes, 24/7 security, and a gated community, ensuring peace of mind. 
Fanadir Bay is five-minutes drive from El Gouna, 10 minutes from Hurghada City Center Mall, and 20 minutes from Hurghada International Airport.',
                'description_ar' => 'شقة مفروشة بالكامل للإيجار الطويل في كمبوند فنادير ، توفر مساحة معيشة نظيفة وعصرية ومريحة بالقرب من الجونة، الغردقة.

تضم الشقة غرفتي نوم واسعتين بأثاث عملي، وغرفة معيشة مشرقة مفروشة بأثاث عصري، وركن لتناول الطعام مناسب للاستخدام اليومي. المطبخ على الطراز الأمريكي مجهز بالكامل بالأجهزة الأساسية، مما يوفر تصميمًا عمليًا ومفتوحًا.
الشقة مكيفة بالكامل وجاهزة للسكن، مما يجعلها مناسبة للإقامات الطويلة.
يتمتع المنتجع بإطلالة مباشرة على البحر الأحمر، مما يوفر مناظر خلابة وأجواءً هادئة. كما يضم شاطئاً خاصاً، وأربعة مسابح، ومسبحاً للأطفال، وحديقة مائية، ومطاعم ومقاهي، وأمناً على مدار الساعة، ومجمعاً سكنياً مسوراً يضمن لكم راحة البال. 


يتميز منتجع فناديرباي بشاطئ خاص، وأربعة مسابح، ومسبح للأطفال، وحديقة مائية، ومطاعم ومقاهٍ، وأمن على مدار الساعة، ومجمع سكني مسوّر يضمن لكم راحة البال. يقع مشروع فنادير باي على بُعد خمس دقائق بالسيارة من الجونة، وعشر دقائق من مركز مدينة الغردقة التجاري، وعشرين دقيقة من مطار الغردقة الدولي. 
.',
                'type' => 'property',
                'property_type' => 'apartment',
                'address' => 'Hurghada, Red Sea, Egypt',
                'address_ar' => 'الغردقة، البحر الأحمر، مصر',
                'city' => 'Hurghada',
                'city_ar' => 'الغردقة',
                'country' => 'Egypt',
                'country_ar' => 'مصر',
                'latitude' => 27.280988693237305,
                'longitude' => 33.77423858642578,
                'base_price_cents' => 133333,
                'monthly_price_cents' => 4000000,
                'status' => 'active',
                'bedrooms' => 2,
                'bathrooms' => 1,
                'max_guests' => 4,
                'images' => [
                    'https://static.shared.propertyfinder.eg/media/images/listing/GSP346RN3XYZB5RWX8BXVYX79C/749cf614-1d86-42ff-ad9d-d7c3b226e01d/1312x894.jpg',
                    'https://static.shared.propertyfinder.eg/media/images/listing/GSP346RN3XYZB5RWX8BXVYX79C/83e68e74-0cee-4bf2-a3e2-0de233e80455/1312x894.jpg',
                    'https://static.shared.propertyfinder.eg/media/images/listing/GSP346RN3XYZB5RWX8BXVYX79C/c5f6f59f-5841-4012-af32-0281e63dde6e/1312x894.jpg',
                    'https://static.shared.propertyfinder.eg/media/images/listing/GSP346RN3XYZB5RWX8BXVYX79C/ecee4433-4ce4-44b8-9938-c39de8dbd916/1312x894.jpg',
                    'https://static.shared.propertyfinder.eg/media/images/listing/GSP346RN3XYZB5RWX8BXVYX79C/69d095ea-147c-4f1f-95eb-e7e473ddd91b/1312x894.jpg',
                    'https://static.shared.propertyfinder.eg/media/images/listing/GSP346RN3XYZB5RWX8BXVYX79C/e29facd1-2924-4187-9a30-916c09d67141/1312x894.jpg',
                    'https://static.shared.propertyfinder.eg/media/images/listing/GSP346RN3XYZB5RWX8BXVYX79C/f26d7296-4f4c-4d9a-9d6c-975ee56650a3/1312x894.jpg',
                    'https://static.shared.propertyfinder.eg/media/images/listing/GSP346RN3XYZB5RWX8BXVYX79C/58a20300-725a-44cc-a78c-4baa8b81161b/1312x894.jpg',
                    'https://static.shared.propertyfinder.eg/media/images/listing/GSP346RN3XYZB5RWX8BXVYX79C/63b85794-744c-431a-a871-9a3452de03a6/1312x894.jpg',
                    'https://static.shared.propertyfinder.eg/media/images/listing/GSP346RN3XYZB5RWX8BXVYX79C/459f5c92-e336-4dd0-a9c0-b1db097b522c/1312x894.jpg'
                ],
                'amenities' => [
                    'تكييف مركزي',
                    'مسبح مشترك',
                    'حوض سباحة للأطفال',
                    'ردهة في المبنى'
                ]
            ],
            [
                'title' => 'Live in The Heart Of Sahl Hasheesh, Rent In Tawaya',
                'title_ar' => 'للايجار في توايا سهل حشيش بالداون تاون ',
                'description' => 'A Fully Furnished Apartment For Long-Term Rent In Tawaya Sahl Hasheesh. The apartment is on the first floor. It has a spacious living room, a bedroom, and a bathroom. The kitchen is fully equipped with all the appliances you may need.
This apartment is in Tawaya, the heart of Sahl Hasheesh town. Everything you will need is steps from your apartment, so no need for a car. Besides your home, you have the most beautiful shores in Sahl Hasheesh; Il Gusto, Bus Stop, and Shimmers. Best Way market and the pharmacy are 5 minutes on foot from your home. The bakery and many other shops and cafes are there for you.
The rent rate of the apartment is 600 Euro per month

For more info, feel free to contact us',
                'description_ar' => 'شقة مفروشة بالكامل للإيجار طويل الأجل في طاوة سهل حشيش. تقع الشقة في الطابق الأول، وتضم غرفة معيشة واسعة، وغرفة نوم، وحمامًا. المطبخ مجهز بالكامل بجميع الأجهزة التي قد تحتاجها.

تقع هذه الشقة في طاوة، قلب مدينة سهل حشيش. كل ما تحتاجه على بُعد خطوات من شقتك، فلا حاجة للسيارة. بالإضافة إلى منزلك، يمكنك الاستمتاع بأجمل شواطئ سهل حشيش؛ مثل مطعم إيل غوستو، وموقف الحافلات، وشيمرز. يقع سوق بيست واي والصيدلية على بُعد 5 دقائق سيرًا على الأقدام من منزلك. كما تتوفر المخبز والعديد من المتاجر والمقاهي الأخرى.

إيجار الشقة 600 يورو شهريًا.

للمزيد من المعلومات، تواصل معنا.',
                'type' => 'property',
                'property_type' => 'apartment',
                'address' => 'Hurghada, Red Sea, Egypt',
                'address_ar' => 'الغردقة، البحر الأحمر، مصر',
                'city' => 'Hurghada',
                'city_ar' => 'الغردقة',
                'country' => 'Egypt',
                'country_ar' => 'مصر',
                'latitude' => 27.048694610595703,
                'longitude' => 33.89112091064453,
                'base_price_cents' => 111666,
                'monthly_price_cents' => 3350000,
                'status' => 'active',
                'bedrooms' => 1,
                'bathrooms' => 1,
                'max_guests' => 2,
                'images' => [
                    'https://static.shared.propertyfinder.eg/media/images/listing/07BDAEB6V3E4YSVZAX5V0JQA3C/eb34fc46-d856-40e1-8042-4188b573978e/1312x894.jpg',
                    'https://static.shared.propertyfinder.eg/media/images/listing/07BDAEB6V3E4YSVZAX5V0JQA3C/ed9e3eff-f25e-4625-80b8-2e0fb24ddf8c/1312x894.jpg',
                    'https://static.shared.propertyfinder.eg/media/images/listing/07BDAEB6V3E4YSVZAX5V0JQA3C/2f9131c5-cdb9-4f98-9913-87990036fa61/1312x894.jpg',
                    'https://static.shared.propertyfinder.eg/media/images/listing/07BDAEB6V3E4YSVZAX5V0JQA3C/1890c874-122f-405c-b395-35668691756d/1312x894.jpg',
                    'https://static.shared.propertyfinder.eg/media/images/listing/07BDAEB6V3E4YSVZAX5V0JQA3C/d508aa51-56aa-4ec8-982c-fcd1c6fa8eef/1312x894.jpg',
                    'https://static.shared.propertyfinder.eg/media/images/listing/07BDAEB6V3E4YSVZAX5V0JQA3C/b5954539-f107-4c79-98f4-e5390030e15b/1312x894.jpg',
                    'https://static.shared.propertyfinder.eg/media/images/listing/07BDAEB6V3E4YSVZAX5V0JQA3C/c1f1573b-6775-46aa-8f0b-6bc24a529ad1/1312x894.jpg',
                    'https://static.shared.propertyfinder.eg/media/images/listing/07BDAEB6V3E4YSVZAX5V0JQA3C/7d0ba00d-2af5-474c-8624-3d80414076a2/1312x894.jpg',
                    'https://static.shared.propertyfinder.eg/media/images/listing/07BDAEB6V3E4YSVZAX5V0JQA3C/5ab35495-5cde-4544-a070-4efceb7d7e29/1312x894.jpg',
                    'https://static.shared.propertyfinder.eg/media/images/listing/07BDAEB6V3E4YSVZAX5V0JQA3C/604dc989-2e6a-4be9-bd7e-9ece1396584b/1312x894.jpg'
                ],
                'amenities' => [
                    'تكييف مركزي',
                    'تجهيزات مطبخ'
                ]
            ],
            [
                'title' => 'Modern 1BR Sea View Apt in Lavanda Resort',
                'title_ar' => 'شقة مودرن غرف واحدة بحر في لافاندا ريزورت',
                'description' => 'Premium fully furnished 1-bedroom apartment available for immediate rent in Lavanda Resort, located in the rapidly growing Al Ahyaa district of Hurghada. This modern unit features sleek, minimalist corporate aesthetics and offers scenic views stretching toward the Red Sea. Perfectly positioned just 10 minutes from El Gouna and 15–20 minutes from Hurghada International Airport.

Key Features:

Size: 64 SQM of well-utilized living space

Layout: 1 spacious bedroom & 1 contemporary bathroom

Floor: 4th floor, accessible via 2 high-speed elevators

Living Area: Comfortable corner sofa, flat-screen TV mounted on a wood-paneled accent wall, full AC

Kitchen: Fully equipped with built-in stovetop, refrigerator, and integrated washing machine

Bedroom: Double bed, integrated wardrobe, and elegant recessed lighting

Outdoor Space: Private balcony with seating and a direct sea view

Facilities & Amenities:

Secure gated compound entry

2 modern elevators

Full air conditioning throughout

Walking distance to the beach

Exceptional proximity to El Gouna\'s dining and marinas

Rental Terms & Payment Plan:

Monthly Rent: 550 EUR

Minimum Rental Period: 3 months

Availability: Ready for immediate move-in

Utilities: Water and electricity billed separately based on meter readings

Ideal for expats, digital nomads, and professionals looking for a peaceful coastal retreat with premium finishes and high-yield location value.',
                'description_ar' => 'شقة فاخرة مفروشة بالكامل بمساحة غرف نوم واحدة متاحة للإيجار الفوري في كمبوند لافاندا ريزورت (Lavanda Resort) بمنطقة الأحياء الناشئة في الغردقة. تتميز الوحدة بتصميم مودرن وعملي مع إطلالات مفتوحة على البحر الأحمر. يقع الكمبوند في موقع استراتيجي على بعد 10 دقائق فقط من الجونة و15-20 دقيقة من مطار الغردقة الدولي.

مواصفات الوحدة الرئيسية:

المساحة: 64 متر مربع مستغلة بالكامل

التقسيم: غرفة نوم واسعة + حمام عصري

الدور: الرابع (يوجد 2 مصعد فائق السرعة)

ريسبشن: كنب ركنة مريح، شاشة تلفزيون مثبتة على جدار خشبي أنيق، تكييف بالكامل

المطبخ: مجهز بالكامل ببوتاجاز مسطح، ثلاجة، وغسالة ملابس مدمجة

غرفة النوم: سرير مزدوج، دولاب مدمج، وإضاءة سقف حديثة

المساحة الخارجية: شرفة خاصة مع جلسة وإطلالة مباشرة على البحر

الخدمات والمرافق:

بوابات أمنية وحراسة للكمبوند

2 مصعد حديث

تكييف هواء بالكامل في الغرفة والريسيبشن

على بعد دقائق قليلة مشياً من الشاطئ

قرب ممتاز من مطاعم ومارينا الجونة

شروط الإيجار ونظام السداد:

الإيجار الشهري: 550 يورو

الحد الأدنى لفترة الإيجار: 3 أشهر

المتاحية: جاهزة للسكن الفوري

المرافق: يتم حساب استهلاك المياه والكهرباء بشكل منفصل بناءً على قراءات العدادات

مثالية للمغتربين، وأصحاب العمل عن بُعد، والمهنيين الباحثين عن سكن ساحلي هادئ بتشطيبات راقية وموقع حيوي.',
                'type' => 'property',
                'property_type' => 'apartment',
                'address' => 'Hurghada, Red Sea, Egypt',
                'address_ar' => 'الغردقة، البحر الأحمر، مصر',
                'city' => 'Hurghada',
                'city_ar' => 'الغردقة',
                'country' => 'Egypt',
                'country_ar' => 'مصر',
                'latitude' => 27.309650421142578,
                'longitude' => 33.71589660644531,
                'base_price_cents' => 104360,
                'monthly_price_cents' => 3130800,
                'status' => 'active',
                'bedrooms' => 1,
                'bathrooms' => 1,
                'max_guests' => 2,
                'images' => [
                    'https://static.shared.propertyfinder.eg/media/images/listing/VJQMEYV4R53WGA5SKSYY4757A0/297240b8-2983-4776-9e05-dcbb75bf9f4b/1312x894.jpg',
                    'https://static.shared.propertyfinder.eg/media/images/listing/VJQMEYV4R53WGA5SKSYY4757A0/16b50e92-d759-4b62-9a0c-4a3c625d48a2/1312x894.jpg',
                    'https://static.shared.propertyfinder.eg/media/images/listing/VJQMEYV4R53WGA5SKSYY4757A0/c083527a-4867-4c47-96fe-a1acc532490e/1312x894.jpg',
                    'https://static.shared.propertyfinder.eg/media/images/listing/VJQMEYV4R53WGA5SKSYY4757A0/5048b71a-ec41-4abe-8202-ace750b29f61/1312x894.jpg',
                    'https://static.shared.propertyfinder.eg/media/images/listing/VJQMEYV4R53WGA5SKSYY4757A0/36dddc9d-6833-48b0-ae66-403d93c91c21/1312x894.jpg',
                    'https://static.shared.propertyfinder.eg/media/images/listing/VJQMEYV4R53WGA5SKSYY4757A0/0f2cb004-b63e-4ba1-8e81-6af643edc810/1312x894.jpg',
                    'https://static.shared.propertyfinder.eg/media/images/listing/VJQMEYV4R53WGA5SKSYY4757A0/5d39f04b-4dff-4c73-a79b-6d95cf7bcb1f/1312x894.jpg',
                    'https://static.shared.propertyfinder.eg/media/images/listing/VJQMEYV4R53WGA5SKSYY4757A0/cfc29cf8-aad6-4214-b46a-1f6c4f7b5188/1312x894.jpg',
                    'https://static.shared.propertyfinder.eg/media/images/listing/VJQMEYV4R53WGA5SKSYY4757A0/076f9791-5618-4e3a-97a3-407052ff8193/1312x894.jpg',
                    'https://static.shared.propertyfinder.eg/media/images/listing/VJQMEYV4R53WGA5SKSYY4757A0/8b9f0fb1-164d-4f47-beb4-10fad84ccce5/1312x894.jpg'
                ],
                'amenities' => [
                    'تكييف مركزي',
                    'موقف مغطى',
                    'تجهيزات مطبخ',
                    'مسبح مشترك',
                    'مطل على بحيرات',
                    'مطل على معلم رئيسي'
                ]
            ],
            [
                'title' => 'شقة عالبحر في فندق 5 نجوم بشاطئ خاص',
                'title_ar' => 'شقة عالبحر في فندق 5 نجوم بشاطئ خاص',
                'description' => 'The apartment 75 sqm

Ground floor - Garden

Contains:
One bedroom , spacious reception, bathroom, American kitchen, spacious terrace overlooking pool and garden.

Luxury high end finishing and furnished with all equipment.
Asking price is 350 Euro .
Offering an outdoor swimming pool, a bar and a garden, Stella Makadi Chalets is situated in the Makadi Bay district of Hurghada, only 350 m from Cleopatra Beach. Located 450 m from Makadi Beach, the property features a private beach area and free private parking.

The chalet offers a childrens playground. Both a bicycle rental service and a car rental service are available at Stella Makadi Chalets, while cycling can be enjoyed nearby.
Stella Markadi Beach is 750 m from the accommodation, while New Marina is 37 km from the property. The nearest airport is Hurghada International, 34 km from Stella Makadi Chalets, and the property offers a paid airport shuttle service.

Whats nearby:
Makadi Bay Water World, 2.8 km
Mini Egypt Park, 4.5 km
Jungle Aqua Park, 14.1 km
Senzo Mall, 14.7 km
Sand City Hurghada, 14.9 km
Hurghada Grand Aquarium, 18.4 km',
                'description_ar' => 'شقة 75 متر غرفة نوم  و ريسيبشن مفروشة بالكامل
بالطابق الأرضي عالحديقة و البسين
تتكون من:
غرفتين نوم، ريسيبشن واسع، حمام ، مطبخ أمريكي، تراس كبير وجميل يطل على الحديقة.
تشطيب فاخر ومفروش بالكامل بكافة المفروشات و الأجهزة تشطيب حديث و حمام مجدد بالكامل موقع متميز جدا بالقرية الأقرب للفندق و البحر.


تقع شاليهات ستيلا مكادي في منطقة خليج مكادي بمدينة الغردقة ، على بُعد 350 مترًا فقط من شاطئ كليوباترا ، وتضم مسبحًا في الهواء الطلق وبارًا وحديقة. يقع مكان الإقامة على بعد 450 مترًا من شاطئ مكادي ، ويضم منطقة شاطئ خاص ومواقف مجانية للسيارات.

يوفر الشاليه ملعب للأطفال. تتوفر خدمة تأجير الدراجات الهوائية وخدمة تأجير السيارات في Stella Makadi Chalets ، بينما يمكن الاستمتاع بركوب الدراجات في مكان قريب.
يقع شاطئ ستيلا ماركادي على بعد 750 متر من مكان الإقامة ، في حين تقع نيو مارينا على بعد 37 كم من مكان الإقامة. يعتبر مطار الغردقة الدولي المطار الأقرب ، حيث يقع على بعد 34 كم من شاليهات ستيلا مكادي ، ويوفر مكان الإقامة خدمة نقل المطار مقابل تكلفة.
ماذا يوجد بالجوار:
عالم خليج مكادي المائي 2.8 ك

مينى ايجيبت بارك 4.5 ك

جانجل اكوا بارك ، 14.1 ك

سينزو مول 14.7 ك

Sand City Hurghada، 14.9 km

الغ',
                'type' => 'property',
                'property_type' => 'apartment',
                'address' => 'Hurghada, Red Sea, Egypt',
                'address_ar' => 'الغردقة، البحر الأحمر، مصر',
                'city' => 'Hurghada',
                'city_ar' => 'الغردقة',
                'country' => 'Egypt',
                'country_ar' => 'مصر',
                'latitude' => 26.992584228515625,
                'longitude' => 33.89638900756836,
                'base_price_cents' => 100000,
                'monthly_price_cents' => 3000000,
                'status' => 'active',
                'bedrooms' => 1,
                'bathrooms' => 1,
                'max_guests' => 2,
                'images' => [
                    'https://static.shared.propertyfinder.eg/media/images/listing/J2KV1RQWGHA2F7KENNDERHC16W/53577f06-b68b-44f7-a88b-00e8a6ce6a82/1312x894.jpg',
                    'https://static.shared.propertyfinder.eg/media/images/listing/J2KV1RQWGHA2F7KENNDERHC16W/a15500a5-2dd1-40d0-a128-d211d2b26a11/1312x894.jpg',
                    'https://static.shared.propertyfinder.eg/media/images/listing/J2KV1RQWGHA2F7KENNDERHC16W/f201dceb-408a-435e-8475-a0ab41d54a79/1312x894.jpg',
                    'https://static.shared.propertyfinder.eg/media/images/listing/J2KV1RQWGHA2F7KENNDERHC16W/bcc322ef-8885-4122-b78f-720de99edba6/1312x894.jpg',
                    'https://static.shared.propertyfinder.eg/media/images/listing/J2KV1RQWGHA2F7KENNDERHC16W/8d317016-7802-4d9d-b595-48833edf8f90/1312x894.jpg',
                    'https://static.shared.propertyfinder.eg/media/images/listing/J2KV1RQWGHA2F7KENNDERHC16W/cbe0694a-df43-40d3-86b5-88ee0b055bf6/1312x894.jpg',
                    'https://static.shared.propertyfinder.eg/media/images/listing/J2KV1RQWGHA2F7KENNDERHC16W/ba352e59-5057-4093-a37d-e226cf988a44/1312x894.jpg',
                    'https://static.shared.propertyfinder.eg/media/images/listing/J2KV1RQWGHA2F7KENNDERHC16W/03a3571d-67ef-46ad-b965-b01f6c73d55f/1312x894.jpg',
                    'https://static.shared.propertyfinder.eg/media/images/listing/J2KV1RQWGHA2F7KENNDERHC16W/8fa8a534-0b3b-4d1c-aa33-c6dfb42df9d0/1312x894.jpg',
                    'https://static.shared.propertyfinder.eg/media/images/listing/J2KV1RQWGHA2F7KENNDERHC16W/d0a2bd2f-dd8c-4ecc-8a55-db99772cadf5/1312x894.jpg'
                ],
                'amenities' => [
                    'تكييف مركزي',
                    'موقف مغطى',
                    'تجهيزات مطبخ',
                    'حديقة خاصة',
                    'مسبح مشترك',
                    'مطل على بحيرات',
                    'نادي صحي مشترك',
                    'صالة رياضة مشتركة',
                    'حوض سباحة للأطفال',
                    'ملاعب رياضية',
                    'مركز طبي',
                    'غرفة تخزين',
                    'نوافذ زجاج مزدوج'
                ]
            ],
            [
                'title' => 'Direct to the lagoon !stand Alone villa big garden',
                'title_ar' => 'فيلا مستقلة بحديقة واسعة عاللاجون لمدة عام',
                'description' => 'Gouna villa for rent 
3 bed rooms 
On the lagoon 
White villas

- The land area about 4000 m2
- 3 bed rooms 
- 3 bathrooms 
-Nanny room 
- Driver room ( hut in the out door ) 
- 2 living room 
- 1 dinning 
- Ketchen 
-On the swimmable Lagoun 
And the sun set mountain Viwe  
- big living room on the roof overlooking the Lagoun - Mountains Viwe and sun set ..  
- House keeping',
                'description_ar' => 'فيلا للإيجار في الجونة
3 غرف نوم
مطلة على البحيرة (لاجون)
منطقة "وايت فيلاز" (White Villas)

- مساحة الأرض: حوالي 4000 متر مربع
- 3 غرف نوم
- 3 حمامات
- غرفة للمربية
- غرفة للسائق (كوخ خارجي)
- غرفتان للمعيشة
- غرفة طعام
- مطبخ
- تقع مباشرة على البحيرة (اللاجون) الصالحة للسباحة
- إطلالة على الجبال ومشهد الغروب
- غرفة معيشة كبيرة في الطابق العلوي (الروف) تطل على البحيرة والجبال ومشهد الغروب
- خدمة تدبير منزلي',
                'type' => 'property',
                'property_type' => 'villa',
                'address' => 'Hurghada, Red Sea, Egypt',
                'address_ar' => 'الغردقة، البحر الأحمر، مصر',
                'city' => 'Hurghada',
                'city_ar' => 'الغردقة',
                'country' => 'Egypt',
                'country_ar' => 'مصر',
                'latitude' => 27.378141403198242,
                'longitude' => 33.67009353637695,
                'base_price_cents' => 500000,
                'monthly_price_cents' => 15000000,
                'status' => 'active',
                'bedrooms' => 3,
                'bathrooms' => 3,
                'max_guests' => 6,
                'images' => [
                    'https://static.shared.propertyfinder.eg/media/images/listing/SNXFP935KYXT2RMM0KDMX04Z78/c94c648b-668e-4e4b-bda2-de3dac30850e/1312x894.jpg',
                    'https://static.shared.propertyfinder.eg/media/images/listing/SNXFP935KYXT2RMM0KDMX04Z78/d7d641a7-f937-4351-9758-059084afaec3/1312x894.jpg',
                    'https://static.shared.propertyfinder.eg/media/images/listing/SNXFP935KYXT2RMM0KDMX04Z78/a62797b7-f2dd-4078-865f-ea3c9e4e5108/1312x894.jpg',
                    'https://static.shared.propertyfinder.eg/media/images/listing/SNXFP935KYXT2RMM0KDMX04Z78/dbfa17e3-0c05-42fc-8b34-a3b232a24068/1312x894.jpg',
                    'https://static.shared.propertyfinder.eg/media/images/listing/SNXFP935KYXT2RMM0KDMX04Z78/860ead3e-248d-4449-853c-ba0a911f0924/1312x894.jpg',
                    'https://static.shared.propertyfinder.eg/media/images/listing/SNXFP935KYXT2RMM0KDMX04Z78/a0d896ef-4047-47f9-8a65-5d485235bc10/1312x894.jpg',
                    'https://static.shared.propertyfinder.eg/media/images/listing/SNXFP935KYXT2RMM0KDMX04Z78/1adc1b12-932c-47d6-9fd5-3b1b080232b0/1312x894.jpg',
                    'https://static.shared.propertyfinder.eg/media/images/listing/SNXFP935KYXT2RMM0KDMX04Z78/b70c1ebe-5dc4-4e51-b5ce-021b079832c8/1312x894.jpg',
                    'https://static.shared.propertyfinder.eg/media/images/listing/SNXFP935KYXT2RMM0KDMX04Z78/7f339ae0-d15e-4d15-b1aa-ac6546bf2c06/1312x894.jpg',
                    'https://static.shared.propertyfinder.eg/media/images/listing/SNXFP935KYXT2RMM0KDMX04Z78/89f38bc5-1f92-486f-8af1-a989e71d92bb/1312x894.jpg'
                ],
                'amenities' => [
                    'تكييف مركزي',
                    'موقف مغطى',
                    'تجهيزات مطبخ',
                    'غرفة خادمة',
                    'حديقة خاصة',
                    'مسبح خاص',
                    'مطل على بحيرات',
                    'نادي صحي مشترك',
                    'صالة رياضة مشتركة',
                    'مركز طبي'
                ]
            ],
            [
                'title' => 'Luxury Brand new villa for long term rent',
                'title_ar' => 'فيلا مفروشة جديدة للايجار للمدد الطويلة بالسنة',
                'description' => 'Stand alone villa in Vearanda resort 
with a private swimming pool and garden  asking rent 1600 ‘ٍ]per month / year                                                                                                                                                                            

Sahl Hasheesh is a masterfully planned gated community located 15 minutes away from Hurghada International Airport. It’s situated on a beautiful bay with almost a Km of sandy beaches and renowned dive spots. The resort is surrounded by untouched desert and majestic mountains. And all the amenities you need and the beach are all a 1-minute walk away.

Veranda-Sahl Hasheesh:-
Veranda consists of 318 residential units composed of an array of studios, one-bedroom, two-bedroom apartments and villas in Southern Hurghada overlooking the Red Sea. Designed with a melange of exotic gardens and surrounded by several lagoons, every homeowner in Veranda will be presented with idyllic views everywhere they look, without compromising their privacy. The white and cream colored Mediterranean themed villas in Veranda blend into the coastal terrain, as red brick roads invite residents to take scenic strolls in village-like passageways.
Verandas homeowners will enjoy their time in the various facilities and amenities offered to them, which include a private beach, a clubhouse, a spa, a fully-functional gym, swimming pools and a clock tower, all these services make veranda more than just a holiday home, they give you a lifestyle and a community you deserve.

Sahl Hasheesh Facilities:
- Water Skiing
- Diving
- Kite Surfing
- Kayaking
- Horseback riding
- Mini Golf Course
- Snorkeling
- Parks
- Beach Club House
- Spa
- Beaches
- Super Market
- Pharmacy',
                'description_ar' => 'فيلا مستقلة في منتجع فيراندا
مع مسبح وحديقة خاصين، إيجارها 1600 دولار
في الشهر لمدة سنة 
سهل حشيش هو مجمع سكني مسوّر مصمم ببراعة، يقع على بُعد 15 دقيقة من مطار الغردقة الدولي. يتميز بموقعه على خليج خلاب بشواطئ رملية تمتد لما يقارب كيلومترًا، ويضم مواقع غوص شهيرة. يحيط بالمنتجع صحراء بكر وجبال شاهقة. جميع الخدمات التي تحتاجها والشاطئ على بُعد دقيقة واحدة سيرًا على الأقدام.

فيراندا - سهل حشيش:
يتكون فيراندا من 318 وحدة سكنية، تشمل استوديوهات وشققًا بغرفة نوم واحدة أو غرفتين وفيلات في جنوب الغردقة، بإطلالة ساحرة على البحر الأحمر. صُممت الفيلا بمزيج من الحدائق الخلابة، وتحيط بها عدة بحيرات، مما يمنح كل ساكن في فيراندا إطلالات بانورامية ساحرة، مع الحفاظ على خصوصيته. تتناغم الفيلات ذات الطابع المتوسطي، بألوانها البيضاء والكريمية، في مشروع فيراندا مع طبيعة الساحل، بينما تدعو الطرق المرصوفة بالطوب الأحمر السكان إلى التنزه في ممرات خلابة تُحاكي أجواء القرى.
سيستمتع سكان فيراندا بأوقاتهم في مختلف المرافق والخدمات المُتاحة لهم، والتي تشمل شاطئًا خاصًا، وناديًا اجتماعيًا، ومنتجعًا صحيًا، وصالة رياضية مُجهزة بالكامل، ومسابح، وبرج ساعة. كل هذه الخدمات تجعل من فيراندا أكثر من مجرد منزل لقضاء العطلات، فهي تُوفر لكم أسلوب حياة ومجتمعًا تستحقونه.

مرافق سهل حشيش:

- التزلج على الماء
- الغوص
- ركوب الأمواج الشراعي
- التجديف
- ركوب الخيل
- ملعب غولف مصغر
- الغطس
- حدائق
- نادي شاطئي
- منتجع صحي
- شواطئ
- سوبر ماركت
- صيدلية',
                'type' => 'property',
                'property_type' => 'villa',
                'address' => 'Hurghada, Red Sea, Egypt',
                'address_ar' => 'الغردقة، البحر الأحمر، مصر',
                'city' => 'Hurghada',
                'city_ar' => 'الغردقة',
                'country' => 'Egypt',
                'country_ar' => 'مصر',
                'latitude' => 27.03673553466797,
                'longitude' => 33.8757438659668,
                'base_price_cents' => 266666,
                'monthly_price_cents' => 8000000,
                'status' => 'active',
                'bedrooms' => 5,
                'bathrooms' => 5,
                'max_guests' => 10,
                'images' => [
                    'https://static.shared.propertyfinder.eg/media/images/listing/N6M8HH8XNZY1TTDNR1W589244M/fac4d518-3cad-459f-bb58-efaec7c9ddf4/1312x894.jpg',
                    'https://static.shared.propertyfinder.eg/media/images/listing/N6M8HH8XNZY1TTDNR1W589244M/5b9d653b-1cff-44ba-ac1b-0a72c3e11324/1312x894.jpg',
                    'https://static.shared.propertyfinder.eg/media/images/listing/N6M8HH8XNZY1TTDNR1W589244M/bc33c68c-f938-40f9-be21-6c6c070d278b/1312x894.jpg',
                    'https://static.shared.propertyfinder.eg/media/images/listing/N6M8HH8XNZY1TTDNR1W589244M/ee6f4474-2dfc-4d6c-b81e-fe45b4c10be6/1312x894.jpg',
                    'https://static.shared.propertyfinder.eg/media/images/listing/N6M8HH8XNZY1TTDNR1W589244M/2320dd49-b897-4a1e-bb9d-1855ffb6ef74/1312x894.jpg',
                    'https://static.shared.propertyfinder.eg/media/images/listing/N6M8HH8XNZY1TTDNR1W589244M/d5d03287-0a06-467d-a79a-85508af4e844/1312x894.jpg',
                    'https://static.shared.propertyfinder.eg/media/images/listing/N6M8HH8XNZY1TTDNR1W589244M/4de89686-5516-41ef-81ab-1c8f3ad1a7e5/1312x894.jpg',
                    'https://static.shared.propertyfinder.eg/media/images/listing/N6M8HH8XNZY1TTDNR1W589244M/794b1739-1580-4718-bf00-b369563accfd/1312x894.jpg',
                    'https://static.shared.propertyfinder.eg/media/images/listing/N6M8HH8XNZY1TTDNR1W589244M/dc11adab-bee7-4e3f-9540-1dcae6684cde/1312x894.jpg',
                    'https://static.shared.propertyfinder.eg/media/images/listing/N6M8HH8XNZY1TTDNR1W589244M/32fa9af4-1059-4456-b182-2be65d5f16e1/1312x894.jpg'
                ],
                'amenities' => [
                    'تكييف مركزي',
                    'موقف مغطى',
                    'تجهيزات مطبخ',
                    'غرفة خادمة',
                    'حديقة خاصة',
                    'مطل على بحيرات',
                    'نادي صحي مشترك',
                    'صالة رياضة مشتركة',
                    'ردهة في المبنى',
                    'مطل على معلم رئيسي',
                    'مركز طبي',
                    'غرفة تخزين',
                    'غرفة غسيل'
                ]
            ],
        ];


        $context = stream_context_create([
            'http' => [
                'header' => "User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/116.0.0.0 Safari/537.36\r\n" .
                            "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8\r\n" .
                            "Accept-Language: en-US,en;q=0.9\r\n" .
                            "Referer: https://www.google.com/\r\n" .
                            "Connection: keep-alive\r\n"
            ]
        ]);

        foreach ($listingsData as $data) {
            $this->info("Creating listing: {$data['title']}");

            $listing = Listing::forceCreate([
                'uuid' => Str::uuid()->toString(),
                'created_by' => $owner->id,
                'title' => $data['title'],
                'title_ar' => $data['title_ar'],
                'description' => $data['description'],
                'description_ar' => $data['description_ar'],
                'type' => $data['type'],
                'property_type' => $data['property_type'],
                'address' => $data['address'],
                'address_ar' => $data['address_ar'] ?? null,
                'city' => $data['city'],
                'city_ar' => $data['city_ar'] ?? null,
                'country' => $data['country'],
                'country_ar' => $data['country_ar'] ?? null,
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude'],
                'base_price_cents' => $data['base_price_cents'],
                'monthly_price_cents' => $data['monthly_price_cents'],
                'status' => $data['status'],
                'bedrooms' => $data['bedrooms'],
                'bathrooms' => $data['bathrooms'],
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
                    'is_primary' => $index === 0 ? 1 : 0
                ];
            }
            if (!empty($mediaData)) {
                $listing->media()->createMany($mediaData);
            }

            $this->processAmenities($listing, $data['amenities'], $amenityService);
            $this->generateReviews($listing);
            $this->info("--- Completed {$data['title']} ---");
        }

        $this->info('Bulk insertion completed!');
    }

    private function processAmenities(Listing $listing, array $amenityNames, AmenityService $amenityService): void
    {
        $customTranslations = [
            'موقف مغطى' => ['name' => 'Covered Parking', 'name_ar' => 'موقف مغطى', 'icon' => 'directions-car'],
            'مفروش' => ['name' => 'Furnished', 'name_ar' => 'مفروش', 'icon' => 'weekend'],
            'تكييف مركزي' => ['name' => 'Central AC', 'name_ar' => 'تكييف مركزي', 'icon' => 'ac-unit'],
            'تجهيزات مطبخ' => ['name' => 'Kitchen Appliances', 'name_ar' => 'تجهيزات مطبخ', 'icon' => 'kitchen'],
            'غرفة خادمة' => ['name' => 'Maids Room', 'name_ar' => 'غرفة خادمة', 'icon' => 'single-bed'],
            'مطل على معلم رئيسي' => ['name' => 'Landmark View', 'name_ar' => 'مطل على معلم رئيسي', 'icon' => 'location-city'],
            'مسبح خاص' => ['name' => 'Private Pool', 'name_ar' => 'مسبح خاص', 'icon' => 'pool'],
            'مسبح مشترك' => ['name' => 'Shared Pool', 'name_ar' => 'مسبح مشترك', 'icon' => 'pool'],
            'نادي صحي مشترك' => ['name' => 'Shared Spa', 'name_ar' => 'نادي صحي مشترك', 'icon' => 'spa'],
            'صالة رياضة مشتركة' => ['name' => 'Shared Gym', 'name_ar' => 'صالة رياضة مشتركة', 'icon' => 'fitness-center'],
            'حديقة خاصة' => ['name' => 'Private Garden', 'name_ar' => 'حديقة خاصة', 'icon' => 'grass'],
            'إطلالة على البحر' => ['name' => 'Sea View', 'name_ar' => 'إطلالة على البحر', 'icon' => 'water'],
            'جاكوزي' => ['name' => 'Jacuzzi', 'name_ar' => 'جاكوزي', 'icon' => 'hot-tub'],
            'صالة رياضة خاصة' => ['name' => 'Private Gym', 'name_ar' => 'صالة رياضة خاصة', 'icon' => 'fitness-center'],
            'مصعد' => ['name' => 'Elevator', 'name_ar' => 'مصعد', 'icon' => 'elevator'],
            'ردهة في المبنى' => ['name' => 'Lobby in Building', 'name_ar' => 'ردهة في المبنى', 'icon' => 'meeting_room'],
            'مطل على بحيرات' => ['name' => 'View of Lakes', 'name_ar' => 'مطل على بحيرات', 'icon' => 'water'],
            'نوافذ زجاج مزدوج' => ['name' => 'Double Glazed Windows', 'name_ar' => 'نوافذ زجاج مزدوج', 'icon' => 'window'],
        ];

        $amenityIds = [];
        foreach ($amenityNames as $scrapedName) {
            if (empty(trim($scrapedName))) continue;
            
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
                }
                $amenityIds[] = $existing->id;
            } else {
                $matched = $amenityService->matchOrCreate($scrapedName, 'property');
                $amenityIds[] = $matched->id;
            }
        }

        if (!empty($amenityIds)) {
            $listing->amenities()->sync(array_unique($amenityIds));
        }
    }

    private function generateReviews(Listing $listing): void
    {
        $egyptianNames = ['Ahmed Tarek', 'Mahmoud Hassan', 'Mostafa Kamal', 'Nourhan Adel', 'Youssef Ibrahim', 'Salma Ahmed', 'Kareem Nabil', 'Omar Farouk', 'Heba Samir', 'Rania Youssef'];
        $egyptianComments = [
            'الفيو مريح للأعصاب جدا',
            'بصراحة المكان روعة وموقعه يجنن، والفرش راقي',
            'Very nice place and clean, we enjoyed our stay.',
            'كل حاجة كانت بيرفكت، العمارة هادية والموقع ممتاز',
            'تجربة ممتازة وان شاء الله تتكرر تاني قريب',
            'المكان تحفة بالظبط زي الصور وأحسن كمان',
            'نضيف جداً وكل الخدمات متوفرة حواليه',
            'الفرش جديد والمكان هادي جداً مناسب للعائلات',
            'أحسن مكان سكنت فيه في الساحل، كل حاجة قريبة',
            'المضيف كان محترم جداً والمكان يفتح النفس'
        ];

        $khaleejiNames = ['Faisal Al-Dosari', 'Khaled Al-Qahtani', 'Nouf Al-Mutairi', 'Saud Al-Otaibi', 'Fatima Al-Jaber', 'Mohammed Al-Mansoori', 'Bader Al-Rashidi', 'Hessa Al-Kandari', 'Ali Al-Marzouqi', 'Sara Al-Fayed'];
        $khaleejiComments = [
            'المكان وايد حلو ومرتب، الشقة واسعة ومريحة يعطيكم العافية',
            'ما شاء الله المكان يفتح النفس وكل شي متوفر',
            'المكان نظيف ووايد روعة، الاثاث فخم انصح فيه بشدة',
            'تجربة استثنائية، الفيلا وايد نظيفة والتكييف بارد ممتازة',
            'الموقع استراتيجي وكل شي قريب منك، يعطيهم العافية',
            'أفضل مكان سكنت فيه، هدوء وراحة وتعامل راقي',
            'الفيو خيالي والمكان نظيف جداً، انصح العوائل فيه',
            'كل الشكر على حسن الاستقبال، المكان يستاهل 10 نجوم',
            'الاثاث عصري ومريح جدا، حيل استانسنا بالسكن',
            'المكان روعة وما عليه كلام، ان شاء الله لنا زيارة ثانية'
        ];

        $foreignNames = ['Thomas Muller', 'Sophie Martin', 'James Anderson', 'Elena Rodriguez', "Liam O'Connor", 'Anna Schmidt', 'Oliver Brown', 'Emma Wilson', 'Lucas Silva', 'Maria Garcia'];
        $foreignComments = [
            'Absolutely loved our stay here! The compound is very secure.',
            'Great place for a business trip. The luxury furniture and wifi were amazing.',
            'Place was spotless and exactly like the pictures.',
            'Highly recommend! Fast check-in and beautiful views.',
            'The amenities were top-notch. Will definitely come back.',
            'A very peaceful environment, perfectly clean and well equipped.',
            'Stunning location and the host was incredibly helpful.',
            'Five stars all the way. Beautifully decorated and very comfortable.',
            'We had a wonderful vacation, the property exceeded our expectations.',
            'Perfect location! Walking distance to everything we needed.'
        ];

        // Shuffle arrays to prevent repeating within the same listing
        shuffle($egyptianNames);
        shuffle($egyptianComments);
        shuffle($khaleejiNames);
        shuffle($khaleejiComments);
        shuffle($foreignNames);
        shuffle($foreignComments);

        $numReviews = rand(5, 8);
        $totalRating = 0;

        for ($i = 0; $i < $numReviews; $i++) {
            $rating = rand(4, 5);
            $totalRating += $rating;
            
            $rand = rand(1, 100);
            if ($rand <= 40) {
                $name = array_pop($egyptianNames);
                $comment = array_pop($egyptianComments);
            } elseif ($rand <= 70) {
                $name = array_pop($khaleejiNames);
                $comment = array_pop($khaleejiComments);
            } else {
                $name = array_pop($foreignNames);
                $comment = array_pop($foreignComments);
            }
            
            \App\Models\Review::create([
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
    }
}
