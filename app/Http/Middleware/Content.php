<?php

namespace App\Http\Middleware;

use App\Http\Controllers\ContentController;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Lang;
use Symfony\Component\HttpFoundation\Response;

class Content
{
    /**
     * Handle an incoming request.
     * We look if the request has the refresh-content query parameter. If so we will refresh the content and run an artisan optimize
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        if( Auth::check()){
            $roles = $request->user()->roles->pluck('name')->toArray();
            if( in_array('admin', $roles) || in_array('developer', $roles)){

                // check if we have a query parameter called refresh refresh-content
                if( $request->has('content-resources-refresh')){
                    // delete language files
                    $path = storage_path('app/kcs-content-manager.resources.*');
                    array_map( "unlink", glob( $path ) );

                    // retrieve new content
                    $o = new ContentController();
                    $o->retrieveContent($request);

                    // run artisan optimize so that tag changes will be propagated
                    Artisan::call('optimize', ['--quiet' => true]);
                }
                if( $request->has('content-collection-enable')){
                    $expire = Config::get('kcs-content-manager.expire');
                    if( ! empty( $request->query('content-collection-enable') ) ){
                        $expire = $request->query('content-collection-enable');
                    }

                    // enable content tag collection
                    Cache::put('kcs-content-manager.engine.collection.enabled', true, (int) $expire);
                }
                if( $request->has('content-collection-disable')){
                    // disable content tag collection
                    Cache::delete('kcs-content-manager.engine.collection.enabled');
                }
                if( $request->has('content-server-update')){
                    // send the found tags without correct translation to the server
                    $r = Http::withHeaders([
                        'Authentication' => 'bearer ' . config('kcs-content-manager.token'),
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json',
                        'x-dev' => config('kcs-content-manager.dev'),
                        'x-app' => config('kcs-content-manager.app')
                        ])
                        ->post(
                            config('kcs-content-manager.domain') . '/api/expressions',
                            Cache::get('kcs-content-manager.engine.collection'));

                    // delete the tag collection cache
                    //Cache::delete('kcs-content-manager.engine.collection');
                }
            }
        }
        return $response;
    }
}
