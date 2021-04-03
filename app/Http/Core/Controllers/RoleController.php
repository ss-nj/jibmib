<?php

namespace App\Http\Core\Controllers;

use App\Http\Core\Models\Permission;
use App\Http\Core\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Core\Models\User;
use App\Support\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    //list alla roles
    public function index()
    {
//        if (!Auth::user()->can('read-role')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }

        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();
        return view('panel.roles.index', compact('roles','permissions'));

    }

    public function store(Request $request)
    {
//        if (!Auth::user()->can('create-role')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }

        $request->validate([
            'name' => 'unique:roles|required|string|min:5|max:254',
            'display_name' => 'unique:roles|required|string|min:5|max:254',
        ]);
        Role::create($request->all());

      return  JsonResponse::sendJsonResponse(1,'موفق',
          'با موفقیت ثبت گردید','REFRESH',route('roles.index'));


    }

    /**
     * @param Request $request
     * @param Role $role
     */
    public function update(Request $request, Role $role)
    {
//        dd($role);
//        if (!Auth::user()->can('update-role')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }

        $request->validate([
            'name' => 'required|string|min:5|max:254|unique:roles,name,' . $role->id,
            'display_name' => 'required|string|min:5|max:254|unique:roles,display_name,' . $role->id,
        ]);

        $role->update($request->all());

        return  JsonResponse::sendJsonResponse(1,'موفق',
            'با موفقیت ویرایش گردید','REFRESH');
    }

    public function destroy(Role $role)
    {
//        if (!Auth::user()->can('delete-role')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }

        //laratrust automaticaly delete relations
        $role->delete();


        return  JsonResponse::sendJsonResponse(1,'موفق',
            'با موفقیت حذف گردید','REFRESH');
    }

    //sync role permissions
    public function sync(Request $request, Role $role)
    {
//        if (!Auth::user()->can('update-role')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }

        $role->permissions()->sync($request->permissions);
        return back();
    }

    public function ajaxEdit(Role $role)
    {
//        dd($role);
//        if (!Auth::user()->can('read-users')) {
////            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//            return response()->json(['message'=>'عدم دسترسی کافی'],419);
//        }


        return view('panel.roles.role-edit', compact('role'))->render();
    }

}
