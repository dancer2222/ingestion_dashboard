<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreatePermission;
use App\Http\Requests\DeletePermission;
use App\Http\Requests\EditPermission;
use App\Models\Role;
use App\Models\Permission;
use App\Http\Controllers\Controller;
use Exception;

class PermissionsController extends Controller
{
    /**
     * Show permissions list
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list()
    {
        $permissions = Permission::all();

        return view('admin.permissions.list', [
            'permissions' => $permissions,
        ]);
    }

    /**
     * Show edit permission view
     *
     * @param string $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showEdit(string $id)
    {
        $permission = Permission::find($id);

        return view('admin.permissions.edit', [
            'permission' => $permission,
        ]);
    }

    /**
     * Edit role
     *
     * @param EditPermission $request
     * @param string $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function edit(EditPermission $request, string $id)
    {
        try {
            $permission = Permission::findOrFail($id);

            if ($request->has('name')) {
                $permission->name = $request->name;
            }

            if ($request->has('display_name')) {
                $permission->display_name = $request->display_name;
            }

            if ($request->has('description')) {
                $permission->description = $request->description;
            }

            return redirect()->back()->with('status', $permission->save());
        } catch (Exception $e) {
            return redirect()->back()->withErrors([
                'any' => 'An error occurred while editing permission.',
            ]);
        }
    }

    /**
     * Show create role view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showCreate()
    {
        return view('admin.permissions.create', [
            'roles' => Role::all(),
            'permissions' => Permission::all(),
        ]);
    }

    /**
     * Create a permission
     *
     * @param CreatePermission $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function create(CreatePermission $request)
    {
        try {
            $permission = new Permission();
            $permission->name = $request->name;
            $permission->display_name = $request->display_name;
            $permission->description = $request->description;

            return redirect()->route('admin.permissions.list')->with('status', $permission->save());
        } catch (Exception $e) {
            return redirect()->back()->withErrors([
                'any' => 'An error occurred while creating permission.',
            ]);
        }
    }

    /**
     * Delete a permission
     *
     * @param DeletePermission $request
     * @param string $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function delete(DeletePermission $request, string $id)
    {
        try {
            return redirect()->route('admin.permissions.list')->with('status', Permission::destroy($id));
        } catch (Exception $e) {
            return redirect()->back()->withErrors([
                'any' => 'An error occurred while deleting role.',
            ]);
        }
    }
}
