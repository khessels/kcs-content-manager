<?php

use App\Http\Controllers\ContentController;
use App\Models\Content;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/management/content', function ( Request $request) {
    // todo: implement tokens
    if( empty( $request->header('x-app'))){
        return response()->json( [], 300);
    }
    if( empty( $request->header('x-token'))){
        return response()->json( [], 300);
    }

    $content = Content::where('app', $request->header('x-app'))->get();
    return response()->json( $content);
});

Route::post('/management/content/{language}', [ContentController::class, 'add']);

Route::get('/production/content', function ( Request $request) {
    if( empty( $request->header('x-app'))){
        return response()->json( [], 300);
    }

    $content = Content::where('user_id', $request->header('x-app'))->get();
    return response()->json( $content);
});
