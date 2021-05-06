<?php

use App\Http\Auth\User\ForgotPasswordController;
use App\Http\Auth\User\LoginController;
use App\Http\Auth\User\RegisterController;
use App\Http\CommentController;
use App\Http\Commerce\Models\Place;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Core\Controllers\CityController;
use App\Http\ProfileController;
use App\Http\RateController;
use App\Http\SearchController;
use App\Http\TicketController;
use Illuminate\Support\Facades\Auth;
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

Route::fallback(function(){
    return view('errors.404');
});

Route::group(['namespace' => 'Auth\User',], function () {

    Route::middleware('throttle:5,1')->group(function () {

        Route::post('user-login', [LoginController::class,'login'])->name('user.login');
        Route::post('user-register', [RegisterController::class,'register'])->name('user.register');

    });
    Route::get('login', [LoginController::class,'showLoginForm'])->name('login.form');
    Route::get('register', [RegisterController::class,'showRegisterForm'])->name('register.form');

    Route::get('forgot-password', [ForgotPasswordController::class,'forgotPasswordForm'])->name('forgot.password.form');
    Route::post('forgot-password', [ForgotPasswordController::class,'forgotPassword'])->name('forgot.password.new.password');

    Route::get('user-logout', [LoginController::class,'logout'])->name('logout');

});


Route::group(['middleware' => ['auth']], function () {

    Route::resource('profile', ProfileController::class)->only('index','update');

    Route::get ('print/{code}', [ProfileController::class,'print'])->name('print');

    Route::get ('tickets', [TicketController::class,'index'])->name('user.tickets.index');
    Route::post ('tickets', [TicketController::class,'store'])->name('user.tickets.store');
    Route::get ('tickets/{ticket}', [TicketController::class,'show'])->name('user.tickets.show');
    Route::post ('message/{ticket}', [TicketController::class,'storeMessage'])->name('user.messages.store');

});

//sortable package route
Route::post('sort', '\Rutorika\Sortable\SortableController@sort');

//change city
Route::get('/select-city', [HomeController::class, 'citySelect'])->name('city.select');


Route::get('/', [HomeController::class, 'index'])->name('home');

foreach (Place::select('slug')->get()  as $place){
    Route::get('/'.$place->slug, [HomeController::class, 'index']);
}

Route::get('/coupon/{slug}', [HomeController::class, 'single'])->name('single');
//category
Route::get('/city/{city}/cat/{cat}', [HomeController::class, 'category'])->name('category');

Route::post('/news-letter/', [HomeController::class, 'join'])->name('newsletter.join');


Route::get('/policy', [HomeController::class, 'policy'])->name('policy');
Route::get('/about-us', [HomeController::class, 'aboutUs'])->name('about.us');
Route::get('/contact-us', [HomeController::class, 'contactUs'])->name('contact.us');

//ajax city list load
Route::get('cities', [CityController::class,'cityList'])->name('city.load');
Route::get('provinces', [CityController::class,'provinceList'])->name('province.load');
Route::get('places', [CityController::class,'placesList'])->name('places.load');

//shopping routes
//اضافه کردن اژکس به سبد
Route::any('add-to-cart', [CartController::class,'addToCart'])->name('add.to.cart');
Route::any('refresh-cart', [CartController::class,'refreshCart'] )->name('refresh.cart');

//حذف کردن اژکس از سبد
Route::any('remove-from-cart',  [CartController::class,'removeFromCart'])->name('remove.from.cart');

//if user is not logged in cant go further than view cart
//view cart
//checkout :remove sessions add to basket middleware auth
Route::get('basket', [BasketController::class,'cartView'])->name('view.basket')->middleware('auth');
Route::get('checkout', [BasketController::class,'checkout'])->name('checkout')->middleware('auth');
Route::delete('basket/{basket}', [BasketController::class,'delete_basket'])->name('delete-basket')->middleware('auth');
Route::get('change-count-ajax', [BasketController::class,'change_count'])->name('change.count.ajax')->middleware('auth');


//commerce
Route::post('basket-pay', [BasketController::class,'pay'])->name('basket.pay')->middleware('auth');;
Route::get('go-to-bank/{price}', [BasketController::class,'goToBank'])->name('basket.bank')->middleware('auth');;
Route::post ('payment-status', [BasketController::class,'callback'])->name('callback');;
//Route::get ('payment-status', [BasketController::class,'callback'])->name('getCallback');;

Route::post ('rate', [RateController::class,'rate'])->name('rate');;

Route::resource('comment', CommentController::class)->only('index','store','update');
Route::post ('comment-answer', [CommentController::class,'answer'])->name('answer');

Route::any('search/city/{city}', [SearchController::class,'action'])->name('search.action');

Route::any('ajax-search/city/{city}',  [SearchController::class,'ajaxSearch'])->name('ajax.search');



