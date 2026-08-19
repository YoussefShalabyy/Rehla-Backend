<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendPushNotification;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminNotificationController extends Controller
{
    /**
     * Broadcast a push notification to all users who have an expo push token.
     */
    public function broadcast(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body'  => 'required|string',
        ]);

        $title = $validated['title'];
        $body = $validated['body'];

        // Chunk users to prevent memory exhaustion and handle large broadcasts
        User::whereNotNull('expo_push_token')->chunk(100, function ($users) use ($title, $body) {
            $tokens = $users->pluck('expo_push_token')->toArray();
            if (!empty($tokens)) {
                SendPushNotification::dispatch($tokens, $title, $body);
            }
        });

        return response()->json([
            'success' => true,
            'message' => 'Notification broadcast queued successfully.',
            'data'    => null,
            'meta'    => null,
            'errors'  => null,
        ]);
    }
}
