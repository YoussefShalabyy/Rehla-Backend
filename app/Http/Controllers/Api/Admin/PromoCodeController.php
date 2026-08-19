<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PromoCode\StorePromoCodeRequest;
use App\Http\Requests\Admin\PromoCode\UpdatePromoCodeRequest;
use App\Models\PromoCode;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PromoCodeController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = PromoCode::query();
        
        // Sorting
        $sortField = $request->input('sort', 'created_at');
        $sortDir = $request->input('dir', 'desc');
        $query->orderBy($sortField, $sortDir);

        $codes = $query->paginate(20);

        return response()->json([
            'success' => true,
            'message' => 'Promo codes retrieved successfully.',
            'data'    => $codes->items(),
            'meta'    => [
                'pagination' => [
                    'current_page' => $codes->currentPage(),
                    'last_page'    => $codes->lastPage(),
                    'per_page'     => $codes->perPage(),
                    'total'        => $codes->total(),
                ],
            ],
            'errors'  => null,
        ]);
    }

    public function store(StorePromoCodeRequest $request): JsonResponse
    {
        $code = PromoCode::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Promo code created successfully.',
            'data'    => $code,
            'meta'    => null,
            'errors'  => null,
        ], 201);
    }

    public function show(PromoCode $promoCode): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Promo code retrieved successfully.',
            'data'    => $promoCode,
            'meta'    => null,
            'errors'  => null,
        ]);
    }

    public function update(UpdatePromoCodeRequest $request, PromoCode $promoCode): JsonResponse
    {
        $promoCode->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Promo code updated successfully.',
            'data'    => $promoCode->fresh(),
            'meta'    => null,
            'errors'  => null,
        ]);
    }

    public function destroy(PromoCode $promoCode): JsonResponse
    {
        $promoCode->delete();

        return response()->json([
            'success' => true,
            'message' => 'Promo code deleted successfully.',
            'data'    => null,
            'meta'    => null,
            'errors'  => null,
        ]);
    }
}
