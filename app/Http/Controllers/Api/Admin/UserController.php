<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Admin;

use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\UserAdminResource;
use App\Models\User;
use App\Models\Wallet;
use App\Services\Admin\AdminDashboardService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function __construct(private AdminDashboardService $service)
    {
    }

    /**
     * List all users with filters.
     */
    public function index(Request $request): JsonResponse
    {
        $query = User::withCount(['bookings']);

        if ($request->filled('role')) {
            $query->where('role', $request->query('role'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->query('status'));
        }

        $users = $query->latest()->paginate(20);

        return $this->paginated($users, UserAdminResource::class);
    }

    /**
     * Show a single user's detail including booking history.
     */
    public function show(string $uuid): JsonResponse
    {
        $user = User::where('uuid', $uuid)
            ->withCount(['bookings'])
            ->with(['bookings' => fn($q) => $q->latest()->take(10)->with('listing:id,uuid,title')])
            ->firstOrFail();

        return $this->success(new UserAdminResource($user));
    }

    /**
     * Create a new admin user (only accessible by existing admins).
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'       => ['nullable', 'email', 'unique:users,email'],
            'password'    => ['required', 'string', 'min:8'],
            'phone'       => ['required', 'string', 'max:20', 'unique:users,phone'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['string'],
        ]);

        $user = User::create([
            'uuid'        => (string) Str::uuid(),
            'name'        => $validated['name'],
            'email'       => $validated['email'] ?? null,
            'phone'       => $validated['phone'],
            'password'    => Hash::make($validated['password']),
            'role'        => UserRole::Admin,
            'status'      => UserStatus::Active,
            'permissions' => $validated['permissions'] ?? [],
        ]);

        // Create wallet for admin
        Wallet::create([
            'uuid'          => (string) Str::uuid(),
            'user_id'       => $user->id,
            'balance_cents' => 0,
        ]);

        return $this->created(new UserAdminResource($user), 'Admin user created successfully.');
    }

    /**
     * Update user status (active / suspended).
     */
    public function updateStatus(Request $request, string $uuid): JsonResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'string', 'in:active,suspended'],
        ]);

        $user = User::where('uuid', $uuid)->firstOrFail();
        $user = $this->service->updateUserStatus($user, $validated['status']);

        return $this->success(new UserAdminResource($user), 'User status updated successfully.');
    }

    /**
     * Hard delete a user (admin only — use with care).
     */
    public function destroy(string $uuid): JsonResponse
    {
        $user = User::where('uuid', $uuid)->firstOrFail();

        // Revoke all tokens first
        $user->tokens()->delete();
        $user->forceDelete();

        return $this->success(null, 'User permanently deleted.');
    }

    /**
     * Add balance to a user's wallet.
     */
    public function addBalance(Request $request, string $uuid): JsonResponse
    {
        $validated = $request->validate([
            'amount_cents' => ['required', 'integer', 'min:1'],
            'reason'       => ['required', 'string', 'max:255'],
        ]);

        $user = User::where('uuid', $uuid)->firstOrFail();

        // Ensure user has a wallet
        $wallet = $user->wallet()->firstOrCreate(
            ['user_id' => $user->id],
            ['uuid' => (string) Str::uuid(), 'balance_cents' => 0]
        );

        \Illuminate\Support\Facades\DB::transaction(function () use ($wallet, $validated) {
            $wallet->increment('balance_cents', $validated['amount_cents']);
            
            $wallet->transactions()->create([
                'uuid' => (string) Str::uuid(),
                'type' => 'credit',
                'amount_cents' => $validated['amount_cents'],
                'description' => 'Admin adjustment: ' . $validated['reason'],
            ]);
        });

        return $this->success(['balance_cents' => $wallet->fresh()->balance_cents], 'Balance added successfully.');
    }

    /**
     * Update admin permissions.
     */
    public function updatePermissions(Request $request, string $uuid): JsonResponse
    {
        $validated = $request->validate([
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['string'],
        ]);

        $user = User::where('uuid', $uuid)->where('role', UserRole::Admin)->firstOrFail();
        
        $user->update([
            'permissions' => $validated['permissions']
        ]);

        return $this->success(new UserAdminResource($user), 'Permissions updated successfully.');
    }
}
