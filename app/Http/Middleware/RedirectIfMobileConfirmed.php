<?php

namespace App\Http\Middleware;

use App\Http\Core\Models\User;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RedirectIfMobileConfirmed
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (!auth($guard)->user()->mobile_verified_at ) {
//            dd(1);
             return redirect()->route('verify.mobile.form');
        }
        return $next($request);
    }
}
