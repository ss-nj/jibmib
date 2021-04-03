<?php

namespace App\Http\Auth\Shop;

use App\Http\Controllers\Controller;
use App\Http\Core\Models\Setting;
use App\Http\Core\Models\User;
use App\Services\Sms;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        if (!session()->has('url.intended')) {
            session(['url.intended' => url()->previous()]);

        }

        return view('auth.login');
    }

    public function login(Request $request)
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

        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $user = User::where('mobile', $request->mobile)->first();

        if (!$user) {
//            dd(1);
            return back()
                ->withErrors(['alert_title' => 'خطا', 'alert_body' => 'موبایل یا رمز عبور نادرست میباشد، مجددا تلاش کنید.']);

        }

        if ($user->active === 0) {
            return back()
                ->withErrors(['alert_title' => 'خطا', 'alert_body' => 'حساب کاربری شما توسط مدیریت مسدود میباشد، با پشتیبانی سایت تماس بگیرید.']);

        }

        if (!$user->mobile_verified_at) {
//            auth()->login($user);
            $request->session()->put('mobile', $user->mobile);

            return redirect()->route('verify.mobile.form')
                ->withErrors(['alert_title' => 'خطا', 'alert_body' => 'موبایل شما تایید نشده است. اگر کد برای شما ارسال نشده از بازیابی رمز عبور استفاده کنید .']);

        }

        $credentials = $request->only('mobile', 'password');
        if (!auth()->attempt($credentials, true)) {
//            dd(2);
            return back()
                ->withErrors(['alert_title' => 'خطا', 'alert_body' => 'موبایل یا رمز عبور نادرست میباشد، مجددا تلاش کنید.']);

        }

        return $this->redirect_map();


    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function showPasswordConfirmForm()
    {
        return view('auth.re-enter-password');
    }

    public function userConfirm(Request $request)
    {
//        dd($request->all());

        $user = User::where('mobile', $request->mobile)->first();
        if (!$user)
            return back()
                ->withErrors(['alert_title' => 'خطا', 'alert_body' => 'شما قبلا ثبت نام نکرده اید .']);

        $user->update([
            'verify_mobile_code' => rand(11111, 99999),

        ]);
        $code = $user->verify_mobile_code;
        $mobile = $request->mobile;
//        try {

        $this->sendsmsWithPattern($code, $mobile);

        Session::put('mobile', $mobile);
        return view('auth.forgotten-password-verify', compact('mobile'))
            ->withErrors(['alert_title' => 'موفق', 'alert_body' => 'کد فعال سازی برای تلفن همراه شما ارسال گردید']);

//        } catch (\Exception $exception) {
//            Log::channel('auth')->info($exception);
//            return '/';
//
//        }
        return redirect()->route('home');


    }

    public function sendsmsWithPattern($code, $mobile)
    {

        $message = array("verification-code" => $code);
        $sms = new Sms();
        $result = $sms->sendwithpattern($message, $mobile, '06bnqaqeiq');
        return $result;
    }

    public function verifyMobile(Request $request)
    {

        $request->validate([
            'code' => 'required'
        ]);
        $user = User::where('mobile', Session::get('mobile'))->first();

        if (!$user)
            return back()
                ->withErrors(['alert_title' => 'خطا', 'alert_body' => 'کاربر پیدا نشد لطفا از گزینه ی فراموشی رمز عبور استفاده کنید']);

        if ($user->verify_mobile_code != $request->code) {
            return back()
                ->withErrors(['alert_title' => 'خطا', 'alert_body' => 'کد وارد شده اشتباه است، مجددا تلاش کنید.']);

        }

        $reg_sms = Setting::where('key', 'register_sms')->first();
        if ($reg_sms->value_fa == 1 && $user->expire_date < now()->subMinutes(2)) {
            return back()
                ->withErrors(['alert_title' => 'خطا', 'alert_body' => 'کد وارد شده منقضی شده است ']);
        }

        $user->update([
            'mobile_verified_at' => now(),
            'verify_mobile_code' => rand(11111, 99999),
        ]);

        return view('auth.change-password');

    }

    public function newPassword(Request $request)
    {

        $request->validate([
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'password.required' => 'رمز عبور الزامی است.',
            'password.string' => 'رمز عبور نامعتبر میباشد.',
            'password.min' => 'تعداد حروف رمز عبور حداقل 6 کاراکتر میباشد.',
        ]);

        $user = User::where('mobile', Session::get('mobile'))->firstOrFail();

        $user->password = Hash::make($request['password']);
        $user->save();

        auth()->login($user, true);

        if ($user->active === 0) {
            return back()->with('error-message', 'حساب کاربری شما توسط مدیریت مسدود میباشد، با پشتیبانی سایت تماس بگیرید.');
        }

        if (!$user->mobile_verified_at) {
            return redirect()->route('verify.mobile.form')->with('error-message', 'موبایل شما تایید نشده است.');
        }

        return $this->redirect_map();

    }


    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect()->to('/');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirect_map(): \Illuminate\Http\RedirectResponse
    {
        if (Auth::user()->hasRole(['super_administrator'])) {
            $reg_redirect = Setting::where('key', 'login_admin_redirect_path')->first();
            $route = Setting::MAP_ADMIN_LOGIN_REDIRECTS[$reg_redirect->value_fa];
        } else {
            $reg_redirect = Setting::where('key', 'login_redirect_path')->first();
            $route = Setting::MAP_LOGIN_REDIRECTS[$reg_redirect->value_fa];
        }

        $intended = Setting::where('key', 'login_redirect_intended')->first();

        if ($intended->value_fa)
            return redirect()->intended($route)
                ->withErrors(['alert_title' => 'موفق', 'alert_body' => 'کاربر گرامی شما با موفقیت وارد شدید']);

        return redirect()->route($route)
            ->withErrors(['alert_title' => 'موفق', 'alert_body' => 'کاربر گرامی شما با موفقیت وارد شدید']);
    }
}
