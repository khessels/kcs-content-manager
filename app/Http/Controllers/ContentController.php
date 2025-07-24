<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\App;
use App\Models\AppKvStore;
use App\Models\AppUser;
use App\Models\Content;
use App\Models\Mimetype;
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
    public function helo( Request $request){
        return 'Hello world';
    }

    public function changeStatus( Request $request, $id, $status){
        try{
            $content = Content::where( 'id', $id)->first();
            $content->status = $status;
            $content->save();
            return response("OK");
        }catch(\Exception $e){
            error_log( $e->getMessage() );
        }
        return 'ERROR: '. $e->getMessage();
    }

    public function updateTagDirect( Request $request, $app, $id){
        try{
            $all = $request->all();
            $content = Content::where( 'id', $id)->where('app', $app)->first();
            if( empty( $content) ){
                return 'Content not found';
            }
            if( ! empty( $content)){
                $content->value = $all[ 'value'];
                $content->save();
            }
            return 'OK';
        }catch(\Exception $e){
            error_log( $e->getMessage() );
        }
        return 'ERROR: '. $e->getMessage();
    }
    public function db_populate_from_resources( Request $request ){
        $app = $request->header('x-app');
        $all = $request->all();
        $records = unserialize( $all['data']);
        foreach( $records as $record){
            $content = new Content( $record);
            $content->app = $app;
            if( ! empty( $record['expire_at'])){
                $content->expire_at = date('Y-m-d H:i:s', strtotime($record['expire_at']));
            }
            if( ! empty( $record['publish_at'])){
                $content->publish_at = date('Y-m-d H:i:s', strtotime($record['publish_at']));
            }
            if( ! empty( $record['env_source'])){
                $content->env_source = $record['env_source'];
            }else{
                $content->env_source = 'local';
            }
            if( ! empty( $record['env'])){
                $content->env = $record['env'];
            }else{
                $content->env = 'local';
            }
            if( ! empty( $record['language'])){
                $content->language = $record['language'];
            }else{
                $content->language = 'en';
            }
            if( ! empty( $record['mimetype'])){
                $content->mimetype = $record['mimetype'];
            }else{
                $content->mimetype = 'text/plain';
            }
            if( ! empty( $record['status'])){
                $content->status = $record['status'];
            }else{
                $content->status = 'ACTIVE';
            }
            if( ! empty( $record['user_id'])){
                $content->user_id = (int)$record['user_id'];
            }
            if( ! empty( $record['key'])){
                $content->key = $record['key'];
            }else{
                return response('ERROR: Key is required', 400);
            }
            if( ! empty( $record['value'])){
                $content->value = $record['value'];
            }
            if( ! empty( $record['data'])){
                $content->data = $record['data'];
            }
            if( ! empty( $record['default'])){
                $content->data = $record['default'];
            }

            // check for existing content with the same key, app, and language
            Content::updateOrCreate(
                ['key' => $content->key, 'app' => $content->app, 'language' => $content->language],
                [
                    'value' => $content->value,
                    'env_source' => $content->env_source,
                    'env' => $content->env,
                    'mimetype' => $content->mimetype,
                    'status' => $content->status,
                    'user_id' => $content->user_id,
                    'expire_at' => $content->expire_at,
                    'publish_at' => $content->publish_at,
                ]
            );
        }
        // return success response
        return "OK";
    }
    public function db_delete( Request $request){
        $app = $request->header('x-app');
        Content::where( 'app', $app)->delete();
        return "OK";
    }
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

    public function store( Request $request){
        try{
            $all = $request->all();
            if( empty( $request->id)) {
                if($request->language == 'all'){
                    $app = App::where('name', $request->app)->with('config')->first() ;
                    $locales = explode( ',', $this->kvStoreByKey($app->config, 'available_locales'));
                    foreach($locales as $locale){
                        $request->language = $locale;
                        $content = new Content( $request->all());
                    }
                }else{
                    $content = new Content( $request->all());
                }
            }else{
                unset( $all['id']);
                $content = Content::where( 'id', $all['id'])->update( $all);
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
            $app = App::where( 'name', $filters[ 'app'])->with( 'config')->first();
            $locales = explode( ',', $this->kvStoreByKey($app->config, 'available_locales'));
        }
        $user = Auth::user()->toArray();
        $mimetypes = Mimetype::all();
        return view('content')
            ->with( 'mimetypes', $mimetypes)
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
    public function listManagement( Request $request, $language = null)
    {
        if( empty( $request->header('x-app'))){
            return response()->json( [], 300);
        }
        if( ! empty( $language)){
            $content = Content::where('app', $request->header('x-app'))->where('language', $language)->get();
        }else{
            $content = Content::where('app', $request->header('x-app'))->get();
        }

        return response()->json( $content);
    }
    public function addExpressions( Request $request ){
        if( empty( $request->header('x-app'))){
            return response()->json( [], 300);
        }
        if( empty( $request->header('x-dev'))){
            return response()->json( [], 300);
        }

        if( empty( $request->expressions)){
            return 'Fail';
        }
        $expressions = unserialize( $request->expressions);
        foreach( $expressions as $expression){
            $expression =json_decode( $expression, true);
            if( ! in_array( strtolower( $expression['key']), ['not found'])){
                $xApp = $request->header('x-app');
                $xDev = $request->header('x-dev');
                $expression[ 'app' ] = $xApp;
                $expression[ 'env_source' ] = $xDev;
                $expression[ 'env' ] = 'local';

                if( empty( $expression[ 'mimetype' ])){
                    $expression[ 'mimetype' ] = 'text/html';
                }
                $query = Content::query();
                $query = $query->where( 'key', $expression['key'] );
                $query = $query->where( 'app', $xApp );

                if( !empty( $expression['page'] ) ){
                    $query = $query->where('page', $expression['page']);
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
        return 'ERROR: ' . $e->getMessage();
    }
}
