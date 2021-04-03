<?php

namespace App\Http\Core\Controllers;

use App\DataTables\UsersDataTable;
use App\Http\Controllers\Controller;
use App\Http\Core\Models\City;
use App\Http\Core\Models\Image;
use App\Http\Core\Models\Permission;
use App\Http\Core\Models\Province;
use App\Http\Core\Models\Role;
use App\Http\Core\Models\User;
use App\Support\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * @var array
     */
    private $defaultOption;
    /**
     * @var \Illuminate\Database\Eloquent\Builder
     */
//    private $entity;

    public function __construct()
    {
        $this->defaultOption = [
            'size' => ['width' => 500, 'height' => 500],
            'watermark' => false,
            'changesize' => true,
            'dir' => 'img/users'
        ];

    }

    public function ajaxEdit(User $user)
    {
//        if (!Auth::user()->can('read-users')) {
////            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//            return response()->json(['message'=>'عدم دسترسی کافی'],419);
//        }

        $roles = Role::all();
        $provincies = DB::table('provinces')->get();
        $cities = DB::table('cities')->get();

        return view('panel.users.user-edit', compact('user', 'roles', 'provincies', 'cities'))->render();
    }

    public function ajaxPermission(User $user)
    {
//        if (!Auth::user()->can('read-users')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }

        $permissions = Permission::all();

        return view('panel.users.edit-permissions', compact('user', 'permissions'))->render();
    }

    public function index(Request $request)
    {
//        dd(Supplier::find(1)->is_in_time);
//        if (!Auth::user()->can('read-users')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }
        $users = User::latest()->with('roles', 'image')->get();
        $roles = Role::all();

        $query = User::with('roles', 'image');

//        $query->addSelect( [DB::raw("CONCAT(COALESCE(users.first_name,'),' ',COALESCE(users.last_name,')) AS full_name")]);


        if ($request->searchById) {
            $query->where('id', 'LIKE', '%' . $request->searchById . '%');
        }

        if ($request->searchByName) {
            $query->where('first_name', 'LIKE', '%' . $request->searchByName . '%');
        }
        if ($request->searchByFamily) {
            $query->where('last_name', 'LIKE', '%' . $request->searchByFamily . '%');
        }
        if ($request->searchByMobile) {
            $query->where('users.mobile', 'LIKE', '%' . $request->searchByMobile . '%');
        }
        if ($request->searchByWallet) {
            $query->where('wallet', '>', $request->searchByWallet);
        }
        if (isset($request->searchByStatus)) {
            $query->where('active', $request->searchByStatus);
        }
        if ($request->searchByAddress) {
            $query->whereHas('address', function ($query) use ($request) {
                $query->where('address', 'LIKE', '%' . $request->searchByAddress . '%');
            });
        }
        if ($request->searchByRole) {
            $query->whereHas('roles', function ($query) use ($request) {
                $query->where('id', $request->searchByRole);
            });
        }

        if ($request->searchByAscDesc) {
            $ascDesc = $request->searchByAscDesc;

        } else {
            $ascDesc = 'DESC';
        }

        if ($request->searchSortBy) {
            $searchSortBy = $request->searchSortBy;
            if ($ascDesc == 'DESC')
                $query->latest($searchSortBy);
            else
                $query->oldest($searchSortBy);

        } else
            $query->latest('created_at');

//dd($query->get());
        $datatable = new UsersDataTable($query);

        return $datatable->render('panel.users.index', compact('users', 'roles'));
    }

    public function show(User $user)
    {
//        if (!Auth::user()->can('read-users')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }
//dd($user,$user->address);
        $provinces = Province::all();
        $cities = City::all();

        return view('panel.users.show', compact('user', 'provinces', 'cities'));

    }

    public function store(Request $request)
    {
//        if (!Auth::user()->can('create-users')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }
        $request->validate([
            'first_name' => ['required','string', 'min:3', 'max:255'],
            'last_name' => ['nullable', 'string', 'min:3', 'max:255'],
            'email' => ['nullable', 'string', 'min:1', 'max:255', 'regex:/^.+@.+$/i', 'unique:users'],
            'mobile' => ['required','regex:/[0-9]{10}/', 'digits:11', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);


//register user
        $user = User::create([
            'first_name' => $request['first_name']??'',
            'last_name' => $request['last_name']??'',
            'mobile' => $request['mobile'],
            'password' => Hash::make($request['password']),
            'affiliate_code' => rand(1111111, 9999999),
            'verify_mobile_code' => rand(11111, 99999),
            'mobile_verified_at' => now(),
        ]);


        $user->roles()->sync($request->roles);

        return JsonResponse::sendJsonResponse(1, 'موفق', sprintf('کوپن  %s  با موفقیت ثبت گردید', $user->name),
            'DATATABLE_REFRESH');

    }


    //sync role permissions
    public function sync(Request $request, User $user)
    {
//        if (!Auth::user()->can('update-users')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }
        $user->permissions()->sync($request->permissions);

        return back();
    }

    public function update(Request $request, User $user)
    {
//        dd($request->all(),$user);
//        if (!Auth::user()->can('update-users')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }
        $request->validate([
            'first_name' => ['required','string', 'min:3', 'max:255'],
            'last_name' => ['nullable', 'string', 'min:3', 'max:255'],
            'email' => ['nullable', 'string', 'min:1', 'max:255', 'regex:/^.+@.+$/i', 'unique:users,email,' . $user->id],
            'mobile' => ['nullable','regex:/[0-9]{10}/', 'digits:11', 'unique:users,mobile,' . $user->id],
            'password' => ['nullable', 'string', 'min:8'],
            'address' => ['nullable', 'string', 'min:3', 'max:255'],
        ]);

//update user

//        if (Auth::user()->hasRole('super_administrator')) {
             $user->roles()->sync($request->roles);
            if ($request->password === null) $request->offsetUnset('password');

            if ($request->password) {
                 $user->password = Hash::make($request['password']);
                $user->save();
             }
            if ($request->wallet) {
                 $user->wallet = ($request['wallet']);
                $user->save();
             }
//        }
        $request->offsetUnset('password');
//        $request->offsetUnset('wallet');

        $user->update($request->all());

//        dd(1);
        //update user image
        if ($request->hasFile('main_image')) {
            try {
//                dd(1);
                $path = $user->image->path;
                $imageName = upload_image($request->file('main_image'), $this->defaultOption);
                //remove old image
                if ($path !== Image::NO_IMAGE_PATH) {
                    $user->image()->delete();
                    Image::removeImage($path);
                }
                $user->image()->create([
                    'path' => $imageName[0],
                    'thumbnail' => $imageName[1],
                    'title' => $request->name
                ]);
            } catch (\Exception $e) {
                Log::info($e);
            }
        }
        return JsonResponse::sendJsonResponse(1, 'موفق', sprintf('کوپن  %s  با موفقیت روز رسانی گردید', $user->name),
            'DATATABLE_REFRESH');
    }


    public function activeToggle(Request $request, User $user)
    {
//        if (!Auth::user()->can('update-users')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }

        $user->active = !$user->active;
        $user->save();
        if ($request->ajax()) return response()->json(['message' => 'با موفقیت ذخیره شد .', 'active' => $user->active]);

        return back();
    }


    public function removeImage($id)
    {
        //remove image
        //remove file
        $image = Image::findOrFail($id);
        $path = $image->path;
        $image->delete();
        if ($path) Image::removeImage($path);

    }

    public function register_address(Request $request)
    {
//        dd($request);
        $user = User::findOrFail($request->user_id);
        $request->validate([
            'mobile' => ['required', 'digits:11'],
            'province' => 'required|exists:provinces,id',
            'city_id' => 'required|exists:cities,id',
            'postal_code' => 'nullable|numeric',
            'address' => 'required',
        ], [
            'province.required' => 'انتخاب استان الزامی است.',
            'city_id.required' => 'انتخاب شهر الزامی است.',
            'address.required' => 'آدرس الزامی است.',
        ]);

        $result = $user->address()->create($request->all());
        if ($result)
            return back()->with('success-message', 'ثبت آدرس با موفقیت انجام شد.');
        else
            return back()->with('error-message', 'ثبت آدرس با خطا مواجه شد دوباره تلاش کنید!.');

    }

    public function edit_address(Request $request)
    {
//        dd($request->all());
        $request->validate([
            'address_id' => 'required',
            'city' => 'required',
            'postal_code' => 'nullable',
            'address' => 'required',
        ]);
        $user = User::findOrFail($request->user_id);

//        $address = Address::find($request->address_id);
//        $result = $address->update([
//            'city_id' => $request->city,
//            'postal_code' => $request->postal_code,
//            'address' => $request->address,
//        ]);
        $result = $user->address()->find($request->address_id)->update($request->all());

        if ($result)
            return back()->with('success-message', 'ویرایش با موفقیت انجام شد');
        else
            return back()->with('error-message', 'ویرایش با خطا مواجه شد!');
    }


}

