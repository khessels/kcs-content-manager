<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class Language
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //die('Hello');
        $language = Session::get('language');
        $a = app()->getLocale();
        if( ! empty( $language) && $language !== App::getLocale()) {
            //App::setLocale( $language);
            app()->setLocale( $language);
        }
        $b = app()->getLocale();
        return $next( $request);
    }
}
