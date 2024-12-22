<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use App\Models\Tugas;
use Ramsey\Uuid\Uuid;
use App\Models\RoleUser;
use App\Models\Perkembangan;
use Illuminate\Http\Request;
use App\Models\RiwayatTeruskan;
use App\Models\RiwayatPenolakan;
use App\Models\RiwayatPenerimaan;
use Illuminate\Routing\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;


class AdminController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Pengaturan';
        $nama_pengguna = Auth::user()->nama_pengguna;
        $role = $request->session()->get('role');
        $user_id = Auth::user()->id;

        if ($request->has('search')) {
            $search = $request->input('search');

            $usersWithRoles = DB::table('users')
                ->where(function ($query) use ($search) {
                    $query->where('roles.name', 'like', '%' . $search . '%')
                        ->orWhere('role_users.user_id', 'like', '%' . $search . '%')
                        ->orWhere('users.nama_pengguna', 'like', '%' . $search . '%');
                })
                ->join('role_users', 'users.id', '=', 'role_users.user_id')
                ->join('roles', 'role_users.role_id', '=', 'roles.id')
                ->select('role_users.id', 'roles.id as id_roles', 'roles.name', 'role_users.user_id', 'users.nama_pengguna')
                ->get();

            $jumlahData = count($usersWithRoles);
        } else {
            $usersWithRoles = DB::table('users')
                ->join('role_users', 'users.id', '=', 'role_users.user_id')
                ->join('roles', 'role_users.role_id', '=', 'roles.id')
                ->select('role_users.id', 'roles.id as id_roles', 'roles.name', 'role_users.user_id', 'users.nama_pengguna')
                ->get();

            $jumlahData = count($usersWithRoles);
        }

        return view('ad/pengaturan', compact('usersWithRoles', 'jumlahData', 'title', 'nama_pengguna', 'role'));
    }

    public function create()
    {
        return view('ad/tambah-data', [
            'title' => 'Tambah Data',
            'nama_pengguna' => Auth::user()->nama_pengguna,
            'role' => Auth::user()->roles[0]->name
        ]);
    }

    public function getAllUser()
    {
        $data = User::where('nama_pengguna', 'LIKE', '%' . request('q') . '%')->paginate(10);

        return response()->json($data);
    }



    //method untuk mengambil data role berdasarkan role yang dipilih pengguna
    public function role()
    {
        $data = Role::where('id', 'LIKE', '%' . request('q') . '%')->paginate(10);

        return response()->json($data);
    }

    public function user($id)
    {
        $namaPengguna  = User::join('role_users', 'users.id', '=', 'role_users.user_id')
            ->join('roles', 'role_users.role_id', '=', 'roles.id')
            ->where('roles.id', $id)
            ->get('users.nama_pengguna');

        $data = User::whereIn('nama_pengguna', $namaPengguna)->where('nama_pengguna', 'LIKE', '%' . request('q') . '%')->paginate(10);

        return response()->json($data);
    }

    //method untuk mengambil data user berdasarkan role yang dipilih pengguna menggunakan JQuery Select2
    public function getUser($role)
    {
        $namaPengguna  = User::join('role_users', 'users.id', '=', 'role_users.user_id')
            ->join('roles', 'role_users.role_id', '=', 'roles.id')
            ->where('roles.name', $role)
            ->get('users.nama_pengguna');

        $data = User::whereIn('nama_pengguna', $namaPengguna)->where('nama_pengguna', 'LIKE', '%' . request('q') . '%')->paginate(10);

        return response()->json($data);
    }

    //method yang digunakan untuk passing data
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_pengguna' => 'required',
            'role' => 'required',
        ]);

        // Cek apakah validasi berhasil
        if ($validator->fails()) {
            // Jika validasi gagal, kembalikan ke halaman sebelumnya dengan pesan error
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::where('nama_pengguna', $request->nama_pengguna)->first();
        $role = Role::where('name', $request->role)->first();
        // dd($role->id);

        $validateData = $request->all();

        $validateData['user_id'] = $user->id;
        $validateData['role_id'] = $role->id;

        RoleUser::create($validateData);

        return redirect('/admin')->with('success', 'Data berhasil ditambahkan.');
    }

    // Method to show the edit form
    public function edit(Request $request, $id)
    {
        // $roleUser = RoleUser::findOrFail($id); // Ganti dengan model yang sesuai
        // // return response()->json($roleUser);

        $roleUser = RoleUser::findOrFail($id);

        // ambil nama pengguna yang akan di edit
        $user_id = $roleUser->user_id;
        $user = User::findOrFail($user_id);
        $nama_pengguna_edit = $user->nama_pengguna;

        $role_id = $roleUser->role_id;
        $role = Role::findOrFail($role_id);
        $nama_role_edit = $role->name;

        $title = 'Edit Role User';
        $nama_pengguna = Auth::user()->nama_pengguna;
        $role = $request->session()->get('role');


        return view('ad/edit-role-user', compact('nama_pengguna_edit', 'nama_role_edit', 'roleUser', 'title', 'nama_pengguna', 'role', ));
    }

    // Method to handle the form submission and update the task
    public function update(Request $request, $id)
    {
        // Mendapatkan ID pengguna dari sesi
        $userIdnew = $request->session()->get('user_id');

        $validator = Validator::make($request->all(), [
            'nama_pengguna' => 'required',
            'role' => 'required',
        ]);

        // Cek apakah validasi berhasil
        if ($validator->fails()) {
            // Jika validasi gagal, kembalikan ke halaman sebelumnya dengan pesan error
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // mengambil user_id berdasarkan request nama_pengguna yang dikirim
        $nama_pengguna = $request->nama_pengguna;
        $user_id = User::where('nama_pengguna', $nama_pengguna)->get('id');
        $data = json_decode($user_id, true); // Mengambil data dari JSON karena query diatas menghasilkan data dalam format JSON
        $user_id = $data[0]['id'];

        // mengambil role_id berdasarkan request name yang dikirim
        $name = $request->role;
        $role_id = Role::where('name', $name)->get('id');
        $data = json_decode($role_id, true); // Mengambil data dari JSON karena query diatas menghasilkan data dalam format JSON
        $role_id = $data[0]['id'];

        $roleUser = RoleUser::findOrFail($id);

        // Update the task fields with the submitted data
        $roleUser->update([
            'user_id' => $user_id,
            'role_id' => $role_id,
        ]);

        return redirect()->route('admin.index')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        // dd($id);

        $roleUser = RoleUser::find($id);

        if ($roleUser) {
            $roleUser->delete();
            return redirect('/admin')->with('success', 'Data berhasil dihapus!');
        } else {
            return redirect('/admin')->with('error', 'Data tidak ditemukan.');
        }
    }
}
