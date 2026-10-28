<?php

use App\Http\Controllers\AdminAccountController;

use App\Http\Controllers\AdminOrder;
use App\Http\Controllers\Adminpromotion;
use App\Http\Controllers\AdminSizeController;

use App\Http\Controllers\VNPAYController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminSupplierController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminMaterialController;
use App\Http\Controllers\AdminColorController;
use App\Http\Controllers\AdminContactController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminInfoWebController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AdminPostController;

use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminRatingController;

//login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/admin', [AdminDashboardController::class, 'index'])->name('admin.dashboard')->middleware(['auth']);
Route::post('/admin/dashboard', [AdminInfoWebController::class, 'update'])->name('admin.dashboard.update');
//register
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
//material
Route::get('/admin/materials', [AdminMaterialController::class, 'index'])->name('admin.materials.index');
Route::get('/admin/materials/create', [AdminMaterialController::class, 'create'])->name('admin.materials.create');
Route::post('/admin/materials/store', [AdminMaterialController::class, 'store'])->name('admin.materials.store');
Route::get('/admin/materials/edit/{MaChatLieu}', [AdminMaterialController::class, 'edit'])->name('admin.materials.edit');
Route::put('/admin/materials/update/{MaChatLieu}', [AdminMaterialController::class, 'update'])->name('admin.materials.update');
Route::delete('/admin/materials/delete/{MaChatLieu}', [AdminMaterialController::class, 'destroy'])->name('admin.materials.destroy');
//color
Route::get('/admin/colors', [AdminColorController::class, 'index'])->name('admin.colors.index');
Route::get('/admin/colors/create', [AdminColorController::class, 'create'])->name('admin.colors.create');
Route::post('/admin/colors/store', [AdminColorController::class, 'store'])->name('admin.colors.store');
Route::get('/admin/colors/edit/{MaLoaiMau}', [AdminColorController::class, 'edit'])->name('admin.colors.edit');
Route::put('/admin/colors/update/{MaLoaiMau}', [AdminColorController::class, 'update'])->name('admin.colors.update');
Route::delete('/admin/colors/delete/{MaLoaiMau}', [AdminColorController::class, 'destroy'])->name('admin.colors.destroy');
//account
Route::get('/admin/accounts', [AdminAccountController::class, 'index'])->name('admin.accounts.index');
Route::get('/admin/accounts/edit/{MaTaiKhoan}', [AdminAccountController::class, 'edit'])->name('admin.accounts.edit');
Route::post('/admin/accounts/update/{MaTaiKhoan}', [AdminAccountController::class, 'update'])->name('admin.accounts.update');
Route::post('/admin/accounts/lock/{MaTaiKhoan}', [AdminAccountController::class, 'lock'])->name('admin.accounts.lock');
//contact admin
Route::get('/admin/contacts', [AdminContactController::class, 'index'])->name('admin.contacts.index');
Route::get('/admin/contacts/{MaLienHe}/edit', [AdminContactController::class, 'edit'])->name('admin.contacts.edit');
Route::put('/admin/contacts/{MaLienHe}', [AdminContactController::class, 'update'])->name('admin.contacts.update');
Route::delete('/admin/contacts/{MaLienHe}', [AdminContactController::class, 'destroy'])->name('admin.contacts.destroy');
//product client
Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'productList'])->name('products.index');
Route::get('/aodai/{id}',[ProductController::class,'detail'])->name('product.detail');
Route::post('/cart/add/{id}',[CartController::class,'addToCart'])->name('cart.add');
Route::delete('/cart/remove/{id}',[CartController::class,'removeFromCart'])->name('cart.remove');
Route::delete('/cart/clear',[CartController::class,'clearCart'])->name('cart.clear');
Route::get('/cart',[CartController::class,'viewCart'])->name('cart.index');
Route::post('/update-quantity', [CartController::class, 'updateQuantity'])->name('update.quantity');
Route::get('/category/{id}', [ProductController::class, 'showByCategory'])->name('category.show');
Route::get('/products/category', [ProductController::class, 'category']) ->name('products.category');
// Quản lý áo dài (sản phẩm)
Route::get('/admin/products', [AdminProductController::class, 'index'])->name('admin.products.index');
Route::get('/admin/products/create', [AdminProductController::class, 'create'])->name('admin.products.create');
Route::post('/admin/products/store', [AdminProductController::class, 'store'])->name('admin.products.store');
Route::get('/admin/products/edit/{MaSanPham}', [AdminProductController::class, 'edit'])->name('admin.products.edit');
Route::put('/admin/products/update/{MaSanPham}', [AdminProductController::class, 'update'])->name('admin.products.update');
Route::delete('/admin/products/delete/{MaSanPham}', [AdminProductController::class, 'destroy'])->name('admin.products.destroy');
Route::post('/admin/products/toggle-status/{MaSanPham}', [AdminProductController::class, 'toggleStatus'])->name('admin.products.toggleStatus');

//check out
Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout.home')->middleware('auth');

//category
Route::get('/admin/categories', [AdminCategoryController::class, 'index'])->name('admin.categories.index');
Route::get('/admin/categories/create', [AdminCategoryController::class, 'create'])->name('admin.categories.create');
Route::post('/admin/categories/store', [AdminCategoryController::class, 'store'])->name('admin.categories.store');
Route::get('/admin/categories/edit/{MaLoaiSP}', [AdminCategoryController::class, 'edit'])->name('admin.categories.edit');
Route::put('/admin/categories/update/{MaLoaiSP}', [AdminCategoryController::class, 'update'])->name('admin.categories.update');
Route::delete('/admin/categories/delete/{MaLoaiSP}', [AdminCategoryController::class, 'destroy'])->name('admin.categories.destroy');
Route::post('/admin/categories/toggle-status/{MaLoaiSP}', [AdminCategoryController::class, 'toggleStatus'])->name('admin.categories.toggleStatus');

//size
Route::get('/admin/sizes', [AdminSizeController::class, 'index'])->name('admin.sizes.index');
Route::get('/admin/sizes/create', [AdminSizeController::class, 'create'])->name('admin.sizes.create');
Route::post('/admin/sizes/store', [AdminSizeController::class, 'store'])->name('admin.sizes.store');
Route::get('/admin/sizes/edit/{MaSize}', [AdminSizeController::class, 'edit'])->name('admin.sizes.edit');
Route::put('/admin/sizes/update/{MaSize}', [AdminSizeController::class, 'update'])->name('admin.sizes.update');
Route::delete('/admin/sizes/delete/{MaSize}', [AdminSizeController::class, 'destroy'])->name('admin.sizes.destroy');
Route::post('/admin/sizes/toggle-status/{MaSize}', [AdminSizeController::class, 'toggleStatus'])->name('admin.sizes.toggleStatus');

//promotion
Route::resource('/admin/promotions', App\Http\Controllers\Adminpromotion::class)->names('promotions');
Route::patch('/admin/promotions/{id}/restore',
    [Adminpromotion::class, 'restore']
)->name('promotions.restore');
//order
Route::resource('/admin/orders', App\Http\Controllers\AdminOrder::class)->names('orders');
Route::post('/admin/orders/status/{id}', [AdminOrder::class, 'confirmstatus'])->name('orders.confirmstatus');

//order client
Route::resource(('/order'), App\Http\Controllers\OrderController::class)->names('order');

//vnpay
Route::post('/vnpay-payment', [VNPAYController::class, 'createPayment'])->name('vnpay.pay');
Route::get('/vnpay-return', [VNPAYController::class, 'vnpayReturn']); // Nhận kết quả
//suppliers
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('suppliers', AdminSupplierController::class);

});


//contact
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
//profile
Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
//statistics
Route::get('/admin/statistics', [StatisticsController::class, 'index'])
    ->name('statistics.index');
// post-client
Route::get('/gioi-thieu', [PostController::class, 'gioiThieu'])->name('gioithieu');
Route::get('/blog', [PostController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [PostController::class, 'show'])->name('blog.show');
// post-admin
Route::get('/admin/bai-viet', [AdminPostController::class, 'index'])
    ->name('admin.baiviet.index');

Route::get('/admin/bai-viet/create', [AdminPostController::class, 'create'])
    ->name('admin.baiviet.create');

Route::post('/admin/bai-viet', [AdminPostController::class, 'store'])
    ->name('admin.baiviet.store');

Route::get('/admin/bai-viet/{id}/edit', [AdminPostController::class, 'edit'])
    ->name('admin.baiviet.edit');

Route::put('/admin/bai-viet/{id}', [AdminPostController::class, 'update'])
    ->name('admin.baiviet.update');

Route::delete('/admin/bai-viet/{id}', [AdminPostController::class, 'destroy'])
    ->name('admin.baiviet.destroy');
//profile
Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
//favorite
Route::post('/favorite/toggle/{id}', [FavoriteController::class, 'toggle'])
    ->name('favorite.toggle')
    ->middleware('auth');

Route::get('/favorites', [FavoriteController::class, 'index'])
    ->name('favorite.index')
    ->middleware('auth');    
//rating
Route::post('/rating/{MaSanPham}', 
    [App\Http\Controllers\RatingController::class, 'store']
)->name('rating.store')->middleware('auth');
//cancel oders
Route::patch('/orders/{id}/cancel', [OrderController::class, 'cancel'])
    ->name('orders.cancel')
    ->middleware('auth');
Route::patch('/orders/{id}/submit', [OrderController::class, 'submit'])
    ->name('orders.submit')
    ->middleware('auth');
//hide comments (admin)
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/comments', [AdminRatingController::class, 'index'])
        ->name('admin.comments.index');

    Route::patch('/comments/{id}/hide', [AdminRatingController::class, 'hide'])
        ->name('admin.comments.hide');
    Route::post('/ratings/{id}/show', [AdminRatingController::class, 'show'])->name('admin.comments.show');
});
//order and rating
Route::get('/san-pham-da-mua', 
    [OrderController::class, 'purchasedProducts']
)->name('orders.reviews');

