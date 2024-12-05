<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Content;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ContentController extends Controller
{
    public function add( Request $request, $language){
        $expression = $request->all();
        $expression[ 'user_id' ] = 1;
        if( empty( $expression[ 'mimetype' ])){
            $expression[ 'mimetype' ] = 'text/plain';
        }
        $query = Content::query();
        $query = $query->where( 'key', $expression['key'] );
        $query = $query->where( 'user_id', 1 );
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
