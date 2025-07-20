<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use App\Models\App;

class validateAppToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = PersonalAccessToken::findToken( $request->bearerToken());
        $app = $token->tokenable;
        if (! $app) {

            throw new UnauthorizedHttpException('App Token Not Found');
        }

        $baseClass = class_basename( $app);
        if ( $baseClass !== 'App') {
            throw new NotFoundHttpException('Not am App Token');
        }
        $request->merge( [ 'app' => $app]);
        return $next( $request);
    }
}
