<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FaqContoller;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleManagerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SslCommerzPaymentController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\WishListController;
use Illuminate\Support\Facades\Auth;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [FrontendController::class,'index'])->name('index');
Route::get('/about', [FrontendController::class,'about']);
Route::get('/contact', [FrontendController::class,'contact']);
Route::get('/category/products/{id}', [FrontendController::class,'category_products'])->name('category.products');
Route::get('/subcategory/products/{id}', [FrontendController::class,'subcategory_products'])->name('subcategory.products');
// Route::get('/subcategory/products/{id}', [FrontendController::class,'subcategory_products'])->name('subcategory.products');
Route::get('/products/details/{slug}', [FrontendController::class,'product_details'])->name('product.details');
Route::post('/getSize', [FrontendController::class,'getSize']);
Route::post('/getColor', [FrontendController::class,'getColor']);
Route::post('/getQuantity', [FrontendController::class,'getQuantity']);
Route::get('/aboutus', [FrontendController::class,'aboutus'])->name('aboutus');
Route::get('/contactus', [FrontendController::class,'contactus'])->name('contactus');
Route::get('/shop', [FrontendController::class,'shop'])->name('shop');
Route::get('/recent/view', [FrontendController::class,'recent_view'])->name('recent_view');



Route::get('/dashboard', [HomeController::class,'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

//user profile
Route::get('/user/profile', [HomeController::class, 'user_profile'])->name('user.profile');
Route::post('/user/profile/update', [HomeController::class, 'user_profile_update'])->name('user.profile.update');
Route::post('/password/update', [HomeController::class, 'password_update'])->name('user.pass.update');
Route::post('/user/photo/update', [HomeController::class, 'user_photo_update'])->name('user.photo.update');


//user
Route::get('/user/list', [UserController::class, 'user_list'])->name('user.list');
Route::get('/user/remove/{user_id}', [UserController::class, 'user_remove'])->name('user.remove');
Route::post('/user/register/', [UserController::class, 'custom_register'])->name('custom.register');

//category
Route::get('/category', [CategoryController::class, 'category'])->name('category');
Route::post('/category/store', [CategoryController::class, 'category_store'])->name('category.store');
Route::get('/category/edit/{category_id}', [CategoryController::class, 'category_edit'])->name('category.edit');
Route::post('/category/update', [CategoryController::class, 'category_update'])->name('category.update');
Route::get('/category/delete/{category_id}', [CategoryController::class, 'category_delete'])->name('category.delete');
Route::get('/category/trash', [CategoryController::class, 'category_trash'])->name('category.trash');
Route::get('/category/trash', [CategoryController::class, 'category_trash'])->name('category.trash');
Route::get('/category/restore/{id}', [CategoryController::class, 'category_restore'])->name('category.restore');
Route::get('/category/hard/delete/{category_id}', [CategoryController::class, 'category_hard_delete'])->name('category.hard.delete');
Route::post('/category/delete/checked', [CategoryController::class, 'delete_checked'])->name('delete.checked');
Route::post('/category/restore/checked', [CategoryController::class, 'restore_checked'])->name('restore.checked');
Route::post('/category/delete/checked/permanent', [CategoryController::class, 'delete_checked_permanent'])->name('delete.checked.permanent');

//subcategory
Route::get('/subcategory', [SubcategoryController::class, 'subcategory'])->name('subcategory');
Route::post('/subcategory/store', [SubcategoryController::class, 'subcategory_store'])->name('subcategory.store');
Route::get('/subcategory/edit/{id}', [SubcategoryController::class, 'subcategory_edit'])->name('subcategory.edit');
Route::post('/subcategory/update/{id}', [SubcategoryController::class, 'subcategory_update'])->name('subcategory.update');
Route::get('/subcategory/delete/{id}', [SubcategoryController::class, 'subcategory_delete'])->name('subcategory.delete');

//brand
Route::get('/brand', [BrandController::class, 'brand'])->name('brand');
Route::post('/brand', [BrandController::class, 'brand_store'])->name('brand.store');
Route::get('/brand/edit/{brand_id}', [BrandController::class, 'brand_edit'])->name('brand.edit');
Route::POST('/brand/update', [BrandController::class, 'brand_update'])->name('brand.update');
Route::get('/brand/delete/{brand_id}', [BrandController::class, 'brand_delete'])->name('brand.delete');

//product
Route::get('/product', [ProductController::class, 'product'])->name('product');
Route::post('/getSubcategory', [ProductController::class, 'getSubcategory']);
Route::post('/product/store', [ProductController::class, 'product_store'])->name('product.store');
Route::get('/product/list', [ProductController::class, 'product_list'])->name('product.list');
Route::get('/product/delete/{products_id}', [ProductController::class, 'product_delete'])->name('product.delete');
Route::get('/product/show/{products_id}', [ProductController::class, 'product_show'])->name('product.show');
Route::get('/product/inventory/{product_id}', [ProductController::class, 'inventory'])->name('inventory');
Route::post('/product/inventory/store/{id}', [ProductController::class, 'inventory_store'])->name('inventory.store');

Route::get('/product/edit/{id}', [ProductController::class, 'product_edit'])->name('product.edit');


Route::post('/getSubcategory2', [ProductController::class, 'getSubcategory2']);

Route::post('/changeStatus', [ProductController::class, 'changeStatus']);

//inventory
Route::get('/variation', [InventoryController::class, 'variation'])->name('variation');
Route::post('/variation/store', [InventoryController::class, 'color_store'])->name('color.store');
Route::post('/variation/size', [InventoryController::class, 'size_store'])->name('size.store');
Route::get('/variation/color/remove/{id}', [InventoryController::class, 'color_remove'])->name('color.remove');
Route::get('/variation/size/remove/{id}', [InventoryController::class, 'size_remove'])->name('size.remove');
Route::get('/inventory/delete/{id}', [InventoryController::class, 'inventory_delete'])->name('inventory.delete');


//cutomer
Route::get('/customer/login', [CustomerAuthController::class, 'cutomer_login'])->name('cutomer.login');
Route::get('/customer/register', [CustomerAuthController::class, 'cutomer_register'])->name('cutomer.register');
Route::post('/customer/store', [CustomerAuthController::class, 'customer_store'])->name('customer.store');
Route::post('/customer/login', [CustomerAuthController::class, 'customer_login_confirm'])->name('customer.login.confirm');

Route::get('/customer/profile', [CustomerController::class, 'customer_profile'])->name('customer.profile')->middleware('cutomer');
Route::get('/customer/logout', [CustomerController::class, 'customer_logout'])->name('customer.logout');
Route::post('/customer/profile/update', [CustomerController::class, 'customer_profile_update'])->name('customer.profile.update');

Route::get('/order/success', [CustomerController::class, 'order_success'])->name('order.success');
Route::get('/customer/order', [CustomerController::class, 'customer_order'])->name('customer.order');
Route::get('/order/invoice/download/{id}', [CustomerController::class, 'order_invoice_download'])->name('order.invoice.download');

Route::get('/cancel/myorder/{id}', [CustomerController::class, 'cancel_myorder'])->name('cancel.myorder');

Route::get('/reload-captcha', [CustomerAuthController::class, 'reloadCaptcha']);

//cart
Route::post('/cart/store', [CartController::class, 'cart_store'])->name('cart.store');
Route::get('/cart/remove/{id}', [CartController::class, 'cart_remove'])->name('cart.remove');
Route::get('/cart/', [CartController::class, 'cart'])->name('cart');
Route::post('/cart/update', [CartController::class, 'cart_update'])->name('cart.update');


//Coupon
Route::get('/coupon', [CouponController::class, 'coupon'])->name('coupon');
Route::post('/coupon/store', [CouponController::class, 'coupon_store'])->name('coupon.store');
Route::post('/CouponchangeStatus', [CouponController::class, 'CouponchangeStatus'])->name('CouponchangeStatus');
Route::get('/coupon/delete/{id}', [CouponController::class, 'coupon_delete'])->name('coupon.delete');

//Checkout
Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
Route::post('/getCity', [CheckoutController::class, 'getCity']);
Route::post('/order/store', [CheckoutController::class, 'order_store'])->name('order.store');


//orders
Route::get('/orders', [OrderController::class, 'orders'])->name('orders');
Route::post('/order/status/update', [OrderController::class, 'order_status_update'])->name('order.status.update');
Route::get('/order/cancel/req', [OrderController::class, 'order_cancel_req'])->name('order.cancel.req');

// SSLCOMMERZ Start
// Route::get('/example1', [SslCommerzPaymentController::class, 'exampleEasyCheckout']);
// Route::get('/example2', [SslCommerzPaymentController::class, 'exampleHostedCheckout']);

Route::get('/pay', [SslCommerzPaymentController::class, 'index'])->name('pay');
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
//SSLCOMMERZ END


//stripe
Route::controller(StripePaymentController::class)->group(function(){
    Route::get('stripe', 'stripe')->name('stripe');
    Route::post('stripe', 'stripePost')->name('stripe.post');
});


//review
Route::post('/review/store', [FrontendController::class, 'review_store'])->name('review.store');

//subscriber
Route::post('/subscriber/store', [SubscriberController::class, 'subscriber_store'])->name('subscriber.store');
Route::get('/subscriber', [SubscriberController::class, 'subscriber'])->name('subscriber');
Route::get('/send/newsletter/{id}', [SubscriberController::class, 'send_newsletter'])->name('send.newsletter');


//route password reset
Route::get('/password/reset', [PasswordResetController::class, 'password_reset'])->name('password.reset');
Route::post('/password/reset/request/sent', [PasswordResetController::class, 'passwordreset_request_sent'])->name('passwordreset.request.sent');
Route::get('/password/reset/form/{token}', [PasswordResetController::class, 'passwordreset_form'])->name('passwordreset.form');
Route::post('/password/reset/confirm/{token}', [PasswordResetController::class, 'password_reset_confirm'])->name('password.reset.confirm');
Route::post('/password/reset/confirm/{token}', [PasswordResetController::class, 'password_reset_confirm'])->name('password.reset.confirm');

//email verify in signup
Route::get('/password/email/verify/{token}', [CustomerAuthController::class, 'customer_email_verify'])->name('customer.email.verify');

//Role Manager
Route::get('/role/manager', [RoleManagerController::class, 'role_manager'])->name('role.manager');
Route::post('/permission/store', [RoleManagerController::class, 'permission_store'])->name('permission.store');
Route::post('/role/store', [RoleManagerController::class, 'role_store'])->name('role.store');
Route::post('/role/assigne', [RoleManagerController::class, 'role_assign'])->name('role.assign');
Route::get('/remove/user/role/{id}', [RoleManagerController::class, 'remove_user_role'])->name('remove.user.role');
Route::get('/delete/role/{id}', [RoleManagerController::class, 'delete_role'])->name('delete.role');
Route::get('/edit/role/{id}', [RoleManagerController::class, 'edit_role'])->name('edit.role');
Route::post('/update/role/{id}', [RoleManagerController::class, 'update_role'])->name('update.role');

//tag
Route::get('/tag', [TagController::class, 'tag'])->name('tag');
Route::post('/tag/store', [TagController::class, 'tag_store'])->name('tag.store');

//Faq
Route::resource('faq', FaqContoller::class);

//wishlist
Route::post('/wishlist/store', [WishListController::class, 'wishlist_store'])->name('wishlist.store');
Route::get('/wish/remove/{id}', [WishListController::class, 'wish_remove'])->name('wish.remove');
Route::get('/wishlist', [WishListController::class, 'wishlist'])->name('wishlist');
Route::get('/wish/cart/{id}', [WishListController::class, 'wish_cart'])->name('wish.cart');
