<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CheckoutController;

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
Route::get('/', [ProductController::class, 'products'])->name('products.list');
Route::get('/item/{item_id}', [ProductController::class, 'detail'])->name('product.detail');

Route::middleware(['auth', 'verified'])->group(function() {
    Route::get('/sell', [SellController::class, 'sell'])->name('product.sell');
    Route::post('/sell/store', [SellController::class, 'store'])->name('product.store');

    Route::post('/checkout/{product}', [CheckoutController::class, 'checkout']);
    Route::get('/success', [CheckoutController::class, 'success'])->name('purchase.success');
    Route::get('/cancel', [CheckoutController::class, 'cancel'])->name('purchase.cancel');

    Route::post('/item/{product}/like', [LikeController::class, 'toggle'])->name('product.like');

    Route::post('/item/{product}/comments', [CommentController::class, 'store'])->name('comments.store');

    Route::prefix('purchase')->group(function() {
        Route::get('/{item_id}', [PurchaseController::class, 'purchase'])->name('product.purchase');
        Route::get('/address/{user_id}/product/{product_id}', [PurchaseController::class, 'edit'])->name('address.edit');
        Route::patch('/{item_id}', [PurchaseController::class, 'update'])->name('address.patch');
    });

    Route::prefix('mypage')->group(function() {
        Route::get('/', [ProfileController::class, 'mypage'])->name('mypage');
        Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
        Route::post('/', [ProfileController::class, 'store'])->name('profile.store');
    });

    Route::get('/dev/verify_email', function () {
        $user = Auth::user();

        if ($user && !$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            Auth::login($user);
        }

        return redirect()->route('mypage/profile');
    });
});