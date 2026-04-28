<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SalesPageController;
use Illuminate\Support\Facades\Route;

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

    Route::get('/sales-pages', [SalesPageController::class, 'index'])->name('sales-pages.index');
    Route::get('/sales-pages/create', [SalesPageController::class, 'create'])->name('sales-pages.create');
    Route::post('/sales-pages', [SalesPageController::class, 'store'])->name('sales-pages.store');
    Route::get('/sales-pages/{salesPage}', [SalesPageController::class, 'show'])->name('sales-pages.show');
    Route::delete('/sales-pages/{salesPage}', [SalesPageController::class, 'destroy'])->name('sales-pages.destroy');

    Route::resource('sales-pages', SalesPageController::class);
    Route::post('/sales-pages/{salesPage}/regenerate', [SalesPageController::class, 'regenerate'])->name('sales-pages.regenerate');
    Route::get('/sales-pages/{salesPage}/export-html', [SalesPageController::class, 'exportHtml'])
    ->name('sales-pages.export-html');
});

require __DIR__.'/auth.php';