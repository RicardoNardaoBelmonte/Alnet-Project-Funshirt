<?php

use App\Http\Controllers\AdministrativeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DisciplineController;
use App\Http\Controllers\PersonalizedTshirtController;
use App\Http\Controllers\ShopCartController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminColorController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminTshirtController;
use App\Http\Controllers\AdminUserController;
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

Route::get('/categories', [CategoryController::class, 'index'])
    ->name('categories.index');
Route::get('/categories/{category}', [CategoryController::class, 'show'])
    ->name('categories.show');

Route::get('tshirts', [TshirtController::class, 'index'])->name('tshirts.index');
Route::get('tshirts/{tshirt}', [TshirtController::class, 'show'])->name('tshirts.show');

Route::view('/about', 'pages.about')->name('about');
Route::view('/support', 'pages.support')->name('support');

Route::get('courses/showcase', [CourseController::class, 'showCase'])
    ->name('courses.showcase');

Route::get('courses/{course}/curriculum', [CourseController::class, 'showCurriculum'])
    ->name('courses.curriculum');

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

/* ----- PROTECTED ROUTES (verified users only) ----- */
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('disciplines/my', [DisciplineController::class, 'myDisciplines'])
        ->name('disciplines.my');
    Route::resource('disciplines', DisciplineController::class)->except(['index', 'show']);

    Route::get('teachers/my', [TeacherController::class, 'myTeachers'])
        ->name('teachers.my');
    Route::delete('teachers/{teacher}/photo', [TeacherController::class, 'destroyPhoto'])
        ->name('teachers.photo.destroy');
    Route::resource('teachers', TeacherController::class);

    Route::get('students/my', [StudentController::class, 'myStudents'])
        ->name('students.my');
    Route::delete('students/{student}/photo', [StudentController::class, 'destroyPhoto'])
        ->name('students.photo.destroy');
    Route::resource('students', StudentController::class);

    Route::delete('administratives/{administrative}/photo', [AdministrativeController::class, 'destroyPhoto'])
        ->name('administratives.photo.destroy');
    Route::resource('administratives', AdministrativeController::class);

    // CART Related Routes
    Route::post('cart', [CartController::class, 'confirm'])->name('cart.confirm');

    // Admin routes
    Route::middleware('can:admin')->group(function () {
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::delete('courses/{course}/image', [CourseController::class, 'destroyImage'])
            ->name('courses.image.destroy');
        Route::resource('courses', CourseController::class)->except(['show']);
        Route::resource('departments', DepartmentController::class);
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
});

// CART Related Routes - these cart routes can be used by anonymous users,
// so they are outside the middleware group that requires authentication
Route::get('cart', [CartController::class, 'show'])->name('cart.show');
Route::post('cart/{discipline}', [CartController::class, 'addToCart'])->name('cart.add');
Route::delete('cart/{discipline}', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::delete('cart', [CartController::class, 'destroy'])->name('cart.destroy');

/* ----- OTHER PUBLIC ROUTES ----- */
/* ----- these routes should be positioned after related routes to avoid conflicts ----- */
Route::resource('courses', CourseController::class)->only(['show']);
Route::resource('disciplines', DisciplineController::class)->only(['index', 'show']);

require __DIR__.'/settings.php';