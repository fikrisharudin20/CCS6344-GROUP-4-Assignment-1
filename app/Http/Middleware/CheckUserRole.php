<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckUserRole
{
    public function handle($request, Closure $next, ...$roles)
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            $user = Auth::user();

            // Check if the user's role is in the allowed roles
            if (in_array($user->role, $roles)) {
                return $next($request);
            }

            // Log information for debugging
            Log::info("User with role '{$user->role}' tried to access a route requiring roles: " . implode(', ', $roles));

            // Provide a clearer error message
            abort(403, "'{$user->role}' does not have the authority to access this feature. Required roles: " . implode(', ', $roles));
        }

        // Redirect guest users to the login page
        return redirect('/login');
    }
}
