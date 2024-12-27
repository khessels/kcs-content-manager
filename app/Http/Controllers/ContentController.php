<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\App;
use App\Models\AppKvStore;
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
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

class ContentController extends Controller
{
    public function update( Request $request){
        $all  = $request->all();
        $ids = explode(',', $request->id);
        $content = Content::whereIn( 'id', $ids)->get();
        foreach( $content as $item){
            foreach($all as $key => $value){
                if( in_array( $key, ['app', 'env', 'env_source', 'expire_at', 'language', 'mimetype', 'page', 'parent_id', 'publish_at', 'status', 'user_id', 'key', 'value'])){
                    if( ! empty( $request->{'cb_' . $key})) {
                        if ( strtolower($request->{'cb_' . $key}) === 'on' ||
                             strtolower($request->{'cb_' . $key}) === '1' ||
                             strtolower($request->{'cb_' . $key}) === 'true') {
                            if( empty( $value)){
                                if( ! in_array( $key, ['app', 'status', 'key', 'mimetype', 'env', 'env_source'])){
                                    $item->{$key} = null;
                                    if( $key === 'value'){
                                        $item->{$key} = '';
                                    }
                                }
                            }else{
                                $item->{$key} = $value;
                            }
                        }
                    }
                }
            }
            $item->save();
        }
        return $this->view( $request);
    }
    public function patch( Request $request){
        $all  = $request->all();
        $s = '';
        return $this->view( $request);
    }
    public function store( Request $request){
        try{
            $all = $request->all();
            if( empty( $request->id)) {
                $content = new Content( $request->all());
            }else{
                unset( $all['id']);
                $all = array_values( $all);
                $content = Content::where( 'id', $request->id)->update( $all);
            }
            $content->save();
        }catch(\Exception $e){
            error_log( $e->getMessage() );
        }
        return $this->view( $request);
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
        $apps = App::get();

        $app = null;
        $locales = ['en'];
        if( ! empty( $filters['app'])){
            // override default config with app config
            $app = App::where('name', $filters['app'])->with('config')->first();
            foreach( $app->config as $item){
                if($item->key == 'available_locales'){
                    $locales = explode( ',', $item->value );
                }
            }
        }
        $user = Auth::user()->toArray();
        return view('content')
            ->with( compact('filters'))
            ->with( 'content', $content)
            ->with( 'user', $user)
            ->with( 'locales', $locales)
            ->with( 'apps', $apps)
            ->with( 'current_app', $app);
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
