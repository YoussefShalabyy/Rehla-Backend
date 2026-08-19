<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\ValidatePromoCodeRequest;
use App\Models\Listing;
use App\Models\PromoCode;
use App\Services\PromoCode\PromoCodeService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PromoCodeValidationController extends Controller
{
    public function __construct(
        private readonly PromoCodeService $promoCodeService
    ) {
    }

    public function __invoke(ValidatePromoCodeRequest $request): JsonResponse
    {
        $code = $request->validated('code');
        $listingUuid = $request->validated('listing_uuid');
        $checkoutCents = (int) $request->validated('checkout_cents');
        $checkInDate = $request->validated('check_in_date');
        $checkOutDate = $request->validated('check_out_date');

        $promoCode = PromoCode::where('code', $code)->first();

        if (! $promoCode) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid promo code.',
                'data'    => null,
                'meta'    => null,
                'errors'  => null,
            ], 422);
        }

        $listing = Listing::where('uuid', $listingUuid)->firstOrFail();

        try {
            $this->promoCodeService->validate($promoCode, $listing, $request->user(), $checkoutCents, $checkInDate, $checkOutDate);
        } catch (HttpException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data'    => null,
                'meta'    => null,
                'errors'  => null,
            ], $e->getStatusCode());
        }

        $discountAmountCents = $this->promoCodeService->calculateDiscount($promoCode, $checkoutCents);

        return response()->json([
            'success' => true,
            'message' => 'Promo code is valid.',
            'data'    => [
                'discount_amount_cents' => $discountAmountCents,
                'code'                  => $promoCode->code,
                'discount_type'         => $promoCode->discount_type,
                'original_amount'       => $promoCode->discount_amount,
            ],
            'meta'    => null,
            'errors'  => null,
        ]);
    }
}
