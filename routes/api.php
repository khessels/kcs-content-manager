<?php

use App\Http\Controllers\ContentController;
use App\Models\Content;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/management/content', [ContentController::class, 'listManagement']);
Route::post('/management/content/{language}', [ContentController::class, 'add']);
Route::get('/production/content', [ContentController::class, 'listProduction']);

