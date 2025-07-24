<?php
use Illuminate\Http\Request;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\LanguagesController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResourceController;
use Illuminate\Support\Facades\Route;
Route::group(['middleware' => ['web', 'language']], function () {
    Route::get('/', function () {
        return view('welcome');
    });

    Route::group(['middleware' => ['auth', 'verified']], function () {
    //Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');
        Route::get('/applications', [ApplicationController::class, 'view'])->name('view.applications');
        Route::get('/resources', [ResourceController::class, 'view'])->name('view.resources');

        Route::group(['prefix' => 'content'], function () {
            Route::delete('/', [ContentController::class, 'deleteContentItems']);
            Route::get('/', [ContentController::class, 'view'])->name('view.content');
            Route::put('/{id}', [ContentController::class, 'changeContent'])->name('put.content');
            Route::patch('/{id}/status/{status}', [ContentController::class, 'changeStatus'])->name('patch.status');
            Route::post('/', [ContentController::class, 'store']);
            Route::put('/', [ContentController::class, 'update']);
        });
        Route::post('/resource', [ResourceController::class, 'upload']);

        Route::group(['prefix' => 'token'], function () {
            Route::post('app/create', [ApplicationController::class, 'createAppToken'])->name('token.app.create');
            Route::post('user/create', [ApplicationController::class, 'createUserToken'])->name('token.user.create');
        });
        Route::group(['prefix' => 'token'], function () {
            Route::post('app/create', [ApplicationController::class, 'createAppToken'])->name('token.app.create');
            Route::post('user/create', [ApplicationController::class, 'createUserToken'])->name('token.user.create');
        });
        Route::group(['prefix' => 'tokens'], function () {
            Route::delete('/', [ApplicationController::class, 'deleteTokens'])->name('tokens.list');
        });
    });

    Route::middleware('auth')->group(function () {
        Route::group(['prefix' => 'profile'], function () {
            Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
            Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
        });
    });
    require __DIR__.'/auth.php';
});



