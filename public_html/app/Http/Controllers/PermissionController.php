<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use DB;

class PermissionController extends Controller
{
    function __construct()
    {
        $this->middleware(['permission:permissions-list'], ['only' => ['index']]);
        $this->middleware(['permission:permissions-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:permissions-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:permissions-delete'], ['only' => ['destroy']]);
    }

    public function index()
    {
        //$permissions = Permission::paginate(50);
        $permissions = auth()->user()->getAllPermissions();
        return view('admin.permissions.index', ['permissions' => $permissions]);
    }

    public function create()
    {
        return view('admin.permissions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'unique:permissions,name'
            ]
        ]);

        Permission::create([
            'name' => $request->name
        ]);

        return redirect(route('permissions.create'))->with('success','Permission Created Successfully');
    }

    public function edit(Permission $permission)
    {
        return view('admin.permissions.edit', ['permission' => $permission]);
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'unique:permissions,name,'.$permission->id
            ]
        ]);

        $permission->update([
            'name' => $request->name
        ]);

        return redirect(route('permissions.index'))->with('success','Permission Updated Successfully');
    }

    public function destroy($permissionId)
    {
        $permission = Permission::find($permissionId);
        $permission->delete();
        return redirect(route('permissions.index'))->with('success','Permission Deleted Successfully');
    }
}