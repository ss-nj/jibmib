<?php

namespace App\Http\Core\Controllers;

use App\Http\Core\Models\Permission;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
    //list alla roles
    public function index()
    {
        $permissions = Permission::all();
        return view('panel.permissions.index', compact('permissions'));

    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'unique:permissions|required|string|min:5|max:254',
            'display_name' => 'unique:permissions|required|string|min:5|max:254',
        ]);
        Permission::create($request->all());

        return redirect()->route('permissions.index');

    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|string|min:5|max:254|unique:permissions,name,'.Auth::id(),
            'display_name' => 'required|string|min:5|max:254|unique:permissions,display_name,'.Auth::id(),
        ]);

        $permission->update($request->all());
        return redirect()->route('permissions.index');

    }

    public function destroy(Permission $permission)
    {
//        dd($permission);
        //todo manage assaigned users
        $permission->delete();
        return redirect()->route('permissions.index');

    }
}
