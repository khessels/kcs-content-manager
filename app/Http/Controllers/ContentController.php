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
        $query = Content::query();
        if( ! empty( $filters['parent_id'])){
            $query->where( 'parent_id', $filters['parent_id']);
        }
        if( ! empty( $filters['app'])){
            $query->where( 'app', $filters['app']);
        }
        if( ! empty( $filters['user_id'])){
            $query->where( 'user_id', $filters['user_id']);
        }
        if( ! empty( $filters['status'])){
            $query->where( 'status', $filters['status']);
        }
        if( ! empty( $filters['page'])){
            $query->where( 'page', $filters['page']);
        }
        $lang = ! empty( $filters['language'] ) ? $filters['language'] : null;
        $lang = empty( $lang) && ! empty( $filters['lang']) ? $filters['lang'] : $lang;
        if( ! empty( $lang)){
            $query->where( 'language', $lang);
        }
        if( ! empty( $filters['key'])){
            $query->where( 'key', 'like', '%' . $filters['key'] . '%');
        }
        if( ! empty( $filters['value'])){
            $query->where( 'value', 'like', '%' . $filters['value'] . '%');
        }
        if( ! empty( $filters['env'])){
            $query->where( 'env', $filters['env']);
        }
        if( ! empty( $filters['env_source'])){
            $query->where( 'env_source', $filters['env_source']);
        }
        if( ! empty( $filters['mimetype'])){
            $query->where( 'mimetype', $filters['mimetype']);
        }
        $content = $query->get();
        return view('content')->with(compact('filters'))->with('content', $content);
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
    public static function translate( $expression)
    {
        if( (int) config('kcs-content-manager.expire') > 0) {
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
                if( strtolower(config( 'kcs-content-manager.post')) === 'yes') {
                    Http::withHeaders([
                        'Authentication' => 'bearer ' . config('kcs-content-manager.token'),
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json',
                        'x-dev' => config('kcs-content-manager.dev'),
                        'x-app' => config('kcs-content-manager.app')
                    ])
                        ->post(
                            config('kcs-content-manager.domain') . '/api/management/content/' . Lang::locale(),
                            $expression
                        );
                }
                return ! isset( $expression[ 'default']) ? $expression[ 'key'] : $expression[ 'default'];
            }
            return $value;
        }else{
            return ! isset( $expression[ 'default']) ? $expression[ 'key'] : $expression[ 'default'];
        }
    }
}
