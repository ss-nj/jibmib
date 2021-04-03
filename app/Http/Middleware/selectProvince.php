<?php

namespace App\Http\Middleware;

use Closure;

class selectProvince
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
//        dd(0);
        $provinceId = $request->provinceId;
        if ( $provinceId) {
//dd(1);
            $response = $next($request);
            return $response->withCookie(cookie()->forever('provinceId', $request->provinceId));
        }
//اگه توی کوکی یا سشن بود به روت اضافه بشه
        $savedProvince =  $request->cookie('provinceId');

        if ( $savedProvince) {
//            dd($savedProvince);
            $url = url()->full();
            if(count($_GET)) {
//                dd(1);
                return redirect($url . '&&provinceId=' . $savedProvince)
                    ->withCookie(cookie()->forever('provinceId', $savedProvince));
            }else
            return redirect($url . '?provinceId=' . $savedProvince)
                ->withCookie(cookie()->forever('provinceId', $savedProvince));
        }
//        dd(3);

//        if (!$provinceId && !$request->route()->named('select.city') && !$request->route()->named('login')) {
//            return redirect()->route('select.city');
//        }


        $response = $next($request);
        return $response->withCookie(cookie()->forever('provinceId', $request->provinceId));
    }
}
