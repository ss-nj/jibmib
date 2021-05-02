<?php


use App\Http\Auth\Shop\ForgotPasswordController;
use App\Http\Auth\Shop\LoginController;
use App\Http\Auth\Shop\RegisterController;
use App\Http\Shop\Controllers\CouponController;
use App\Http\Shop\Controllers\LicencesController;
use App\Http\Shop\Controllers\OpenTimesController;
use App\Http\Shop\Controllers\ParameterController;
use App\Http\Shop\Controllers\PhoneController;
use App\Http\Shop\Controllers\RefundController;
use App\Http\Shop\Controllers\ShopController;
use App\Http\Shop\Controllers\ShopDashboardController;
use App\Http\Shop\Controllers\TakhfifController;
use App\Http\Shop\Controllers\TransactionsController;
use App\Http\Shop\Controllers\UsageTermController;
use Illuminate\Support\Facades\Route;

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


//sortable package route




Route::group(['prefix' => 'shop'], function () {
    Route::middleware('throttle:5,1')->group(function () {

        Route::post('shop-login', [LoginController::class,'login'])->name('shop.login');
        Route::post('shop-register', [RegisterController::class,'register'])->name('shop.register');

    });
    Route::get('login', [LoginController::class,'showLoginForm'])->name('shop.login.form');
    Route::get('register', [RegisterController::class,'showRegisterForm'])->name('shop.register.form');

    Route::get('forgot-password', [ForgotPasswordController::class,'forgotPasswordForm'])->name('shop.forgot.password.form');
    Route::post('forgot-password', [ForgotPasswordController::class,'forgotPassword'])->name('shop.forgot.password.new.password');

    Route::get('user-logout', [LoginController::class,'logout'])->name('shop.logout');

});



Route::name('shop.')->prefix('shop')->middleware(['auth', 'confirmedMobile'])->group( function () {

    //takhfif routes
    Route::resource('takhfifs', TakhfifController::class);

    //load images for dropzoon preload takhfif
    Route::get('takhfifs-load-images/{takhfif}', [TakhfifController::class,'loadImages'])->name('takhfif.load.images');
    Route::post('takhfifs-upload-images/{takhfif}',  [TakhfifController::class,'uploadImages'])->name('takhfif.upload.images');
    Route::post('takhfifs-destroy-image/{image}',  [TakhfifController::class,'destroyImage'])->name('takhfif.destroy.images');

    //takhfifs parameters routes
    Route::get('parameters/{takhfif}', [ParameterController::class,'index'])->name('parameters.index');
    Route::post('parameters/{takhfif}', [ParameterController::class,'store'])->name('parameters.store');
    Route::delete('parameters/{parameter}', [ParameterController::class,'destroy'])->name('parameters.destroy');


    //takhfifs UsageTerm routes
    Route::get('usage-term/{takhfif}', [UsageTermController::class,'index'])->name('usage_term.index');
    Route::post('usage-term/{takhfif}', [UsageTermController::class,'store'])->name('usage_term.store');
    Route::delete('usage-term/{usage_term}', [UsageTermController::class,'destroy'])->name('usage_term.destroy');


    Route::get('/dashboard', [ShopDashboardController::class, 'index'])->name('dashboard');

    //profile routes add phone add logo add time add licences
    Route::resource('profiles', ShopController::class)->only('index','update',);

    Route::get('/licences', [LicencesController::class, 'index'])->name('licences.index');
    Route::put('/licences/{shop}', [LicencesController::class, 'update'])->name('licences.update');


    //load images for dropzoon preload
    Route::get('load-images/{shop}', [ShopController::class,'loadImages'])->name('load.images');
    Route::post('upload-images/{shop}',  [ShopController::class,'uploadImages'])->name('upload.images');
    Route::post('destroy-image/{image}',  [ShopController::class,'destroyImage'])->name('destroy.images');

//load images for dropzoon preload
    Route::get('load-licences/{shop}', [ShopController::class,'loadLicences'])->name('load.licences');
    Route::post('upload-licences/{shop}',  [ShopController::class,'uploadLicences'])->name('upload.licences');
    Route::post('destroy-licences/{image}',  [ShopController::class,'destroyLicence'])->name('user.destroy.licences');

    //phone routes
    Route::get('phones/{shop}', [PhoneController::class,'index'])->name('phones.index');
    Route::post('phones/{shop}', [PhoneController::class,'store'])->name('phones.store');
    Route::put('phones/{phone}', [PhoneController::class,'update'])->name('phones.update');
    Route::delete('phones/{phone}', [PhoneController::class,'destroy'])->name('phones.destroy');

 //open times routes
    Route::get('Open-Times/{shop}', [OpenTimesController::class,'index'])->name('times.index');
    Route::post('open-Times/{shop}', [OpenTimesController::class,'store'])->name('times.store');
    Route::delete('open-Times/{open_times}', [OpenTimesController::class,'destroy'])->name('times.destroy');


    //commerce routes
    Route::resource('transactions', TransactionsController ::class)->only('index');

    //takhfifs routes

    //coupon routes //for managing sold coupons
    Route::resource('coupon', CouponController::class)->only('index','update');
    Route::post('coupon', [CouponController::class,'revoke'])->name('revoke.coupon');


    //coupon routes //for managing sold coupons
    Route::resource('refund', RefundController::class)->only('index','update','store');
    Route::post('refund/ajax/edit/{refund}', [RefundController::class, 'ajaxEdit'])->name('panel.refund.ajax.edit');



    //ads routes

});



