<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes — Rehla
|--------------------------------------------------------------------------
| All routes here are prefixed with /api/v1/ automatically (set in bootstrap/app.php).
|
| Route groups:
|   Public  — no auth required
|   Auth    — require auth:sanctum middleware
|   Admin   — require auth:sanctum + admin role middleware (listings are admin-only)
*/

// ── Health Check ─────────────────────────────────────────────────────────────
Route::get('/health', function () {
    return response()->json([
        'success' => true,
        'message' => 'VistaStay API is running.',
        'data'    => ['version' => 'v1'],
    ]);
});

// ── Public Auth Routes ────────────────────────────────────────────────────────
Route::middleware('throttle:auth')->prefix('auth')->group(function () {
    Route::post('/register', [\App\Http\Controllers\Api\Auth\AuthController::class, 'register']);
    Route::post('/login',    [\App\Http\Controllers\Api\Auth\AuthController::class, 'login']);
    Route::post('/google',   [\App\Http\Controllers\Api\Auth\AuthController::class, 'google']);
    Route::post('/apple',    [\App\Http\Controllers\Api\Auth\AuthController::class, 'apple']);
});

// ── Webhook Routes (No Auth required) ────────────────────────────────────────
Route::middleware('throttle:webhook')->prefix('webhooks')->group(function () {
    Route::post('/paymob', [\App\Http\Controllers\Api\Webhook\PaymobWebhookController::class, 'handle']);
    Route::post('/easykash', [\App\Http\Controllers\Api\Webhook\EasyKashWebhookController::class, 'handle']);
});

// ── Public Settings & Config ──────────────────────────────────────────────────
Route::get('/platform-settings', function () {
    $settings = \Illuminate\Support\Facades\DB::table('platform_settings')
        ->whereIn('key', ['whatsapp_support'])
        ->pluck('value', 'key')
        ->toArray();
    
    if (!isset($settings['whatsapp_support'])) {
        $settings['whatsapp_support'] = '+201000000000';
    }

    return response()->json([
        'success' => true,
        'message' => 'Platform settings retrieved.',
        'data'    => $settings,
        'meta'    => null,
        'errors'  => null,
    ]);
});

Route::get('/active-categories', [\App\Http\Controllers\Api\Customer\ListingController::class, 'activeCategories']);

// ── Public Listing Routes ─────────────────────────────────────────────────────
Route::prefix('listings')->group(function () {
    Route::get('/',                    [\App\Http\Controllers\Api\Customer\ListingController::class, 'index']);
    Route::get('/{uuid}',              [\App\Http\Controllers\Api\Customer\ListingController::class, 'show']);
    Route::get('/{uuid}/availability', [\App\Http\Controllers\Api\Customer\BookingController::class, 'availability']);
    Route::get('/{uuid}/reviews',      [\App\Http\Controllers\Api\Customer\ReviewController::class, 'index']);
});

// ── Public Destination Routes ─────────────────────────────────────────────────
Route::prefix('destinations')->group(function () {
    Route::get('/suggested', [\App\Http\Controllers\Api\Customer\DestinationController::class, 'suggested']);
});

// ── Public Leads Routes ───────────────────────────────────────────────────────
Route::prefix('leads')->group(function () {
    Route::post('/', [\App\Http\Controllers\Api\Customer\LeadController::class, 'store']);
});

// ── Protected Routes (auth:sanctum) ──────────────────────────────────────────
Route::middleware('auth:sanctum')->group(function () {

    // ── Auth Management ───────────────────────────────────────────────────────
    Route::prefix('auth')->group(function () {
        Route::get('/me',        [\App\Http\Controllers\Api\Auth\AuthController::class, 'me']);
        Route::post('/profile',  [\App\Http\Controllers\Api\Auth\AuthController::class, 'updateProfile']);
        Route::post('/push-token', [\App\Http\Controllers\Api\Auth\AuthController::class, 'updatePushToken']);
        Route::delete('/delete', [\App\Http\Controllers\Api\Auth\AuthController::class, 'deleteAccount']);
        Route::post('/logout',   [\App\Http\Controllers\Api\Auth\AuthController::class, 'logout']);
    });

    // ── Admin Routes ──────────────────────────────────────────────────────────
    Route::middleware('role:admin')->group(function () {

        // Admin Dashboard
        Route::prefix('admin/dashboard')->group(function () {
            Route::get('/stats', [\App\Http\Controllers\Api\Admin\DashboardController::class, 'stats']);
        });

        // Admin Notifications
        Route::prefix('admin/notifications')->group(function () {
            Route::post('/broadcast', [\App\Http\Controllers\Api\Admin\AdminNotificationController::class, 'broadcast']);
        });

        // Admin Listings — full CRUD + approve/reject + media + availability
        Route::prefix('admin/listings')->middleware('admin.permission:manage_listings')->group(function () {
            Route::get('/',                              [\App\Http\Controllers\Api\Admin\ListingController::class, 'index']);
            Route::post('/',                             [\App\Http\Controllers\Api\Admin\ListingController::class, 'store']);
            Route::get('/{uuid}',                        [\App\Http\Controllers\Api\Admin\ListingController::class, 'show']);
            Route::put('/{uuid}',                        [\App\Http\Controllers\Api\Admin\ListingController::class, 'update']);
            Route::delete('/{uuid}',                     [\App\Http\Controllers\Api\Admin\ListingController::class, 'destroy']);
            Route::put('/{uuid}/status',                 [\App\Http\Controllers\Api\Admin\ListingController::class, 'updateStatus']);
            // Media
            Route::post('/{uuid}/media',                 [\App\Http\Controllers\Api\Admin\MediaController::class, 'upload']);
            Route::put('/{uuid}/media/reorder',          [\App\Http\Controllers\Api\Admin\MediaController::class, 'reorder']);
            // Availability
            Route::post('/{uuid}/availability/block',    [\App\Http\Controllers\Api\Admin\AvailabilityController::class, 'block']);
            Route::delete('/{uuid}/availability/{id}',   [\App\Http\Controllers\Api\Admin\AvailabilityController::class, 'unblock']);
        });

        // Admin Media (global — delete / set primary by media uuid)
        Route::prefix('admin/media')->middleware('admin.permission:manage_listings')->group(function () {
            Route::delete('/{uuid}',         [\App\Http\Controllers\Api\Admin\MediaController::class, 'destroy']);
            Route::put('/{uuid}/primary',    [\App\Http\Controllers\Api\Admin\MediaController::class, 'setPrimary']);
        });

        // Admin Generic Uploads
        Route::post('admin/upload/image', [\App\Http\Controllers\Api\Admin\UploadController::class, 'uploadImage'])
            ->middleware('admin.permission:manage_settings');

        // Admin Users
        Route::prefix('admin/users')->middleware('admin.permission:manage_users')->group(function () {
            Route::get('/',              [\App\Http\Controllers\Api\Admin\UserController::class, 'index']);
            Route::get('/{uuid}',        [\App\Http\Controllers\Api\Admin\UserController::class, 'show']);
            Route::post('/',             [\App\Http\Controllers\Api\Admin\UserController::class, 'store']);
            Route::put('/{uuid}/status', [\App\Http\Controllers\Api\Admin\UserController::class, 'updateStatus']);
            Route::put('/{uuid}/permissions', [\App\Http\Controllers\Api\Admin\UserController::class, 'updatePermissions']);
            Route::delete('/{uuid}',     [\App\Http\Controllers\Api\Admin\UserController::class, 'destroy']);
            Route::post('/{uuid}/wallet/add-balance', [\App\Http\Controllers\Api\Admin\UserController::class, 'addBalance']);
        });

        // Admin Home Sections
        Route::prefix('admin/home-sections')->middleware('admin.permission:manage_listings')->group(function () {
            Route::get('/', [\App\Http\Controllers\Api\Admin\HomeSectionController::class, 'index']);
            Route::get('/{key}/listings', [\App\Http\Controllers\Api\Admin\HomeSectionController::class, 'show']);
            Route::post('/{key}/sync', [\App\Http\Controllers\Api\Admin\HomeSectionController::class, 'sync']);
        });

        // Admin Bookings
        Route::prefix('admin/bookings')->middleware('admin.permission:manage_bookings')->group(function () {
            Route::get('/',               [\App\Http\Controllers\Api\Admin\BookingController::class, 'index']);
            Route::put('/{uuid}/status',  [\App\Http\Controllers\Api\Admin\BookingController::class, 'updateStatus']);
        });

        // Admin Reviews
        Route::prefix('admin/reviews')->middleware('admin.permission:manage_reviews')->group(function () {
            Route::get('/',               [\App\Http\Controllers\Api\Admin\ReviewController::class, 'index']);
            Route::post('/',              [\App\Http\Controllers\Api\Admin\ReviewController::class, 'store']);
            Route::put('/{uuid}',         [\App\Http\Controllers\Api\Admin\ReviewController::class, 'update']);
            Route::put('/{uuid}/moderate',[\App\Http\Controllers\Api\Admin\ReviewController::class, 'moderate']);
            Route::post('/{uuid}/reply',  [\App\Http\Controllers\Api\Admin\ReviewController::class, 'reply']);
            Route::delete('/{uuid}',      [\App\Http\Controllers\Api\Admin\ReviewController::class, 'destroy']);
        });

        // Admin Settings
        Route::prefix('admin/settings')->group(function () {
            Route::get('/',      [\App\Http\Controllers\Api\Admin\SettingsController::class, 'index']);
            Route::put('/{key}', [\App\Http\Controllers\Api\Admin\SettingsController::class, 'update']);
        });

        // Admin Amenities
        Route::prefix('admin/amenities')->group(function () {
            Route::get('/', [\App\Http\Controllers\Api\Admin\AmenityController::class, 'index']);
        });

        // Admin Destinations
        Route::prefix('admin/destinations')->middleware('admin.permission:manage_destinations')->group(function () {
            Route::get('/',              [\App\Http\Controllers\Api\Admin\DestinationController::class, 'index']);
            Route::post('/',             [\App\Http\Controllers\Api\Admin\DestinationController::class, 'store']);
            Route::put('/{uuid}',        [\App\Http\Controllers\Api\Admin\DestinationController::class, 'update']);
            Route::delete('/{uuid}',     [\App\Http\Controllers\Api\Admin\DestinationController::class, 'destroy']);
        });

        // Admin Leads
        Route::prefix('admin/leads')->middleware('admin.permission:manage_leads')->group(function () {
            Route::get('/', [\App\Http\Controllers\Api\Admin\LeadController::class, 'index']);
            Route::post('/mark-read', [\App\Http\Controllers\Api\Admin\LeadController::class, 'markRead']);
            Route::put('/{uuid}/status', [\App\Http\Controllers\Api\Admin\LeadController::class, 'updateStatus']);
        });

        // Admin Amenities (newly added)
        Route::apiResource('amenities', \App\Http\Controllers\Api\Admin\AmenityController::class);
        
        // Settings
        
        // Promo Codes
        Route::middleware('admin.permission:manage_promo_codes')->group(function () {
            Route::apiResource('promo-codes', \App\Http\Controllers\Api\Admin\PromoCodeController::class);
        });
    });

    // ── Customer Notifications ────────────────────────────────────────────────
    Route::prefix('notifications')->group(function () {
        Route::get('/',          [\App\Http\Controllers\Api\Customer\NotificationController::class, 'index']);
        Route::get('/unread',    [\App\Http\Controllers\Api\Customer\NotificationController::class, 'unreadCount']);
        Route::put('/read-all',  [\App\Http\Controllers\Api\Customer\NotificationController::class, 'markAllAsRead']);
        Route::put('/{id}/read', [\App\Http\Controllers\Api\Customer\NotificationController::class, 'markAsRead']);
    });

    // ── Customer Bookings ─────────────────────────────────────────────────────
    Route::prefix('bookings')->group(function () {
        Route::get('/',               [\App\Http\Controllers\Api\Customer\BookingController::class, 'index']);
        Route::post('/',              [\App\Http\Controllers\Api\Customer\BookingController::class, 'store']);
        Route::get('/{uuid}',         [\App\Http\Controllers\Api\Customer\BookingController::class, 'show']);
        Route::post('/{uuid}/cancel', [\App\Http\Controllers\Api\Customer\BookingController::class, 'cancel']);
        Route::post('/{uuid}/reschedule', [\App\Http\Controllers\Api\Customer\BookingController::class, 'reschedule']);
    });

    // ── Customer Payments ─────────────────────────────────────────────────────
    Route::middleware('throttle:payment')->prefix('payments')->group(function () {
        Route::post('/',          [\App\Http\Controllers\Api\Customer\PaymentController::class, 'initiate']);
        Route::get('/history',    [\App\Http\Controllers\Api\Customer\PaymentController::class, 'history']);
        Route::get('/{uuid}',     [\App\Http\Controllers\Api\Customer\PaymentController::class, 'show']);
    });

    // ── Customer Promo Codes ──────────────────────────────────────────────────
    Route::prefix('promo-codes')->group(function () {
        Route::post('/validate', \App\Http\Controllers\Api\Customer\PromoCodeValidationController::class);
    });

    // ── Customer Reviews ──────────────────────────────────────────────────────
    Route::prefix('reviews')->group(function () {
        Route::get('/pending', [\App\Http\Controllers\Api\Customer\ReviewController::class, 'pending']);
        Route::post('/',       [\App\Http\Controllers\Api\Customer\ReviewController::class, 'store']);
    });

    // ── Customer Wishlist ─────────────────────────────────────────────────────
    Route::prefix('wishlists')->group(function () {
        Route::get('/',              [\App\Http\Controllers\Api\Customer\WishlistController::class, 'index']);
        Route::post('/{listingUuid}',[\App\Http\Controllers\Api\Customer\WishlistController::class, 'toggle']);
    });

    // ── Customer Wallet ───────────────────────────────────────────────────────
    Route::prefix('wallet')->group(function () {
        Route::get('/', [\App\Http\Controllers\Api\Customer\WalletController::class, 'getWallet']);
    });
});
