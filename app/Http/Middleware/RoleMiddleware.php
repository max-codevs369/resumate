<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userRole = Auth::user()->role;
        $path = $request->path(); 

        $isRoleMismatch = $userRole !== $role;
        
        $isAdminOutBounds = ($userRole === 'admin' && !str_contains($path, 'admin'));
        
        $isUserOutBounds  = ($userRole === 'user' && !str_contains($path, 'user'));

        if ($isRoleMismatch || $isAdminOutBounds || $isUserOutBounds) {
            
            if (url()->previous() !== url()->current() && url()->previous() !== route('login')) {
                return back();
            }

            if ($userRole === 'admin') {
                return redirect()->route('admin.dashboard.index');
            }

            return redirect()->route('user.dashboard');
        }

        return $next($request);
    }
}