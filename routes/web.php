<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImmatriculationController;
use App\Http\Controllers\DashbordController;

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

Route::middleware(['auth', 'verified'])->prefix('dashboard')->name('dash_')->group(function () {
    Route::get('/', [DashbordController::class, 'index'])->name('home');
    Route::get('/all', [DashbordController::class, 'all_immat'])->name('all');
    Route::get('/validate', [DashbordController::class, 'validate_immat'])->name('validate');
    Route::get('/wait', [DashbordController::class, 'wait_immat'])->name('wait');
    Route::get('/block', [DashbordController::class, 'block_immat'])->name('block');
    Route::get('/show/{id}', [DashbordController::class, 'show'])->name('show');
    Route::post('/traiter/{id}', [DashbordController::class, 'traiter'])->name('traiter');
});


Route::get('/cni', function () {
    return view('front_ia');
});

Route::post('/enregistrer', [ImmatriculationController::class, 'store']);


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
