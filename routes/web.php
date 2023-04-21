<?php

use App\Http\Controllers\GoodsController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Auth::routes();

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/generate-token', function (Request $request) {
    $token = Auth::user()->createToken('api-token')->plainTextToken;

    return view('auth.generate-token', [
        'token' => $token,
    ]);
})->middleware(['auth'])->name('generate-token');


Route::middleware(['auth'])->group(function () {
    Route::resource('orders', OrderController::class);
    Route::resource('goods', GoodsController::class);
});

require __DIR__.'/auth.php';
