<?php

use App\Http\Controllers\ContentController;
use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/management/content', function ( Request $request) {
    $content = Content::where('user_id', 1)->get();
    return response()->json( $content);
});
Route::post('/management/content/{language}', [ContentController::class, 'add']);


Route::get('/production/content', function () {
    $content = Content::where('user_id', 1)->get();
    return response()->json( $content);
});
