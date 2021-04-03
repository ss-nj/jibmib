<?php

namespace App\Http\Auth\User;

use App\Http\Controllers\Controller;
use App\Http\Core\Models\Setting;
use App\Http\Core\Models\User;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }


    public function verifyMobileForm()
    {
        return view('auth.verify-phone-number');
    }

    public function verifyMobile(Request $request)
    {
//        dd(1);
        //ریدایرکت بعد از لاگین و ویریفای کردن موبایل
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
        $this->guard()->login($user);

        $reg_redirect = Setting::where('key', 'register_redirect_path')->first();

        if ($reg_redirect == null)
            return back()
                ->withErrors(['alert_title' => 'خطا', 'alert_body' => 'مشکلی پیش امده']);
//assigne route from route map
        $route = Setting::MAP_REG_REDIRECTS[$reg_redirect->value_fa];

        return redirect()->route($route)
            ->withErrors(['alert_title' => 'موفق', 'alert_body' => 'با موفقیت وارد شدید']);;
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

    public function verifyMobilel(Request $request)
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

}
