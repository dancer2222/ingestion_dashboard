<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateUser;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\User;
use App\Http\Requests\EditUser;
use Exception;
use App\Models\Role;
use App\Models\Permission;


class UsersController extends Controller
{
    /**
     * Show index view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list()
    {
        $users = User::all();

        return view('admin.users.list', [
            'users' => $users,
        ]);
    }

    /**
     * Show edit user view
     *
     * @param string $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showEdit(string $id)
    {
        return view('admin.users.edit', [
            'user' => User::find($id),
            'roles' => Role::all(),
            'permission' => Permission::all(),
        ]);
    }

    /**
     * Edit user
     *
     * @param EditUser $request
     * @param string $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function edit(EditUser $request, string $id)
    {
        try {
            $user = User::findOrFail($id);

            if ($request->has('name')) {
                $user->name = $request->name;
            }

            if ($request->has('email')) {
                $user->email = $request->email;
            }

            if ($request->has('password')) {
                $user->password = Hash::make($request->password);
            }

            if ($request->has('roles')) {
                $user->roles()->sync($request->roles);
            }

            return redirect()->back()->with('status', $user->save());
        } catch (Exception $e) {
            return redirect()->back()->withErrors([
                'any' => 'An error occurred while saving user.',
            ]);
        }
    }

    /**
     * Show create user view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showCreate()
    {
        return view('admin.users.create', [
            'roles' => Role::all(),
            'permission' => Permission::all(),
        ]);
    }

    /**
     * Create a user
     *
     * @param CreateUser $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function create(CreateUser $request)
    {
        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);

            $result = $user->save();

            if ($request->has('roles') && $result) {
                $user->roles()->sync($request->roles);
            }

            return redirect()->route('admin.users.list')->with('status', $result);
        } catch (Exception $e) {
            return redirect()->back()->withErrors([
                'any' => 'An error occurred while creating user.',
            ]);
        }
    }

    /**
     * Delete a user
     *
     * @param string $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function delete(string $id)
    {
        try {
            return redirect()->route('admin.users.list')->with('status', User::destroy($id));
        } catch (Exception $e) {
            return redirect()->back()->withErrors([
                'any' => 'An error occurred while deleting user.',
            ]);
        }
    }
}
