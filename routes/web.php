<?php

use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminColorController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminTshirtController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PersonalizedTshirtController;
use App\Http\Controllers\ShopCartController;
use App\Http\Controllers\TshirtController;
use Illuminate\Support\Facades\Route;

/* ----- T-SHIRT SHOP CART (no auth required) ----- */
Route::get('shop/cart', [ShopCartController::class, 'show'])->name('shop.cart.show');
Route::post('shop/cart/add/{tshirt}', [ShopCartController::class, 'add'])->name('shop.cart.add');
Route::patch('shop/cart/item', [ShopCartController::class, 'update'])->name('shop.cart.update');
Route::delete('shop/cart/item', [ShopCartController::class, 'remove'])->name('shop.cart.remove');
Route::delete('shop/cart', [ShopCartController::class, 'clear'])->name('shop.cart.clear');

/* ----- PUBLIC ROUTES ----- */
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

Route::get('tshirts', [TshirtController::class, 'index'])->name('tshirts.index');
Route::get('tshirts/{tshirt}', [TshirtController::class, 'show'])->name('tshirts.show');

Route::view('/about', 'pages.about')->name('about');
Route::view('/support', 'pages.support')->name('support');

/* ----- PERSONALIZED T-SHIRTS (auth required) ----- */
Route::middleware(['auth', 'verified'])->prefix('my/tshirts')->name('my.tshirts.')->group(function () {
    Route::get('/', [PersonalizedTshirtController::class, 'index'])->name('index');
    Route::get('/create', [PersonalizedTshirtController::class, 'create'])->name('create');
    Route::post('/', [PersonalizedTshirtController::class, 'store'])->name('store');
    Route::get('/{tshirt}/image', [PersonalizedTshirtController::class, 'image'])->name('image');
    Route::get('/{tshirt}/edit', [PersonalizedTshirtController::class, 'edit'])->name('edit');
    Route::get('/{tshirt}', [PersonalizedTshirtController::class, 'show'])->name('show');
    Route::put('/{tshirt}', [PersonalizedTshirtController::class, 'update'])->name('update');
    Route::delete('/{tshirt}', [PersonalizedTshirtController::class, 'destroy'])->name('destroy');
});

/* ----- ADMIN ROUTES (auth + verified + admin gate) ----- */
Route::middleware(['auth', 'verified', 'can:admin'])->group(function () {
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::resource('admin/tshirts', AdminTshirtController::class)
        ->names('admin.tshirts')
        ->except(['show']);

    Route::resource('admin/categories', AdminCategoryController::class)
        ->names('admin.categories')
        ->except(['show']);

    Route::resource('admin/colors', AdminColorController::class)
        ->names('admin.colors')
        ->except(['show']);
    Route::patch('admin/colors/{color}/restore', [AdminColorController::class, 'restore'])
        ->name('admin.colors.restore');

    Route::get('admin/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::patch('admin/users/{user}/block', [AdminUserController::class, 'block'])->name('admin.users.block');
    Route::patch('admin/users/{user}/unblock', [AdminUserController::class, 'unblock'])->name('admin.users.unblock');
});

require __DIR__.'/settings.php';
