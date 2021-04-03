<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class setLocal
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (session('locale') === null) {
            $locale = config('app.locale');
            Session::put('locale', $locale);
        }

        app()->setLocale(Session::get('locale'));
//        app()->setLocale(session('locale'));
        return $next($request);
    }
}
