<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class isActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::user()->active) {
            Auth::logout();
            return redirect()->route('home')
                ->with('logout','شماره ی همراه شما در سایت توسط مدیر  غیر فعال شده است');
//                ->withErrors(['alert_title' => 'خطا', 'alert_body' => 'شماره ی همراه شما توسط مدیر در سایت غیر فعال شده است']);

        }
        return $next($request);
    }
}
