<?php

use App\Http\Commerce\Controllers\AttributeController;
use App\Http\Commerce\Controllers\AttributeValueController;
use App\Http\Commerce\Controllers\CategoryController;
use App\Http\Commerce\Controllers\CouponController;
use App\Http\Commerce\Controllers\ExcelController;
use App\Http\Commerce\Controllers\LogoController;
use App\Http\Commerce\Controllers\PlaceController;
use App\Http\Commerce\Controllers\ShopController;
use App\Http\Commerce\Controllers\TransactionsController;
use App\Http\Shop\Controllers\TakhfifController;
use App\Http\Controllers\CartController;
use App\Http\Core\Controllers\BannerController;
use App\Http\Core\Controllers\DashboardController;
use App\Http\Core\Controllers\LogController;
use App\Http\Core\Controllers\MenuController;
use App\Http\Core\Controllers\PermissionController;
use App\Http\Core\Controllers\RoleController;
use App\Http\Core\Controllers\SettingController;
use App\Http\Core\Controllers\SliderController;
use App\Http\Core\Controllers\TicketController;
use App\Http\Core\Controllers\UserController;
use App\Http\Shop\Controllers\RefundController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| panel Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//beware resource routs always be under other routes


Route::group(['middleware' => 'auth', 'prefix' => 'panel'], function () {

    //dashboard routes
//    Route::get('/', [DashboardController::class,'dashboard'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('panel.dashboard');

    Route::get('logs', [LogController::class, 'index'])->name('log.index');


    Route::group(['prefix' => 'crm'], function () {


        //menus routes
        Route::get('menus/toggle/{menu}', [MenuController::class, 'toggle'])->name('menu.toggle.active');
        Route::resource('menus', MenuController::class)->except('show', 'create');


        //position routes

        Route::any('position', [CartController::class, 'changePosition'])->name('panel.position');

        //users routes
        Route::resource('users', UserController::class)->only('index', 'update', 'store', 'show');
        Route::get('remove-image/users/{user}', [UserController::class, 'removeImage'])->name('users.image.remove');
        Route::PUT('users/permissions/{user}', [UserController::class, 'sync'])->name('user.permissions.sync');
        Route::post('users/ajax/edit/{user}', [UserController::class, 'ajaxEdit'])->name('panel.users.ajax.edit');
        Route::post('users/ajax/permissions/{user}', [UserController::class, 'ajaxPermission'])->name('panel.users.ajax.permissions');
        Route::get('users/toggle/{user}', [UserController::class, 'activeToggle'])->name('user.toggle.active');


        //laratrust routes
        Route::resource('roles', RoleController::class)->except('show', 'create');
        Route::PUT('roles/permissions/{role}', [RoleController::class, 'sync'])->name('roles.permissions.sync');
        Route::post('role/ajax/edit/{role}', [RoleController::class, 'ajaxEdit'])->name('panel.role.ajax.edit');

        Route::resource('permissions', PermissionController::class)->except('show', 'edit', 'create');

        //settings
        Route::get('setting', [SettingController::class, 'index'])->name('setting.index');
        Route::post('setting', [SettingController::class, 'update'])->name('setting.update');
        Route::get('setting/{group}', [SettingController::class, 'settingPages'])->name('setting.pages');


        //slider routes
        Route::resource('sliders', SliderController::class)->except('show');
        Route::get('sliders/toggle/{slider}', [SliderController::class, 'activeToggle'])->name('slider.toggle.active');

        //banner routes
        Route::resource('banner', BannerController::class)->except('show');
        Route::get('banner/toggle/{banner}', [BannerController::class, 'activeToggle'])->name('banner.toggle.active');

        //places routes
        Route::resource('places', PlaceController::class)->except('show', 'create', 'edit');
        Route::get('places/toggle/{place}', [PlaceController::class, 'activeToggle'])->name('places.toggle.active');
        Route::post('places/ajax/edit/{place}', [PlaceController::class, 'ajaxEdit'])->name('panel.places.ajax.edit');

//places refunds
        Route::resource('refunds', RefundController::class)->except('show', 'edit');
        Route::post('refunds/ajax/edit/{refund}', [RefundController::class, 'ajaxEdit'])->name('panel.refund.ajax.edit');


        //tickets routes
        Route::resource('tickets', TicketController::class)
            ->only('store', 'show', 'index', 'destroy')
            ->names([
                'index' => 'panel.tickets.index',
                'store' => 'panel.message.store',
                'show' => 'panel.tickets.show',
                'destroy' => 'panel.tickets.destroy',
            ]);
        Route::get('admin-tickets/update-status', [TicketController::class, 'updateStatus'])->name('panel.tickets.status.update');
        Route::post('message', [TicketController::class, 'storeMessage'])->name('panel.store.message');

    });


    Route::group(['prefix' => 'commerce'], function () {

        //shops routes
        Route::resource('shops', ShopController::class)->except('show', 'destroy');
        Route::post('shops/approve/{upload}', [ShopController::class, 'approve'])->name('upload.approve');
        Route::post('shops/approve-shop/{shop}', [ShopController::class, 'approveShop'])->name('shop.approve');
        Route::get('shops/toggle/{shop}', [ShopController::class, 'activeToggle'])->name('shops.toggle.active');

     //shops routes
        Route::resource('takhfifs', \App\Http\Commerce\Controllers\TakhfifController::class)->except('show', 'destroy');
        Route::post('takhfifs/approve/{takhfif}', [\App\Http\Commerce\Controllers\TakhfifController::class, 'approveTakhfif'])->name('takhfifs.approve');
        Route::get('takhfifs/toggle/{takhfif}', [\App\Http\Commerce\Controllers\TakhfifController::class, 'activeToggle'])->name('takhfifs.toggle.active');
        //shops routes
        Route::resource('transaction', TransactionsController::class)->except('show', 'destroy');
        Route::post('transaction/approve/{transaction}', [TransactionsController::class, 'approveTransaction'])->name('transaction.approve');
        Route::get('transaction/toggle/{transaction}', [TransactionsController::class, 'activeToggle'])->name('transaction.toggle.active');

        //coupons routes
        Route::get('coupons/toggle/{coupon}', [CouponController::class, 'activeToggle'])->name('coupons.toggle.active');
        Route::resource('coupons', CouponController::class)->except('show', 'destroy');

        //attribute routes
        Route::get('attribute/toggle/{attribute}', [AttributeController::class, 'activeToggle'])->name('attribute.toggle.active');
        Route::resource('attribute', AttributeController::class)->except('show', 'create', 'edit',);
        Route::post('attribute/ajax/edit/{attribute}', [AttributeController::class, 'ajaxEdit'])->name('panel.attribute.ajax.edit');

        //attribute values routes
        Route::get('attribute-value/{attribute}', [AttributeValueController::class, 'index'])->name('attribute-value.index');
        Route::post('attribute-value/{attribute}', [AttributeValueController::class, 'store'])->name('attribute-value.store');;
        Route::delete('attribute-value/{attribute}', [AttributeValueController::class, 'destroy'])->name('attribute-value.destroy');;

        Route::get('takhfif-ajax-search', [TakhfifController::class, 'ajaxTakhfifList'])->name('ajax.takhfifs.list');
        Route::get('category-ajax-search', [TakhfifController::class, 'ajaxCategoriesList'])->name('ajax.categories.list');

        Route::get('export', [ExcelController::class, 'export'])->name('export');
        Route::get('excel', [ExcelController::class, 'importExportView'])->name('excel.index');;
        Route::post('import', [ExcelController::class, 'import'])->name('import');


        //category routes
        Route::resource('category', CategoryController::class)->except('show', 'create', 'edit');
        Route::get('remove-image/category/{category}', [CategoryController::class, 'removeImage'])->name('category.image.remove');
        Route::post('category/ajax/edit/{category}', [CategoryController::class, 'ajaxEdit'])->name('panel.category.ajax.edit');
        Route::get('category/toggle/{category}', [CategoryController::class, 'activeToggle'])->name('category.toggle.active');

        Route::post('category/ajax/attributes/edit/{category}', [CategoryController::class, 'ajaxSync'])->name('panel.category.attributes.ajax.edit');
        Route::post('category/attributes/{category}', [CategoryController::class, 'attributesUpdate'])->name('category.attributes.update');

        Route::get('logos', [LogoController::class, 'index'])->name('logo.index');

        //load images for dropzoon preload takhfif
        Route::get('logo-load-images', [LogoController::class,'loadImages'])->name('logo.load.images');
        Route::post('logo-upload-images',  [LogoController::class,'uploadImages'])->name('logo.upload.images');
        Route::post('logo-destroy-image/{image}',  [LogoController::class,'destroyImage'])->name('logo.destroy.images');
    });

});






