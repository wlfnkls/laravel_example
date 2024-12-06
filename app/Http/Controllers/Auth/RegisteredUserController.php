<?php

namespace App\Http\Controllers\Auth;

use App\Models\Role;
use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Result;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;

class RegisteredUserController extends Controller
{

    public function ShowUserlist()
    {
        $users = User::all();
        return view('user.users')->with('users', $users);
    }

    public function ShowUsersFromSameCompany(Request $request)
    {
        $user = Auth::user();
        $companies = Company::all();

        if ($request->company_id) {
            $users = User::all()->where('company_id', $request->company_id);
            $results = Result::all()->where('company_id', $request->company_id);
        } else {
            $users = User::all()->where('company_id', $user->company_id);
            $results = Result::all()->where('company_id', $user->company_id);
        }
        return view('dashboard', compact('users', 'results', 'companies'));
    }

    public function create()
    {
        $roles = Role::all();
        $companies = Company::all();
        $departments = Department::all();
        return view('auth.register', compact('companies', 'roles', 'departments'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        if ($user->company_id != Auth::user()->company_id) {
            return 'NOPE';
        };

        $roles = Role::all();
        $companies = Company::all();
        $departments = Department::all();
        return view('user.edit', compact('user', 'companies', 'roles', 'departments'));
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
        ]);

        $user = User::findOrFail($id);

        $departementQ = Department::where('id', $request->department_id)->first();
        $departement = $departementQ != null ? $departementQ->name : '';
        $user->name = $request->get('name');
        $user->role_id = $request->role_id ? $request->role_id : $user->role_id;
        $user->email = $request->get('email');
        $user->company_id = $request->company_id ? $request->company_id : $user->company_id;
        $user->department_id = $request->department_id == '' ? NULL : $request->department_id;
        $user->department = $request->department == '' ? $departement : $request->department;
        $user->save();

        if (Auth::user()->role_id == '1') {
            return redirect(RouteServiceProvider::USERS)->with('status', 'User updated');
        }
        return redirect(RouteServiceProvider::HOME)->with('status', 'User updated');
    }

    public function store(Request $request)
    {
        $departementQ = Department::where('id', $request->department_id)->first();
        $departement = $departementQ != null ? $departementQ->name : '';
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);

        User::create([
            'company_id' => $request->company_id == '' ? $user->company_id : $request->company_id,
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id == '' ? '4' : $request->role_id,
            'department_id' => $request->department_id == '' ? NULL : $request->department_id,
            'department' => $request->department == '' ? $departement : $request->department,
            'password' => Hash::make($request->password),
        ]);

        if ($user->role_id == '1') {
            return redirect(RouteServiceProvider::USERS)->with('status', 'User created');
        }
        return redirect(RouteServiceProvider::HOME)->with('status', 'User created');
    }
}
