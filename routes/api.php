<?php

use App\Http\Controllers\ContentController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ApplicationController;
use App\Models\Content;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user/test', [ApplicationController::class, 'testUser'])->middleware(['auth:sanctum']);
Route::get('/app/test', [ApplicationController::class, 'testApp'])->middleware(['auth:sanctum', 'validateAppToken']);
//Route::delete('/token', [ApplicationController::class, 'deleteToken'])->middleware(['auth:sanctum']);

// Route::get('/user/test', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
// Route::get('/app/test', function (Request $request) {
//     $user = $request->user();
//     // 'apps' => $user->apps()->get(),
//     //  'content' => Content::where('user_id', $user->id)->get(),
//     return $request->json([
//         'user' => $user,
//     ]);
// })->middleware('auth:sanctum');

Route::get('/management/content/{language?}', [ContentController::class, 'listManagement'])->middleware(['auth:sanctum', 'validateAppToken']);
Route::post('/management/content', [ContentController::class, 'addManagement'])->middleware(['auth:sanctum', 'validateAppToken']);
Route::post('/expressions', [ContentController::class, 'addExpressions'])->middleware(['auth:sanctum', 'validateAppToken']);
Route::get('/production/content', [ContentController::class, 'listProduction']);
Route::delete('/database', [ContentController::class, 'db_delete'])->middleware(['auth:sanctum', 'validateAppToken']);
Route::patch('/tag/direct/{app}/{id}', [ContentController::class, 'updateTagDirect'])->middleware(['auth:sanctum', 'validateAppToken'])->middleware(['auth:sanctum', 'validateAppToken']);
Route::post('/helo', [ContentController::class, 'helo'])->middleware(['auth:sanctum']);

Route::post('/page', [PageController::class, 'add_page'])->middleware(['auth:sanctum', 'validateAppToken']);
Route::delete('/page/{page}', [PageController::class, 'remove_page'])->middleware(['auth:sanctum', 'validateAppToken']);
Route::get('/page/list/{filter}', [PageController::class, 'list'])->middleware(['auth:sanctum', 'validateAppToken']);
Route::get('/page/{page}', [PageController::class, 'get_page'])->middleware(['auth:sanctum', 'validateAppToken']);
Route::patch('/page/{page}/active/{state}', [PageController::class, 'active_state'])->middleware(['auth:sanctum', 'validateAppToken']);

