<?php

use App\Http\Controllers\ContentController;
use App\Http\Controllers\PageController;
use App\Models\Content;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/management/content/{language?}', [ContentController::class, 'listManagement']);
Route::post('/management/content', [ContentController::class, 'addManagement']);
Route::post('/expressions', [ContentController::class, 'addExpressions']);
Route::get('/production/content', [ContentController::class, 'listProduction']);
Route::delete('/database', [ContentController::class, 'db_delete']);
Route::patch('/tag/direct/{app}/{id}', [ContentController::class, 'updateTagDirect']);

Route::post('/page', [PageController::class, 'add_page']);
Route::delete('/page/{page}', [PageController::class, 'remove_page']);
Route::get('/page/list/{filter}', [PageController::class, 'list']);
Route::get('/page/{page}', [PageController::class, 'get_page']);
Route::patch('/page/{page}/active/{state}', [PageController::class, 'active_state']);

