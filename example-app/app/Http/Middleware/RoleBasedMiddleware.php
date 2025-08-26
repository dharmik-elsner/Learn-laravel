<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class RoleBasedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {   
        if (!Auth::check()) {
            return Redirect::to('/login');
        }

        $user = Auth::user();

        $roleRouteMap = [
            'Admin'  => 'home',
            'Buyer'  => 'buyer.dashboard',
            'Seller' => 'seller.dashboard',
        ];

        $expectedRoute = $roleRouteMap[$user->role] ?? 'login';

        if (!$request->routeIs($expectedRoute)) {
            return Redirect::route($expectedRoute)
                ->with('error', "You don't have access to this page.");
        }
        return $next($request);
    }
}
