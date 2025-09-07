<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function index()
    {
        $system_admins = User::system_admins();
        $users = User::all();
        return view('admin.layouts.pages.user-management.index', compact('system_admins', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'phone' => ['required', 'regex:/^(?:\+?88)?01[3-9]\d{8}$/'],
                'password' => 'required|min:6',
                'system_admin' => 'required|string',
            ],
            [
                'phone.regex' => 'Please enter a valid Bangladeshi phone number.',
            ],
        );

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'system_admin' => $request->system_admin,
            'password' => bcrypt($request->password),
            'can_view' => $request->has('can_view') ? 1 : 0,
            'can_add' => $request->has('can_add') ? 1 : 0,
            'can_edit' => $request->has('can_edit') ? 1 : 0,
            'can_delete' => $request->has('can_delete') ? 1 : 0,
        ]);

        return response()->json(['success' => true, 'user' => $user]);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $system_admins = User::system_admins();
        return view('admin.layouts.pages.user-management.edit', compact('user', 'system_admins'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => ['required', 'regex:/^(?:\+?88)?01[3-9]\d{8}$/'],
            'system_admin' => 'required|string',
            'password' => 'nullable|min:6',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->system_admin = $request->system_admin;

        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        $user->can_view = $request->can_view ? 1 : 0;
        $user->can_add = $request->can_add ? 1 : 0;
        $user->can_edit = $request->can_edit ? 1 : 0;
        $user->can_delete = $request->can_delete ? 1 : 0;

        $user->save();

        return redirect()->route('admin.user.management.index')->with('success', 'User updated successfully!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if (!$user) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'No user Found',
                ],
                404,
            );
        }

        $user->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'User deleted successfully.',
        ]);
    }
}
