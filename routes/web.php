<?php
use App\Http\Controllers\UserController;
use App\Http\Controllers\ShippingCostController;
use App\Http\Controllers\MembershipFeeController;
use App\Http\Controllers\SupplyOrderController;
use App\Http\Controllers\StockAdjustmentController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\CardController;
use App\Models\Operation;
use App\Http\Controllers\OperationController;

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

Route::get('stock_adjustments', [StockAdjustmentController::class, 'index'])->name('stock_adjustments.index');
Route::resource('supply_orders', SupplyOrderController::class);
Route::patch('/supply-orders/{supplyOrder}/status', [SupplyOrderController::class, 'updateStatus'])->name('supply_orders.updateStatus');

Route::get('/membership_fees', [MembershipFeeController::class, 'edit'])->name('membership_fees.edit');
Route::put('/membership_fees', [MembershipFeeController::class, 'update'])->name('membership_fees.update');

Route::resource('shipping_costs', ShippingCostController::class);

Route::get('catalog', [ProductController::class, 'catalog'])->name('products.catalog');

Route::resource('users', UserController::class);

Route::resource('cards', CardController::class);

Route::resource('operations', OperationController::class);

require __DIR__.'/auth.php';
