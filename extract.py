import os
import json
import re

urls = [
    "https://www.propertyfinder.eg/ar/plp/rent/apartment-for-rent-north-coast-markaz-al-hamam-mohandseen-gameyien-92691083.html",
    "https://www.propertyfinder.eg/ar/plp/rent/apartment-for-rent-north-coast-sidi-abdel-rahman-marassi-7451371.html",
    "https://www.propertyfinder.eg/ar/plp/rent/apartment-for-rent-north-coast-al-alamein-latin-district-98281228.html",
    "https://www.propertyfinder.eg/ar/plp/rent/apartment-for-rent-north-coast-al-alamein-new-alamein-city-the-gate-towers-98836543.html",
    "https://www.propertyfinder.eg/ar/plp/rent/apartment-for-rent-north-coast-al-alamein-north-edge-towers-101766864.html"
]

def clean_text(text):
    if not text:
        return ""
    text = str(text)
    text = text.replace("'", "\\'")
    text = text.replace('"', '\\"')
    text = text.replace('\n', '\\n')
    text = text.replace('\r', '')
    return text.strip()

output = "[\n"

for i, url in enumerate(urls):
    cmd = f'curl -s -A "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/116.0.0.0 Safari/537.36" -H "Referer: https://www.propertyfinder.eg/" "{url}"'
    html = os.popen(cmd).read()
    match = re.search(r'<script id="__NEXT_DATA__" type="application/json">(.*?)</script>', html)
    
    if match:
        try:
            data = json.loads(match.group(1))
            prop = data['props']['pageProps']['initialState']['property']
        except KeyError:
            try:
                prop = data['props']['pageProps']['property']
            except KeyError:
                print(f"Failed to find property data for {url}")
                continue
                
        title = prop.get('title', f"Property {i}")
        desc = prop.get('description', '')
        price_dict = prop.get('price', {})
        price = price_dict.get('value', 20000)
        
        monthly_price = int(price) * 100
        base_price = int(int(price) / 30) * 100 # estimate per day
        
        location = prop.get('location', {})
        address = location.get('full_name', '')
        lat = location.get('coordinates', {}).get('lat', 30.0)
        lon = location.get('coordinates', {}).get('lon', 31.0)
        
        bedrooms = prop.get('bedrooms', 1)
        if bedrooms == 'studio' or bedrooms == 'ستوديو':
            bedrooms = 1
        else:
            try:
                bedrooms = int(str(bedrooms).replace('+', ''))
            except:
                bedrooms = 1
                
        bathrooms = prop.get('bathrooms', 1)
        try:
            bathrooms = int(str(bathrooms).replace('+', ''))
        except:
            bathrooms = 1
            
        amenities = prop.get('amenities', [])
        amenities_list = "', '".join([a for a in amenities])
        
        images = [img['default'] for img in prop.get('images', [])]
        clean_images = [img.split('?')[0] for img in images]
        images_str = "',\n                    '".join(clean_images[:10])
        
        output += f"""
            [
                'title' => '{clean_text(title)}',
                'title_ar' => '{clean_text(title)}',
                'description' => "{clean_text(desc)}",
                'description_ar' => "{clean_text(desc)}",
                'type' => 'property',
                'property_type' => 'apartment',
                'address' => '{clean_text(address)}',
                'city' => 'North Coast',
                'country' => 'Egypt',
                'latitude' => {lat},
                'longitude' => {lon},
                'base_price_cents' => {base_price},
                'monthly_price_cents' => {monthly_price},
                'status' => 'active',
                'bedrooms' => {bedrooms},
                'bathrooms' => {bathrooms},
                'max_guests' => {bedrooms * 2},
                'images' => [
                    '{images_str}'
                ],
                'amenities' => [
                    '{amenities_list}'
                ]
            ],
        """
    else:
        print(f"Could not find JSON-LD in {url}")

output += "\n]"
with open("/tmp/output.php", "w") as f:
    f.write(output)
print("Done")
