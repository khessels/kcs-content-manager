<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\LanguagesController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResourceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/language/switch', [LanguagesController::class, 'languageSwitch'])->name('post.language.switch');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');
    Route::get('/applications', [ApplicationController::class, 'view'])->name('view.applications');
    Route::get('/resources', [ResourceController::class, 'view'])->name('view.resources');

    Route::group(['prefix' => 'content'], function () {
        Route::delete('/', [ContentController::class, 'deleteContentItems']);
        Route::get('/', [ContentController::class, 'view'])->name('view.content');
        Route::put('/{id}', [ContentController::class, 'changeContent'])->name('put.content');
        Route::post('/', [ContentController::class, 'store']);
        Route::put('/', [ContentController::class, 'update']);
    });
    Route::post('/resource', [ResourceController::class, 'upload']);

});

Route::middleware('auth')->group(function () {
    Route::group(['prefix' => 'profile'], function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});
Route::group(['prefix' => 'token'], function () {
    Route::post('create', [ApplicationController::class, 'createToken'])->name('token.create');
});
Route::group(['prefix' => 'tokens'], function () {
    Route::get('/', [ApplicationController::class, 'listTokens'])->name('tokens.list');
});
require __DIR__.'/auth.php';
