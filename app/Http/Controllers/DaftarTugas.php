<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\RoleUser;
use App\Models\Perkembangan;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class DaftarTugas extends Controller
{
    public function index()
    {
        $role_name = 'Dosen';
        $dosens = DB::table('users')
            ->join('role_users', 'users.id', '=', 'role_users.user_id')
            ->join('roles', 'role_users.role_id', '=', 'roles.id')
            ->where('roles.name', $role_name)
            ->orderBy('nama_pengguna')
            ->select('users.nama_pengguna')
            ->get();
        // $users = User::orderBy('nama_pengguna', 'asc')->get();

        foreach ($dosens as $dosen) {
            $nama_pengguna = $dosen->nama_pengguna;
            $jumlahTugasInProgress[$nama_pengguna] = Perkembangan::where('nama_pengguna', $nama_pengguna)
                ->where('keterangan', 'incomplete')
                ->count();

            $jumlahTugasTotal[$nama_pengguna] = Perkembangan::where('nama_pengguna', $nama_pengguna)
                ->count();
        }

        $role_name = 'Staf';
        $stafs = DB::table('users')
            ->join('role_users', 'users.id', '=', 'role_users.user_id')
            ->join('roles', 'role_users.role_id', '=', 'roles.id')
            ->where('roles.name', $role_name)
            ->orderBy('nama_pengguna')
            ->select('users.nama_pengguna')
            ->get();

        foreach ($stafs as $staf) {
            $nama_pengguna = $staf->nama_pengguna;
            $jumlahTugasInProgress[$nama_pengguna] = Perkembangan::where('nama_pengguna', $nama_pengguna)
                ->where('keterangan', 'incomplete')
                ->count();

            $jumlahTugasTotal[$nama_pengguna] = Perkembangan::where('nama_pengguna', $nama_pengguna)
                ->count();
        }

        return view('/daftar-tugas', compact('dosens', 'stafs', 'jumlahTugasInProgress', 'jumlahTugasTotal'));
        // return view('/daftar-tugas', compact('users', 'jumlahTugasInProgress'));
    }
}
