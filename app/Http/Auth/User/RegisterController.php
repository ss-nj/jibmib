<?php

namespace App\Http\Auth\User;

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


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegisterForm()
    {
        return view('auth.user.register');
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
            'first_name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'digits:11', 'unique:users,mobile'],
            'invite_id' => ['nullable', 'exists:users,affiliate_code'],
            'policy' => ['required', 'integer', 'in:1'],
            'password' => ['required', 'string', 'min:6'],
        ]);
    }

    public function register(Request $request)
    {

        $this->validator($request->all())->validate();

        $reg_sms = Setting::where('key', 'register_sms')->first();
        if ($reg_sms && $reg_sms->value_fa == 0) {
            return $this->registerLogin($request);
        }

        $request->merge([
            'code' => fa_to_en($request->code),
        ]);

        $retry = Session::get('retry-time');

//todo check this code posibly a bug
        if (!$request->code && $retry && $retry > now())
            return JsonResponse::sendJsonResponse(1, 'خطا',
                'در هر دو دقیقه تنها یک بار میتوانید در خواست ارسال کد تایید بدهید', '', '',
                'verifySent');

        if ($request->request_verify) {
            return $this->sendCode($request);
        }

        $request->validate([
            'code' => 'required|numeric',
        ]);

        $mobile = Session::get('mobile');
        $code = Session::get('code');

        if ($request->code != $code || $request->mobile != $mobile) {
            return JsonResponse::sendJsonResponse(0, 'خطا',
                sprintf('کد وارد شده برای شماره موبایل شما %s صحیح نمیباشد', $request->code));
        }

        return $this->registerLogin($request);

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

    public function sendSmsWithPattern($code, $name, $mobile)
    {

        $message = array("code" => $code, "name" => $name);
        $sms = new Sms();
        $result = $sms->sendwithpattern($message, $mobile, 'pspw1iusg0');
        return $result;
    }

    /**
     * @param Request $request
     * @return false|string
     */
    public function registerLogin(Request $request)
    {
        event(new Registered($user = $this->create($request->all())));
        $this->guard()->login($user);

        return JsonResponse::sendJsonResponse(1, 'موفق', 'کاربر گرامی شما با موفقیت به عضویت جیب میب در آمدید',
            'REDIRECT', route('home'));
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

}
