<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AsteroidController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

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

Route::get('/list', [AsteroidController::class, 'asteroidList'])->name('list');
Route::post('/get-astroid-data-by-date-range', [AsteroidController::class, 'getAstroidDataByDateRange'])->name('get-astroid-data-by-date-range');

require __DIR__.'/auth.php';
