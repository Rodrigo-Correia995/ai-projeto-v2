<?php
use App\Http\Controllers\UserController;
use App\Http\Controllers\ShippingCostController;
use App\Http\Controllers\MembershipFeeController;
use App\Http\Controllers\SupplyOrderController;
use App\Http\Controllers\StockAdjustmentController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\CardController;
use App\Models\Operation;
use App\Http\Controllers\OperationController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\StatisticsController;

/*rotas publicas */
//Route::get('/', function () {
//    return view('welcome');
//})->name('home');

Route::view('/', 'home')->name('home');
Route::get('catalog', [ProductController::class, 'catalog'])->name('products.catalog');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth'])
    ->name('dashboard');
//Route::view('dashboard', 'dashboard')->name('dashboard');

Route::resource('products', ProductController::class);


Route::get('cart', [CartController::class, 'show'])->name('cart.show');


Route::post('cart/{product}', [CartController::class, 'addToCart'])->name('cart.add');


Route::delete('cart/{product}', [CartController::class, 'removeFromCart'])->name('cart.remove');


Route::put('cart/{product}', [CartController::class, 'updateCart'])->name('cart.update');
//rotas autenticado
Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
    Route::get('/membership_fees', [MembershipFeeController::class, 'edit'])->name('membership_fees.edit');
    Route::get('/my-card-operations', [OperationController::class, 'myCardOperations'])->name('operations.mycard');
    Route::get('/mycard', [CardController::class, 'mycard'])->middleware(['auth'])->name('cards.mycard');
    Route::post('/mycard/charge', [CardController::class, 'charge'])->name('cards.charge')->middleware('auth');
    Route::get('/statistics', [StatisticsController::class, 'index'])
    ->name('statistics.index')
    ->middleware('auth');
});
//rotas autenticado e veridifcado
Route::middleware('auth', 'verified')->group(function () {
//apenas admin e employee
Route::middleware('can:employee')->group(function () {
Route::resource('users', UserController::class);
Route::resource('cards', CardController::class);
Route::get('stock_adjustments', [StockAdjustmentController::class, 'index'])->name('stock_adjustments.index');
Route::resource('supply_orders', SupplyOrderController::class);
Route::patch('/supply-orders/{supplyOrder}/status', [SupplyOrderController::class, 'updateStatus'])->name('supply_orders.updateStatus');
Route::resource('operations', OperationController::class);
});
//apenas admin
Route::middleware('can:admin')->group(function () {
Route::put('/membership_fees', [MembershipFeeController::class, 'update'])->name('membership_fees.update');
Route::resource('shipping_costs', ShippingCostController::class);



});
//mais rotas auth verified
Route::post('cart', [CartController::class, 'confirm'])->name('cart.confirm');


Route::delete('cart', [CartController::class, 'destroy'])->name('cart.destroy');




Route::resource('categories', CategorieController::class)->parameters([
    'categories' => 'categorie'
]);


//Route::get('/membership_fees', [MembershipFeeController::class, 'edit'])->name('membership_fees.edit');

});

//mais rotas autenticado
Route::middleware(['auth'])->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/orders/{order}/complete', [OrderController::class, 'complete'])->name('orders.complete');
    Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::get('/orders/{order}/cancel', [OrderController::class, 'showCancelForm'])->name('orders.cancel.form');

});


require __DIR__.'/auth.php';
