<?php
use App\Http\Controllers\BlogController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'auth'], function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth:sanctum');
    Route::get('/loggedIn', function () {
        return 'hi';
    })->middleware('auth:sanctum');
});

Route::group(['prefix' => 'blogs'], function () {
    Route::get('/explore', [BlogController::class, 'explore'])->name('blogs.explore');
    Route::get('/', [BlogController::class, 'index'])->name('index')->middleware('auth:sanctum');
    Route::post('/', [BlogController::class, 'store'])->name('store')->middleware('auth:sanctum');
    Route::get('/{id}', [BlogController::class, 'show']);
    Route::patch('/{id}', [BlogController::class, 'update'])->name('update')->middleware('auth:sanctum');
    Route::delete('/{id}', [BlogController::class, 'destroy'])->name('destroy')->middleware('auth:sanctum');
    Route::get('/{id}/recommendations', [BlogController::class, 'recommendations']);
});

Route::group(['prefix' => 'images'], function () {
    Route::post('/', [ImageController::class, 'store'])->name('store');
    Route::delete('/{id}', [ImageController::class, 'destroy'])->name('destroy');
});
