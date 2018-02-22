<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateRole;
use App\Http\Requests\DeleteRole;
use App\Http\Requests\EditRole;
use App\Models\Role;
use App\Models\Permission;
use App\Http\Controllers\Controller;
use Exception;

class RolesController extends Controller
{
    /**
     * Show roles list
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list()
    {
        $roles = Role::all();

        return view('admin.roles.list', [
            'roles' => $roles,
        ]);
    }

    /**
     * Show edit role view
     *
     * @param string $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showEdit(string $id)
    {
        $role = Role::find($id);

        return view('admin.roles.edit', [
            'role' => $role,
            'rolePerms' => $role->perms()->get(),
            'permissions' => Permission::all(),
        ]);
    }

    /**
     * Edit role
     *
     * @param EditRole $request
     * @param string $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function edit(EditRole $request, string $id)
    {
        try {
            $role = Role::findOrFail($id);

            if ($request->has('name')) {
                $role->name = $request->name;
            }

            if ($request->has('display_name')) {
                $role->display_name = $request->display_name;
            }

            if ($request->has('description')) {
                $role->description = $request->description;
            }

            if ($request->has('permissions')) {
                $role->perms()->sync($request->permissions);
            }

            return redirect()->back()->with('status', $role->save());
        } catch (Exception $e) {
            return redirect()->back()->withErrors([
                'any' => 'An error occurred while editing role.',
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
        return view('admin.roles.create', [
            'roles' => Role::all(),
            'permissions' => Permission::all(),
        ]);
    }

    /**
     * Create a role
     *
     * @param CreateRole $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function create(CreateRole $request)
    {
        try {
            $role = new Role();
            $role->name = $request->name;
            $role->display_name = $request->display_name;
            $role->description = $request->description;

            $result = $role->save();

            if ($request->has('permissions') && $result) {
                $role->perms()->sync($request->permissions);
            }

            return redirect()->route('admin.roles.list')->with('status', $result);
        } catch (Exception $e) {
            return redirect()->back()->withErrors([
                'any' => 'An error occurred while creating role.',
            ]);
        }
    }

    /**
     * Delete a user
     *
     * @param DeleteRole $request
     * @param string $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function delete(DeleteRole $request, string $id)
    {
        try {
            return redirect()->route('admin.roles.list')->with('status', Role::destroy($id));
        } catch (Exception $e) {
            return redirect()->back()->withErrors([
                'any' => 'An error occurred while deleting role.',
            ]);
        }
    }
}
