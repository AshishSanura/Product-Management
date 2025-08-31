<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Admin Controllers
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;

// Frondend Controllers
use App\Http\Controllers\Customer\ProductBrowseController;
use App\Http\Controllers\Customer\PushSubscriptionController;
use App\Http\Controllers\Customer\OrderPlaceController;

Route::get('/', function () {
	return view('welcome');
});

// Frontend Customer Routes
Route::middleware(['auth', 'verified'])->group(function () {
	Route::get('/dashboard', function () {
		return view('dashboard'); // separate customer dashboard blade
	})->name('dashboard');

	Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
	Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
	Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

	// Product  Browse Routes
	Route::resource('products', ProductBrowseController::class);

	// Push Subscription (Browser Notifications)
	Route::resource('push-subscriptions', PushSubscriptionController::class)->only(['index', 'store', 'destroy']);

	// Order Place Routes
	Route::resource('orders', OrderPlaceController::class)->only(['index', 'create', 'store']);
});

// Backend Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
	// Admin Login Routes
	Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
	Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
	Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
	
	// Admin Protected Routes
	Route::middleware(['auth:admin'])->group(function () {
		Route::get('/dashboard', function () {
			return view('dashboard');
		})->name('dashboard');

		// Product CRUD Routes
		Route::resource('products', ProductController::class);

		// Product CSV Import
		Route::post('products/import', [ProductController::class, 'import'])->name('products.import');

		// Order Routes
		Route::resource('orders', OrderController::class);
	});
});

require __DIR__.'/auth.php';