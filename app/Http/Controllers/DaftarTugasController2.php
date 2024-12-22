<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Perkembangan;
use Illuminate\Http\Request;

class DaftarTugasController extends Controller
{
    public function index()
    {
        // $users = User::all();
        $users = User::orderBy('nama_pengguna', 'asc')->get();


        foreach ($users as $user) {
            $nama_pengguna = $user->nama_pengguna;
            $jumlahTugasInProgress[$nama_pengguna] = Perkembangan::where('nama_pengguna', $nama_pengguna)
                ->where('keterangan', 'incomplete')
                ->count();
        }

        return view('/daftar-tugas', compact('users', 'jumlahTugasInProgress'));
    }
}
