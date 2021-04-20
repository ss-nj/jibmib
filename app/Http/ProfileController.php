<?php

namespace App\Http;


use App\Http\Controllers\Controller;
use App\Http\Core\Models\Image;
use App\Http\Core\Models\Setting;
use App\Http\Core\Models\Ticket;
use App\Http\Core\Models\User;
use App\Http\Shop\Models\Takhfif;
use App\OrderItem;
use App\Rules\UuidCheck;
use App\Support\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    /**
     * @param $product
     * @return array
     */
    public function setDefualtOption($user): array
    {
        $defaultOption = [
            'size' => ['width' => 500, 'height' => 500],
            'watermark' => false,
            'changesize' => true,
            'dir' => 'img/users/' . $user->id
        ];
        return $defaultOption;
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {

        $user = auth()->user();
        $orders = OrderItem::with('takhfif')->where('user_id',auth()->id())->get();

        return view( 'front.profile', compact('user','orders'));
    }


    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param User $profile
     */
    public function update(Request $request, User $profile)
    {
        $request->validate([
            'first_name' => ['nullable','string', 'min:3', 'max:255'],
            'last_name' => ['nullable', 'string', 'min:3', 'max:255'],
            'email' => ['nullable', 'string', 'min:1', 'max:255', 'regex:/^.+@.+$/i', 'unique:users,email,' . auth()->id()],
            'mobile' => ['regex:/[0-9]{10}/', 'digits:11', 'unique:users,mobile,' . auth()->id()],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'city_id' => ['nullable', 'exists:cities,id'],
        ]);

//        dd($profile,$request->all());

        if ($request->hasFile('avatar')) {
//            try {
//                dd(1);
            $path = $profile->image->path;
            $imageName = upload_image($request->file('avatar'), $this->setDefualtOption($profile));
            //remove old image
            if ($path !== Image::NO_IMAGE_PATH) {
                $profile->image()->delete();
                Image::removeImage($path);
            }
            $profile->image()->create([
                'path' => $imageName[0],
                'thumbnail' => $imageName[1],
                'title' => $request->name
            ]);
//            } catch (\Exception $e) {
//                Log::info($e);
//            }
        }


        if ($request->password) {
            $profile->password = Hash::make($request['password']);
            $profile->save();
        }
        $request->offsetUnset('password');
        $request->offsetUnset('wallet');
        $profile->update($request->all());

        return JsonResponse::sendJsonResponse(1, 'موفق', 'ویرایش حساب کاربری با موفقیت انجام شد.',
        );


    }

    public function print($code)
    {

        $order = OrderItem::with('takhfif')->where('code',$code)->firstOrFail();
//dd($order);
        return view('front.belit-print',compact('order'));

    }

}
