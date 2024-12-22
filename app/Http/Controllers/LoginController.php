<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\RoleUser;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function index2()
    {
        return view('auth.selectedRole');
    }

    public function login(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'password' => 'required',
            'role' => 'required'
        ]);

        $credentials = $request->only('id', 'password');

        $user = User::where('id', $request->id)->first();
        if(!$user){
            return redirect("/login")->with('LoginFailed2', 'Username atau password salah.');
        }

        $userId = $user->id;
        $request->session()->put('user_id', $userId);
        $request->session()->put('role', $request->role);
        $roleFound = false;

        foreach ($user->roles as $role) {
            if ($role->name == $request->role) {
                $roleFound = true;
                break;
            }
        }

        if (!$roleFound) {
            return redirect("/login")->with('SelectedRoleFailed', 'Maaf, Anda tidak memiliki hak akses untuk mengakses halaman ini.');
        }

        if (Auth::attempt($credentials)) {
            $request->session()->put('user_id', $userId);
            $request->session()->put('role', $request->role);
            $roleName = $request->input('role');

            if ($roleName === 'Kaprodi') {
                return redirect()->intended('/k/delegasi-tugas');
            }

            if ($roleName === 'Sekprodi') {
                return redirect()->intended('/s/delegasi-tugas');
            }

            if ($roleName === 'Kalab') {
                return redirect()->intended('/kl/delegasi-tugas');
            }

            if ($roleName === 'AdHoc') {
                return redirect()->intended('/ah/delegasi-tugas');
            }

            if ($roleName === 'Dosen') {
                return redirect()->intended('/d/tugas-masuk');
            }

            if ($roleName === 'Staf') {
                return redirect()->intended('/st/tugas-masuk');
            }
            if ($roleName == 'Admin') {
                return redirect("/admin");
            }
        } else {
            return redirect("/login")->with('LoginFailed2', 'Username atau password salah.');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
