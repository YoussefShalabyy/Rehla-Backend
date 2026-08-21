<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        // Admins can see everything in the dashboard (GET requests are allowed)
        if ($request->isMethod('GET')) {
            return $next($request);
        }

        $user = $request->user();

        // Must be authenticated and be an admin
        if (!$user || $user->role !== UserRole::Admin) {
            abort(403, 'Unauthorized. Admin access required.');
        }

        // If permissions is exactly null, we treat them as Super Admin (full access).
        if ($user->permissions === null) {
            return $next($request);
        }

        // If permissions is an array, they must have the specific permission.
        if (!in_array($permission, $user->permissions, true)) {
            abort(403, 'You do not have permission to perform this action.');
        }

        return $next($request);
    }
}
