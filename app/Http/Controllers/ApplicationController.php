<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\App;
use App\Models\AppKvStore;
//use App\Models\AppToken;
use App\Models\Content;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Redis;
use Illuminate\View\View;
use Laravel\Sanctum\PersonalAccessToken;

class ApplicationController extends Controller
{
    public function listTokens( Request $request){
        $userAppsIds = App::where('user_id', Auth::id())->get()->pluck('id')->toArray();
        $tokens = PersonalAccessToken::whereIn( 'tokenable_id', $userAppsIds)->get();
        return [ 'tokens' => $tokens];
    }

    public function createToken( Request $request){
        try{
            $all = $request->all();
            $app = $request->app;
            $id = Auth::id();
            $app = App::where( 'name', $app)->where('user_id', $id)->first();
            $abilities = [ 'access:full'];
            $token = $app->createToken($app->name, $abilities);
            return ['token' => $token->plainTextToken];
        }catch(\Exception $e){
            error_log( $e->getMessage());
        }
        return false;
    }
    public function changeContent( Request $request, $id ){
        $content = Content::find( $id);
        if( empty( $content)){
            return 'FAIL';
        }
        $content->value = $request->value;
        $content->save();
        return 'OK';
    }
    public function deleteContentItems( Request $request){
        $data = $request->all();
        if( empty( $data['ids'])){
            return 'ERROR';
        }
        $ids = explode(',', $data['ids']);
        Content::destroy( $ids);
        return 'OK';
    }
    public function view( Request $request): View
    {
        $filters = $request->all();
        $query = App::query();

        if( ! empty( $filters['name'])){
            $query->where( 'name', $filters['name']);
        }
        $query->where( 'status', 'ACTIVE');
        $query->where( 'user_id', Auth::id());
        $apps = $query->get();

        return view('applications')
            ->with(compact('filters'))
            ->with('apps', $apps);
    }

    public function listProduction( Request $request)
    {
        if( empty( $request->header('x-app'))){
            return response()->json( [], 300);
        }

        $content = Content::where('app', $request->header('x-app'))->where('env', 'production')->get();
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
    public function addExpressions( Request $request ){
        if( empty( $request->header('x-app'))){
            return response()->json( [], 300);
        }
        if( empty( $request->header('x-dev'))){
            return response()->json( [], 300);
        }
//        $app = $request->header('x-app');
//        $dev = $request->header('x-dev');

        if( empty( $request->all())){
            return 'Fail';
        }
        foreach( $request->all() as $expression){
            $expression =json_decode( $expression, true);
            $expression[ 'app' ] = $request->header('x-app');
            $expression[ 'env_source' ] = $request->header('x-dev');
            $expression[ 'env' ] = 'local';

            if( empty( $expression[ 'mimetype' ])){
                $expression[ 'mimetype' ] = 'text/plain';
            }
            $query = Content::query();
            $query = $query->where( 'key', $expression['expression']['key'] );
            $query = $query->where( 'app', $request->header('x-app') );

            if( !empty( $expression['expression']['page'] ) ){
                if( $expression['expression']['page'] !== '___GENERIC___') {
                    $query = $query->where('page', $expression['page']);
                }
            }
            if( !empty( $expression['language'] ) ){
                $query = $query->where( 'language', $expression['language'] );
            }
            $model = $query->first();
            if( empty( $model ) ){
                $content = new Content( $expression);
                $content->save();
            }
        }
        return 'OK';
    }
    public function addManagement( Request $request){
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
    public function retrieveContent( Request $request)
    {
        $response = Http::withHeaders([
            'Authentication' => 'bearer ' . config('kcs-content-manager.token'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'x-app' => config('kcs-content-manager.app')
        ])->get(config('kcs-content-manager.domain') . '/api/management/content');
        $tags = $response->json();
        $items = [];
        foreach( $tags as $tag ) {
            $page = isset( $tag[ 'page']) ? $tag[ 'page'] : '___GENERIC___';
            $items[$tag[ 'language']][ $page][ $tag[ 'key']] = $tag[ 'value' ];
        }
        foreach( $items as $language => $item ) {
            $path = storage_path('app/kcs-content-manager.resources.' . $language );
            file_put_contents( $path, json_encode( $items[ $language]) );
        }
        return 'OK';
    }
    public static function translate( $expression, $content)
    {
        try{
            $content = json_decode( $content, true );
            $page = isset( $expression[ 'page']) ? $expression[ 'page'] : '___GENERIC___';
            if( isset( $content[ $page][ $expression[ 'key']])){
                return $content[ $page][ $expression[ 'key']] ;
            }
            if( isset( $content[ '___GENERIC___'][ $expression[ 'key']])){
                return $content[ '___GENERIC___'][ $expression[ 'key']] ;
            }

            if( Cache::get('kcs-content-manager.engine.collection.enabled')){
                // save tag to expressions cache
                $line =json_encode( ['expression' => $expression, 'page' => $page, 'language' => Lang::locale()]);
                Cache::add('kcs-content-manager.engine.collection', $line, config('kcs-content-manager.expire') );
            }
            if( ! empty( $expression[ 'default'])){
                return  $expression[ 'default'];
            }
            return  $expression[ 'key'];
        }catch(\Exception $e){
            error_log( $e->getMessage());
        }
    }
}
