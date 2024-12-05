<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Content;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ContentController extends Controller
{
    public function add( Request $request, $language){
        if( empty( $request->header('x-app'))){
            return response()->json( [], 300);
        }

        $expression = $request->all();
        $expression[ 'app' ] = $request->header('x-app');
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
        }else{
            $query = $query->where( 'language', $language );
            $expression['language'] = $language;
        }
        $model = $query->first();
        if( empty( $model ) ){
            $content = new Content( $expression);
            $content->save();
        }
        return response()->noContent();
    }
}
