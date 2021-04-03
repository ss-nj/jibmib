<?php

namespace App\Http\Auth\User;

use App\Http\Controllers\Controller;
use App\Http\Core\Models\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function forgetPassword(Request $request)
    {
        $request->validate([
            'mobile' => 'required|digits:11'
        ], [
            'mobile.digits' => 'موبایل را بصورت 11 رقمی وارد کنید.',
            'mobile.required' => 'موبایل را وارد کنید.'
        ]);

        $user = User::where('mobile', $request->mobile)->first();
        if (!$user) {
            return back()->with('error-message', 'کاربری با موبایل وارد شده یافت نشد!');
        }

        $user->verify_mobile_code = rand(11111, 99999);
        $user->mobile_verified_at = null;
        $user->save();

        event(new forgotPasswordEvent($user->verify_mobile_code,$user->mobile));
        Auth::login($user);

        return redirect()->to(route('verify.mobile.form'));
//        return view('user.auth.verify-mobile', compact('user'));

    }


}
