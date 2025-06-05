<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @param  mixed  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();

        if (!$user) {
            // Not authenticated
            return redirect()->route('login');
        }

        if (!in_array($user->role, $roles)) {
            // User does not have any of the required roles
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
