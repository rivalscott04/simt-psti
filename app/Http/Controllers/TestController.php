<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use App\Models\Tugas;
use Ramsey\Uuid\Uuid;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class TestController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('search')) {
            $user_id = Auth::user()->id;

            $semuaTugas = Tugas::where('perihal', 'like', '%' . $request->search . '%')
                ->orWhere('tujuan', 'like', '%' . $request->search . '%')
                ->where('user_id', $user_id)
                ->paginate(15);

            $jumlahTugas = Tugas::where('perihal', 'like', '%' . $request->search . '%')
                ->orWhere('tujuan', 'like', '%' . $request->search . '%')
                ->where('user_id', $user_id)
                ->get();

            $jumlahTugas = count($jumlahTugas);
        } else {
            $user_id = Auth::user()->id;
            $semuaTugas = Tugas::where('user_id', $user_id)->paginate(15);
            $jumlahTugas = Tugas::where('user_id', $user_id)->get();
            $jumlahTugas = count($jumlahTugas);
        }

        foreach ($semuaTugas as $tugas) {
            // Ubah $created_at menjadi objek Carbon
            $createdAt = Carbon::parse($tugas->created_at);

            // Formatkan tanggal sesuai dengan format yang diinginkan
            $tugas->formattedDate = $createdAt->format('d M Y, g:i a');
        }

        $title = 'Delegasi Tugas';
        $nama_pengguna = Auth::user()->nama_pengguna;
        $role = Auth::user()->roles[0]->name;

        return view('kaprodi/delegasi-tugas', compact('semuaTugas', 'jumlahTugas', 'nama_pengguna', 'role', 'title'));
    }

    public function create()
    {
        return view('kaprodi/tambah-delegasi-tugas', [
            'title' => 'Tambah Delegasi Tugas',
            'nama_pengguna' => Auth::user()->nama_pengguna,
            'role' => Auth::user()->roles[0]->name
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
        // Mendapatkan ID pengguna dari sesi
        $userIdnew = $request->session()->get('user_id');

        // Simpan data waktu yang dipilih dalam format yang sesuai (misalnya: Y-m-d H:i:s)
        $selectedTime = date('Y-m-d H:i:s', strtotime($request->input('tenggat_waktu_tanggal')));

        // Inisialisasi nilai default keterangan tujuan
        $ket_tujuan = 'menunggu_konfirmasi';

        // Buat UUID baru sebagai nilai id_tugas
        $uuid = Uuid::uuid4()->toString();

        $messages = [
            'tenggat_waktu_jam.required' => 'Jam harus diisi.',
            'tenggat_waktu_tanggal.required' => 'Tanggal harus diisi.',
            'url.url' => 'Format URL tidak valid.',
            'lampiran.mimes' => 'Format lampiran harus docx, pdf, atau rar.',
        ];

        $validator = Validator::make($request->all(), [
            // 'id_tugas' => 'required|unique:tugas',
            'user_id' => 'required',
            'tujuan' => 'required',
            'perihal' => 'required',
            'tenggat_waktu_jam' => 'required',
            'tenggat_waktu_tanggal' => 'required',
            'url' => 'nullable|url',
            'lampiran' => 'nullable|file|mimes:docx,pdf,rar',
            'ket_tujuan' => 'nullable|in:menunggu_konfirmasi,diterima,ditolak',
        ], $messages);

        // Cek apakah validasi berhasil
        if ($validator->fails()) {
            // Jika validasi gagal, kembalikan ke halaman sebelumnya dengan pesan error
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validateData = $request->all();
        $validateData['id_tugas'] = $uuid;
        $validateData['user_id'] = $userIdnew;
        $validateData['tenggat_waktu_tanggal'] = $selectedTime;
        $validateData['ket_tujuan'] = $ket_tujuan;

        Tugas::create($validateData);

        return redirect('kaprodi/delegasi-tugas')->with('success', 'Tugas berhasil didelegasikan');
    }

    //method tugas masuk
    public function tugasMasuk(Request $request)
    {
        if ($request->has('search')) {
            $nama_pengguna = Auth::user()->nama_pengguna;

            $semuaTugas = Tugas::where('perihal', 'like', '%' . $request->search . '%')
                ->orWhere('tujuan', 'like', '%' . $request->search . '%')
                ->where('tujuan', $nama_pengguna)
                ->paginate(1);

            $jumlahTugas = Tugas::where('perihal', 'like', '%' . $request->search . '%')
                ->orWhere('tujuan', 'like', '%' . $request->search . '%')
                ->where('tujuan', $nama_pengguna)
                ->get();

            $jumlahTugas = count($jumlahTugas);
        } else {
            $nama_pengguna = Auth::user()->nama_pengguna;
            $semuaTugas = Tugas::where('tujuan', $nama_pengguna)->paginate(15);
            $jumlahTugas = Tugas::where('tujuan', $nama_pengguna)->get();
            $jumlahTugas = count($jumlahTugas);
        }

        foreach ($semuaTugas as $tugas) {
            // Ubah $created_at menjadi objek Carbon
            $createdAt = Carbon::parse($tugas->created_at);

            // Formatkan tanggal sesuai dengan format yang diinginkan
            $tugas->formattedDate = $createdAt->format('d M Y, g:i a');
        }

        $title = 'Delegasi Tugas';
        $nama_pengguna = Auth::user()->nama_pengguna;
        $role = Auth::user()->roles[0]->name;

        return view('kaprodi/tugas-masuk', compact('semuaTugas', 'jumlahTugas', 'nama_pengguna', 'role', 'title'));
    }

    public function show(Tugas $tugas)
    {
        $title = 'Detail Tugas Masuk';
        $nama_pengguna = Auth::user()->nama_pengguna;
        $role = Auth::user()->roles[0]->name;


        //penentuan nama hari
        $nama_hari = Carbon::parse($tugas->tenggat_waktu_tanggal); // Buat objek Carbon dari tanggal
        $nama_hari->locale('id'); // Set bahasa pada objek Carbon (Indonesia)
        $nama_hari = $nama_hari->isoFormat('dddd'); // Dapatkan nama hari dalam bahasa Indonesia

        //penentuan format tanggal
        $tanggal = Carbon::parse($tugas->tenggat_waktu_tanggal); // Buat objek Carbon dari tanggal
        $tanggal = $tanggal->format('j F Y'); // Format tanggal sesuai dengan format yang diinginkan contoh '8 Maret 2023'

        //penentuan format jam
        $jam = Carbon::parse($tugas->tenggat_waktu_jam); // Buat objek Carbon dari jam
        $jam = $jam->format('H:i'); // Format waktu sesuai dengan format yang diinginkan contoh '23:59'
        return view('s.show', compact('tugas', 'title', 'nama_pengguna', 'role', 'nama_hari', 'tanggal', 'jam'));
    }
}
