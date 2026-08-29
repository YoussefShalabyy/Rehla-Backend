<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Amenity;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\Listing\AmenityResource;

class AmenityController extends Controller
{
    public function index(): JsonResponse
    {
        $amenities = Amenity::all();
        
        return $this->success(AmenityResource::collection($amenities), 'Amenities retrieved successfully.');
    }
}
