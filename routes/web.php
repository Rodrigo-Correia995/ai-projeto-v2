<?php

use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ProductController;
use App\Models\Categorie;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

Route::resource('products', ProductController::class);
Route::resource('categories', CategorieController::class)->parameters([
    'categories' => 'categorie'
]);

 


require __DIR__.'/auth.php';
