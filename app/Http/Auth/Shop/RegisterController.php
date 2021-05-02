<?php

namespace App\Http\Auth\Shop;

use App\Http\Controllers\Controller;
use App\Http\Core\Models\Setting;
use App\Http\Core\Models\User;
use App\Http\Shop\Models\Shop;
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
    protected $redirectTo = 'home';


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

        return view('auth.shop.register');
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
            'owner_name' => ['required', 'string', 'max:255'],
            'shop_name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'digits:11', 'unique:shops,phone'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'place_id' => ['required', 'integer', 'exists:places,id'],
            'policy' => ['required', 'integer', 'in:1'],
            'password' => ['required', 'string', 'min:6'],
        ]);
    }

    public function register(Request $request)
    {

        $this->validator($request->all())->validate();

        $reg_sms = Setting::where('key', 'register_sms')->first();
        if ($reg_sms && $reg_sms->value_fa == 0) {
            return $this->registerlogin($request);
        }

        $request->merge([
            'code' => fa_to_en($request->code),
        ]);

        $retry = Session::get('retry-time');

//todo check this code possibly a bug
        if (!$request->code && $retry && $retry > now())
            return JsonResponse::sendJsonResponse(0, 'خطا',
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
            return JsonResponse::sendJsonResponse(1, 'خطا',
                sprintf('کد وارد شده برای شماره موبایل شما %s صحیح نمیباشد', $request->code));
        }

        return $this->registerlogin($request);

    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return User
     */
    protected function create(array $data)
    {
        return Shop::create([
            'owner_name' => $data['owner_name'] ,
            'shop_name' => $data['shop_name'] ,
            'phone' => $data['mobile'],
            'category_id' => $data['category_id'],
            'place_id' => $data['place_id'],
            'password' => Hash::make($data['password']),
        ]);
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
    public function registerlogin(Request $request)
    {
        event(new Registered($user = $this->create($request->all())));
        Auth::guard('shop')->login($user);

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
