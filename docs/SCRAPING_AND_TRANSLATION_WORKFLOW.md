# AI Scraping & Translation Workflow

This document outlines the strict, established workflow for fetching listings from third-party sites (like PropertyFinder), downloading their media, translating their text into a professional tone, matching their amenities, and inserting them into the Rehla database. 

**Any AI Agent working on expanding or updating the scraper scripts MUST read and follow these steps exactly.**

## 1. Extracting the Data
- Fetch the URL provided by the user using a web scraping or page fetching tool.
- Locate the structured JSON-LD data (usually `application/ld+json`) in the head of the document.
- Parse the JSON to extract:
  - Original Title and Description (usually in Arabic or English)
  - Location and Coordinates (latitude/longitude)
  - Price (multiply by 100 to convert to `base_price_cents` or `monthly_price_cents`)
  - Property specs (bedrooms, bathrooms, area, type)
  - A list of Amenities
  - A list of Images

## 2. Professional Content Rewriting (Mandatory)
The raw scraped text is often unstructured, unprofessional, or contains unwanted symbols. 
**Rule:** You must completely rewrite the title and description to be highly professional. 
- You MUST create **two versions** of the title and description: one in English (`title`, `description`) and one in Arabic (`title_ar`, `description_ar`).
- Do **not** use AI-like formatting (such as `**` for bolding or raw asterisks). Use standard line breaks and hyphens (`-`) for lists.
- Maintain a luxurious, professional tone suitable for a high-end booking app.

## 3. Handling Amenities
Amenities must be stored in both English (`name`) and Arabic (`name_ar`).
- Compare the scraped amenities against the `amenities` table in the database.
- If an amenity exists (by matching either the English or Arabic name), use its existing ID.
- If an amenity does NOT exist, create it on the fly:
  - Generate a professional English `name`.
  - Generate an accurate Arabic `name_ar`.
  - Assign a relevant Material icon identifier (e.g., `pool`, `ac-unit`, `directions-car`).
  - Set the type to `property`.
  - Save to the DB and use its new ID.

## 4. Handling Media
- Extract all image URLs from the listing.
- If using `ScrapeTestCommand.php`, provide them in the `media()->createMany([])` array.
- **CRITICAL:** You must explicitly set `'is_primary' => true` for the FIRST image in the array. If you fail to do this, the listing will not have a cover image on the App's home screen.
- Never use relative URLs for images; always use absolute Cloudinary/S3 URLs.
- Never soft-delete media. If a replacement is needed, physically delete via interface or ignore.

## 5. Review Generation Rules
When scraping new properties, you must attach realistic fake reviews so the UI is properly populated:
- **Quantity**: Generate a random number of reviews (e.g., between 2 and 10) for every listing.
- **Demographics & Language**: Ensure reviewers and comments match this distribution:
  - **50% Egyptian**: Use casual Egyptian names (e.g., "Ahmed Tarek", "Nourhan Adel"). Comments should be in natural, casual Egyptian Arabic (e.g., "المكان تحفة بجد", "الفيو يجنن") or casual English.
  - **30% Khaleeji (Gulf)**: Use Khaleeji names (e.g., "Faisal Al-Dosari", "Nouf Al-Mutairi"). Comments should be in Gulf dialect (e.g., "المكان وايد حلو", "يصلح للعوائل الخليجية").
  - **20% Foreign**: Use Western/International names (e.g., "Thomas Muller", "Sophie Martin"). Comments should be in natural English (e.g., "Spotless place, highly recommended").
- **Ratings**: Randomly assign 4 or 5 stars to ensure a high average rating.
- **Implementation Note**: Do NOT use LLM generation APIs during the command to generate these, as it slows down scraping and often sounds artificial. Hardcode realistic arrays for each demographic and pick randomly from them. Leave `reviewer_id` and `booking_id` as `null`.
- **Aggregates**: After inserting the reviews, you MUST calculate the average rating and total count, and update the `average_rating` and `total_reviews` columns on the `listings` table.

## 6. Execution via Artisan
Implement this logic within an Artisan command (e.g., `app/Console/Commands/ScrapeTestCommand.php`). 
Always ensure the command creates a user (or uses an existing one) to attach as the `created_by` owner of the listing.

## 7. Car Specific Scraping Logic (Vehicles)
When scraping vehicles from sites like MalekCars or ContactCars, follow these additional rules for generating and inferring data to fit our rental model:

### 7.1 Pricing Logic (Sale to Rental)
Car marketplaces usually list the **Total Sale Price** instead of rental rates. 
- **Rule:** If you scrape a sale price, generate a logical daily rental price by taking **0.25% (0.0025)** of the total car value. (e.g., A car sold for 820,000 EGP translates to ~2,000 EGP/day). 
- Calculate weekly and monthly discounts based on the derived daily base price.

### 7.2 Coordinates and Location
- **Rule:** The App strictly requires exact `latitude` and `longitude` for the "View on Map" feature. 
- If the scraped HTML does not provide exact map coordinates (only textual like "القاهرة / المقطم"), you **must** use logical geocoding to generate standard coordinates for that neighborhood (e.g., Mokattam = `30.0285, 31.3148`).

### 7.3 Category Mapping
- Map the scraped car body type (SUV, Sedan, Coupe) strictly to our internal `category` ENUM: `suv`, `luxury`, `daily`, `sports`, `economy`.
- If the site explicitly says "SUV", save the category as `suv`. If not provided, infer the category based on the Make and Model.

### 7.4 Car Amenities & Icons
- The App uses `@expo/vector-icons` (MaterialCommunityIcons, Ionicons, MaterialIcons).
- **Rule:** Ensure car amenities are saved in the DB with proper **Arabic Translations** and valid **Material Icon names** (e.g., `Air Conditioning` -> `تكييف هواء` / `ac_unit`).
- Avoid using `Backup Camera`; use **Rear Camera** (`كاميرا خلفية`) instead.
- If scraping generic specs (e.g., "Bluetooth", "ABS Brakes", "Cruise Control", "Keyless Entry"), map them smoothly into the `amenities` table using `type => 'car'`.
