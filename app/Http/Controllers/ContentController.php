<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Content;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Redis;
use Illuminate\View\View;

class ContentController extends Controller
{
    public function view(): View
    {
        $content = Content::all();
        return view('content')->with('content', $content);
    }

    public function listProduction( Request $request)
    {
        if( empty( $request->header('x-app'))){
            return response()->json( [], 300);
        }

        $content = Content::where('app', $request->header('x-app'))->get();
        return response()->json( $content);
    }
    public function listManagement( Request $request)
    {
        if( empty( $request->header('x-app'))){
            return response()->json( [], 300);
        }
        $content = Content::where('app', $request->header('x-app'))->get();
        return response()->json( $content);
    }
    public function addManagement( Request $request, $language){
        if( empty( $request->header('x-app'))){
            return response()->json( [], 300);
        }
        if( empty( $request->header('x-dev'))){
            return response()->json( [], 300);
        }
        $expression = $request->all();
        $expression[ 'app' ] = $request->header('x-app');
        $expression[ 'env_source' ] = $request->header('x-dev');
        $expression[ 'env' ] = 'local';
        if( empty( $expression[ 'mimetype' ])){
            $expression[ 'mimetype' ] = 'text/plain';
        }
        $query = Content::query();
        $query = $query->where( 'key', $expression['key'] );
        $query = $query->where( 'app', $request->header('x-app') );
        if( !empty( $expression['page'] ) ){
            $query = $query->where( 'page', $expression['page'] );
        }
        if( !empty( $expression['language'] ) ){
            $query = $query->where( 'language', $expression['language'] );
        }
        $model = $query->first();
        if( empty( $model ) ){
            $content = new Content( $expression);
            $content->save();
        }
        return response()->noContent();
    }
    public static function translate( $expression)
    {
        $redisKey = $expression[ 'key'];
        if( isset( $expression[ 'page'])) {
            $redisKey .= '.' . $expression[ 'page'];
        }
        if(! isset( $expression[ 'language'])) {
            $redisKey .= '.' . Lang::locale();
            $expression[ 'language'] = Lang::locale();
        }
        $value = Redis::get( config( 'kcs-content-manager.app' ) . '.' . $redisKey);
        if ( $value === null || $value === false ) {
            $response = Http::withHeaders([
                'Authentication' => 'bearer ' . config( 'kcs-content-manager.token' ),
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'x-dev' => config( 'kcs-content-manager.dev'),
                'x-app' => config( 'kcs-content-manager.app' )])
                ->post( 'http://kcs-content-manager.local/api/management/content/' . Lang::locale(), $expression);

            return ! isset( $expression[ 'default']) ? $expression[ 'key'] : $expression[ 'default'];
        }
        return $value;
    }
}
