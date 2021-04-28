<?php

namespace App\Http\Auth\Shop;

use App\Http\Controllers\Controller;
use App\Http\Core\Models\Setting;
use App\Http\Core\Models\User;
use App\Services\Sms;
use App\Support\BasketHelpers;
use App\Support\JsonResponse;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        dd(1);
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        if (!session()->has('url.intended')) {
            session(['url.intended' => url()->previous()]);

        }

        return view('auth.user.login');
    }

    public function login(Request $request)
    {

        $this->getValidate($request);

        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $user = User::where('mobile', $request->mobile)->first();
        //user not found
        if (!$user) {
            return JsonResponse::sendJsonResponse(1, 'موفق', 'موبایل یا رمز عبور نادرست میباشد، مجددا تلاش کنید.');
        }
        //user not active
        if ($user->active === 0) {
            return JsonResponse::sendJsonResponse(1, 'موفق',
                'حساب کاربری شما توسط مدیریت مسدود میباشد، با پشتیبانی سایت تماس بگیرید.');
        }

        //mobile isn't verifies
        if (!$user->mobile_verified_at) {
            //            auth()->login($user);
            $request->session()->put('mobile', $user->mobile);

            return JsonResponse::sendJsonResponse(1, 'موفق',
                'موبایل شما تایید نشده است. شما میتوانید از بازیابی رمز عبور استفاده کنید .');

        }

        $credentials = $request->only('mobile', 'password');
        if (!auth()->guard('user')->attempt($credentials, $request->remember)) {
            return JsonResponse::sendJsonResponse(1, 'موفق', 'موبایل یا رمز عبور نادرست میباشد، مجددا تلاش کنید.');
        }

        return $this->redirect_map();

    }

    public function sendsmsWithPattern($code, $mobile)
    {

        $message = array("verification-code" => $code);
        $sms = new Sms();
        $result = $sms->sendwithpattern($message, $mobile, '06bnqaqeiq');
        return $result;
    }

    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect()->to('/');
    }

    /**
     * @return false|\Illuminate\Http\RedirectResponse|string
     */
    public function redirect_map()
    {
        try {
            BasketHelpers::setSessionCartToDatabase();
        }catch (\Exception $exception){
            Log::alert($exception);
        }
        if (Auth::user()->hasRole(['super_administrator'])) {
            $reg_redirect = Setting::where('key', 'login_admin_redirect_path')->first();
            $route = Setting::MAP_ADMIN_LOGIN_REDIRECTS[$reg_redirect->value_fa];
        } else {
            $reg_redirect = Setting::where('key', 'login_redirect_path')->first();
            $route = Setting::MAP_LOGIN_REDIRECTS[$reg_redirect->value_fa];
        }

        $intended = Setting::where('key', 'login_redirect_intended')->first();

        if ($intended->value_fa) {
            $route = Session::get('url.intended', $route);
            Session::forget('url.intended');

            return JsonResponse::sendJsonResponse(1, 'موفق', 'کاربر گرامی شما با موفقیت وارد شدید',
                'REDIRECT', route($route));
        }

        return JsonResponse::sendJsonResponse(1, 'موفق', 'کاربر گرامی شما با موفقیت وارد شدید',
            'REDIRECT', route($route));


    }

    /**
     * @param Request $request
     */
    public function getValidate(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:6',
            'mobile' => 'required|digits:11',
        ], [
            'password.required' => 'رمز عبور الزامی است.',
            'password.string' => 'رمز عبور نامعتبر میباشد.',
            'password.min' => 'تعداد حروف رمز عبور حداقل 6 کاراکتر میباشد.',
            'mobile.required' => 'موبایل الزامی است.',
            'mobile.digits' => 'موبایل باید بصورت عددی و 11 رقمی باشد.',
        ]);
    }
}
