<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Tugas;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class DelegasiTugasSekprodi extends Controller
{
    public function index()
    {
        return view('s/delegasi-tugas', [
            'tugas' => Tugas::all()
            // 'tugas' => Tugas::search(request(['search']))->get()
        ]);
    }

    public function create()
    {
        return view('k/tambah-delegasi-tugas', [
            'title' => 'Tambah Delegasi Tugas'
        ]);
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
        // Menangkap ID pengguna yang terautentikasi
        $userId = Auth::id();

        $validateData = $request->validate([
            // 'id_pengguna' => 'required',
            'tujuan' => 'required',
            'perihal' => 'required',
            'tenggat_waktu' => 'required',
            'url' => 'nullable',
            'lampiran' => 'required|mimes:docx,pdf,rar',
            'ket_tujuan' => 'required',



            // 'title' => 'required|max:100',
            // 'file' => 'required|mimes:png,jpg,svg',
            // 'body' => 'required'
        ]);

        $filename = time() . '.' . $request->file->extension();
        $request->file->move(public_path('documents'), $filename);

        // $validateData['file'] = $filename;
        // $validateData['excerpt'] = Str::limit(strip_tags($request->body), 100);

        // Berita::create($validateData);

        return redirect('dashboard/berita')->with('success', 'Berita berhasil ditambahkan');
    }
}
