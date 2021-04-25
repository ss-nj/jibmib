<?php

namespace App\Http\Auth\Shop;

use App\Http\Controllers\Controller;
use App\Http\Core\Models\Setting;
use App\Http\Core\Models\User;
use App\Services\Sms;
use App\Support\JsonResponse;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = 'Profile';

    protected function redirectTo()
    {

        if (Auth::check()) {
            $user = Auth::user();

        } else {
            $mobile = Session::get('mobile');
            $user = User::where('mobile', $mobile)->first();
        }

        JsonResponse::sendJsonResponse(0,'خطا','مشکلی پیامده دوباره تلاش کنید','REDIRECT',route('home'));


        $code = User::where('mobile', $user->mobile)->select('verify_mobile_code')->first();
        $code = $code->verify_mobile_code;

        $this->sendsmsWithPattern($code, $user->mobile);

        JsonResponse::sendJsonResponse(1,'موفق','کد تایید برای شماره موبایل ثبت شده ارسال گردید','REDIRECT',route('verify.mobile.form'));

    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
//        dd(4);
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

    public function register(Request $request)
    {
//        dd($request);
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));
        $reg_sms = Setting::where('key', 'register_sms')->first();
        if ($reg_sms->value_fa == 0) {
            $this->guard()->login($user);
        } else {
            $request->session()->put('mobile', $request->mobile);
        }
        return redirect($this->redirectTo());
    }



    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
//            'first_name' => ['required', 'string', 'max:255'],
//            'last_name' => ['required', 'string', 'max:255'],
//            'email' => ['nullable', 'string', 'email', 'max:255'],
            'mobile' => ['required', 'digits:11', 'unique:users,mobile'],
            'invite_id' => ['nullable', 'exists:users,affiliate_code'],
//            'password' => ['required', 'string', 'min:6'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return User
     */
    protected function create(array $data)
    {
        if (isset($data['invite_id']))
            $user = User::where('affiliate_code', $data['invite_id'])->first();
        return User::create([
            'first_name' => $data['first_name'] ?? '',
            'last_name' => $data['last_name'] ?? '',
            'affiliate_code' => $this->generateAffLink(),
            'mobile' => $data['mobile'],
            'parent_id' => isset($user) ? $user->id : null,
            'verify_mobile_code' => rand(11111, 99999),
            'password' => Hash::make($data['password']),
        ]);
    }

    private function generateAffLink()
    {
        do {
            $code = rand(1111111, 9999999);
            $status = User::where('affiliate_code', $code)->count();
        } while ($status);

        return $code;


    }


    public function sendsmsWithPattern($code, $mobile)
    {

        $message = array("verification-code" => $code);
        $sms = new Sms();
        $result = $sms->sendwithpattern($message, $mobile, '06bnqaqeiq');
        return $result;
    }

}
