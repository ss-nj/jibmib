<?php

namespace App\Http\Auth\User;

use App\Http\Controllers\Controller;
use App\Http\Core\Models\User;
use App\Services\Sms;
use App\Support\JsonResponse;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * show forgotten password form
     *
     */
    public function forgotPasswordForm()
    {
        return view('auth.user.forgotten-password');
    }

    /**
     * check mobile and change password
     *
     */
    public function forgotPassword(Request $request)
    {


        $request->validate([
            'mobile' => ['required', 'digits:11', 'exists:users,mobile'],
        ]);

//        $retry = Session::get('retry-time');
//
//        if (!$request->code && $retry && $retry > now())
//            return JsonResponse::sendJsonResponse(1, 'خطا',
//                'در هر دو دقیقه تنها یک بار میتوانید در خواست ارسال کد تایید بدهید', '', '',
//                'verifySent');

        if ($request->request_verify) {
            return $this->sendCode($request);
        }
        $request->merge([
            'code' => fa_to_en($request->code),
        ]);
        $request->validate([
            'code' => 'required|numeric',
        ]);

        $mobile = Session::get('mobile');
        $code = Session::get('code');

        if ($request->code != $code || $request->mobile != $mobile) {
            return JsonResponse::sendJsonResponse(1, 'خطا',
                sprintf('کد وارد شده برای شماره موبایل شما %s صحیح نمیباشد', $request->code));
        }

        if (!$request->password){
            return JsonResponse::sendJsonResponse(1, 'موفق',
                ' رمز جدید خود را وارد کنید', '', '',
                'showPasswordInput', [$request->mobile]);
        }

        $request->validate([
            'password' => ['required', 'string', 'min:6'],
        ]);

        $user = User::where('mobile', $mobile)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        return JsonResponse::sendJsonResponse(1, 'موفق',
            'رمز عبور شما با موفقبت تغییر کرد .شما میتوانید با استفاده از فرم لاگین به سایت وارد شوید',
            'REDIRECT', route('login.form'));



    }

    /**
     * @param Request $request
     * @return false|string
     */
    public function sendCode(Request $request)
    {
        $request->session()->put('mobile', $request->mobile);

        $code = rand(11111, 99999);
        session()->put('code', $code);
        session()->put('retry-time', now()->addMinutes(2));

        if (!$this->sendSmsWithPattern($code, $request->first_name, $request->mobile))
            return JsonResponse::sendJsonResponse(1, 'خطا',
                ' مشکلی پیش آمده دوباره تلاش کنید در صورت تکرار با پشتیبانی تماس بگیرید');

        return JsonResponse::sendJsonResponse(1, 'موفق',
            'کد تایید برای شماره موبایل ثبت شده ارسال گردید', '', '',
            'verifySent', [$request->mobile]);
    }

    public function sendSmsWithPattern($code, $name, $mobile)
    {

        $message = array("code" => $code, "name" => $name);
        $sms = new Sms();
        $result = $sms->sendwithpattern($message, $mobile, 'pspw1iusg0');
        return $result;
    }

}
