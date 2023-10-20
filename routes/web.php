<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    $redirect = route('login');
    if (Auth::check()) {
        $redirect = route('dashboard');
    }

    return redirect($redirect);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/products', [ProductController::class, 'index'])->name('products');
    Route::get('/products/create', [ProductController::class, 'index'])->name('products.create');
    Route::get('/products/edit/{product}', [ProductController::class, 'index'])->name('products.edit');
    Route::post('/products/submit', [ProductController::class, 'index'])->name('products.submit');
    Route::delete('/products/delete/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    Route::get('/salespersons', [ProfileController::class, 'edit'])->name('salespersons');
    Route::get('/transactions', [ProfileController::class, 'edit'])->name('transactions');
});

require __DIR__.'/auth.php';
