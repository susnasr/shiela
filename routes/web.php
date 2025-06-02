<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{ProfileController, BlogController};
use App\Http\Controllers\Frontend\ProductController as FrontendProductController;
use App\Http\Controllers\{CartController, DashboardController, OrderController, WishlistController};
use App\Http\Controllers\BlogController as PublicBlogController;
use App\Http\Controllers\Admin\{
    DashboardController as AdminDashboardController,
    ProductController as AdminProductController,
    OrderController as AdminOrderController,
    BlogPostController,
    BlogCategoryController,
};
use Illuminate\Support\Facades\Log;
use App\Models\Product;

Route::get('/', function () {
    $featuredProducts = Product::where('is_featured', true)
        ->latest()
        ->take(8)
        ->get();

    return view('welcome', [
        'featuredProducts' => $featuredProducts,
        'featuredProductCount' => count($featuredProducts)
    ]);
})->name('home');

// Admin blog routes
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::resource('blog', BlogPostController::class)->names('admin.blog');
    Route::resource('blog-categories', BlogCategoryController::class)->names('admin.blog-categories');
});

// Public blog routes
Route::controller(PublicBlogController::class)->group(function () {
    Route::get('/blog', 'index')->name('blog.index');
    Route::get('/blog/{slug}', 'show')->name('blog.show');
});

Route::controller(FrontendProductController::class)->group(function () {
    Route::get('/products', 'index')->name('products.index');
    Route::get('/products/{product:slug}', 'show')->name('products.show');
});

// Authenticated user routes (Buyer)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('profile')->controller(ProfileController::class)->group(function () {
        Route::get('/', 'edit')->name('profile.edit');
        Route::patch('/', 'update')->name('profile.update');
        Route::delete('/', 'destroy')->name('profile.destroy');
    });

    Route::prefix('cart')->controller(CartController::class)->group(function () {
        Route::post('/add/{product}', 'add')->name('cart.add');
        Route::get('/', 'index')->name('cart.index');
        Route::patch('/{cartItem}', 'update')->name('cart.update');
        Route::delete('/{cartItem}', 'destroy')->name('cart.destroy');
        Route::post('/remove-coupon', 'removeCoupon')->name('cart.removeCoupon');
    });

    Route::match(['get', 'post'], '/checkout', [OrderController::class, 'checkout'])->name('checkout');

    Route::prefix('orders')->controller(OrderController::class)->group(function () {
        Route::get('/', 'index')->name('orders.index');
        Route::get('/{order}', 'show')->name('orders.show');
    });

    Route::prefix('wishlist')->controller(WishlistController::class)->group(function () {
        Route::get('/', 'index')->name('wishlist.index');
        Route::post('/{product}', 'store')->name('wishlist.store');
        Route::delete('/{wishlistItem}', 'destroy')->name('wishlist.destroy');
    });
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::resource('products', AdminProductController::class);
    Route::patch('products/{product}/restore', [AdminProductController::class, 'restore'])->name('products.restore');

    Route::resource('orders', AdminOrderController::class)->except(['create', 'store']);
    Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])
        ->name('orders.updateStatus');
    Route::delete('/orders/{order}', [AdminOrderController::class, 'destroy'])->name('orders.destroy');
});

require __DIR__.'/auth.php';
