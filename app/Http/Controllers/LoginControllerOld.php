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
        if (Auth::check()) {
            $defaultRoleName = Auth::user()->roles[0]->name;
            if ($defaultRoleName == "Kaprodi") {
                return redirect("/k/delegasi-tugas");
            }
            if ($defaultRoleName == "Sekprodi") {
                return redirect("/s/delegasi-tugas");
            }
            if ($defaultRoleName == "Kalab") {
                return redirect("/kl/delegasi-tugas");
            }
            if ($defaultRoleName == "AdHoc") {
                return redirect("/ah/delegasi-tugas");
            }
            if ($defaultRoleName == "Dosen") {
                return redirect("/d/tugas-masuk");
            }
            if ($defaultRoleName == "Staf") {
                return redirect("/st/tugas-masuk");
            }
            if ($defaultRoleName == "Admin") {
                return redirect("/admin");
            }
        }
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
        // $userId2 = $request->session()->get('user_id');
        // dd($userId2);

        $roleFound = false;

        // if(!$user){
        //     return redirect("/login")->with('LoginFailed2', 'Username atau password salah.');
        // }

        foreach ($user->roles as $role) {
            if ($role->name == $request->role) {
                $roleFound = true;
                break;
            }
        }

        if (!$roleFound) {
            // $errorMessage = "User ini tidak memiliki role " . $request->role;
            return redirect("/login")->with('SelectedRoleFailed', 'Maaf, Anda tidak memiliki hak akses untuk mengakses halaman ini.');
        }

        if (Auth::attempt($credentials)) {
            $request->session()->put('user_id', $userId);
            $request->session()->put('role', $request->role);
            // Login berhasil, sekarang cek role pada tabel 'roles'
            $roleName = $request->input('role');
            // dd($roleName);

            // Redirect sesuai role
            if ($roleName === 'Kaprodi') {
                return redirect()->intended('/k/delegasi-tugas');
            }

            // if ($roleName === 'Kaprodi') {
            //     return redirect()->intended('/kaprodi/delegasi-tugas');
            // }

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
            // Login gagal
            return redirect("/login")->with('LoginFailed2', 'Username atau password salah.');
        }




        // return 'Pengguna valid';


        //     $user = Auth::user();
        //     $roleId = $request->role_id;
        //     $userRoles = RoleUser::where('user_id', Auth::user()->id)->get()->toArray();
        //     // dd($userRoles);

        //     //Check role id ada di user atau engga

        //     $result = array_filter($userRoles, function ($item) use ($roleId) {
        //         return $item["role_id"] === $roleId;
        //     });
        //     // dd($result);


        //     if (!empty($result)) {

        //         if ($roleId == 1) {
        //             return redirect()->intended('/k/delegasi-tugas');
        //         } elseif ($roleId == 2) {
        //             return redirect()->intended('/s/delegasi-tugas');
        //         } elseif ($roleId == 3) {
        //             return redirect()->intended('/kl/delegasi-tugas');
        //         } elseif ($roleId == 4) {
        //             return redirect()->intended('/ah/delegasi-tugas');
        //         } elseif ($roleId == 5) {
        //             return redirect()->intended('/d/delegasi-tugas');
        //         } elseif ($roleId == 6) {
        //             return redirect()->intended('/st/delegasi-tugas');
        //         }
        //     } else {
        //         // return redirect()->back()->withErrors('Invalid credentials');
        //         return back()->with('SelectedRoleFailed', 'Anda tidak memiliki akses ke halaman tersebut!');
        //     }
        // }
        // return back()->with('LoginFailed', 'Username dan Password tidak valid!');

        //Ini untuk yang menggunakan halaman baru yaitu halaman selectedRole
        // $request->session()->regenerate();

        // $userId = $request->id;
        // $userRoles = RoleUser::where('user_id', $userId)->get('role_id');

        // // if (count($userRoles) > 1) {
        //     session()->put('userRoles', $userRoles); // Simpan daftar role ke dalam session
        //     // Session::put('userRoles', $userRoles);

        //     // Menampilkan halaman login
        //     return view('auth.selectedRole');
        //     // return back()->with('selectedRole', 'pilih role terlebih dahuli');
        // // } else {
        // //     session(['selected_role' => $userRoles[0]]);
        // // }

    }

    public function selectedRole(Request $request)
    {

        // $user = Auth::user();
        $roleId = $request->id_role;
        // dd($roleId);
        // if ($roleId == 1) {
        //     return redirect()->intended('/k/delegasi-tugas');
        // }
        $userRoles = RoleUser::where('user_id', Auth::user()->id)->get()->toArray();
        // dd($userRoles);

        //Check role id ada di user atau engga

        $result = array_filter($userRoles, function ($item) use ($roleId) {
            return $item["role_id"] === $roleId;
        });
        // dd($result);


        if (!empty($result)) {
            if ($roleId == 1) {
                // return 'Login berhasil';
                return redirect()->intended('/k/delegasi-tugas');
            } elseif ($roleId == 2) {
                return redirect()->intended('/s/delegasi-tugas');
            } elseif ($roleId == 3) {
                return redirect()->intended('/kl/delegasi-tugas');
            } elseif ($roleId == 4) {
                return redirect()->intended('/ah/delegasi-tugas');
            } elseif ($roleId == 5) {
                return redirect()->intended('/d/tugas-masuk');
            } elseif ($roleId == 6) {
                return redirect()->intended('/st/tugas-masuk');
            } elseif ($roleId == 7) {
                return redirect()->intended('/admin');
            }
        } else {
            // return redirect()->back()->withErrors('Invalid credentials');
            return back()->with('SelectedRoleFailed', 'Anda tidak memiliki akses ke halaman tersebut!');
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
