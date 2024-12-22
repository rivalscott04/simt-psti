<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use App\Models\Tugas;
use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;
use App\Models\RiwayatTeruskan;
use App\Models\RiwayatPenolakan;
use App\Models\RiwayatPenerimaan;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class DelegasiTugasSekprodi2 extends Controller
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

        return view('s/delegasi-tugas', compact('semuaTugas', 'jumlahTugas', 'nama_pengguna', 'role', 'title'));
    }

    public function create()
    {
        return view('s/tambah-delegasi-tugas', [
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
    // public function store(Request $request)
    // {
    //     // Mendapatkan ID pengguna dari sesi
    //     $userIdnew = $request->session()->get('user_id');

    //     // Simpan data waktu yang dipilih dalam format yang sesuai (misalnya: Y-m-d H:i:s)
    //     $selectedTime = date('Y-m-d H:i:s', strtotime($request->input('tenggat_waktu_tanggal')));

    //     // Inisialisasi nilai default keterangan tujuan
    //     $ket_tujuan = 'menunggu_konfirmasi';

    //     // Buat UUID baru sebagai nilai id_tugas
    //     $uuid = Uuid::uuid4()->toString();

    //     $messages = [
    //         'tenggat_waktu_jam.required' => 'Jam harus diisi.',
    //         'tenggat_waktu_tanggal.required' => 'Tanggal harus diisi.',
    //         'url.url' => 'Format URL tidak valid.',
    //         'lampiran.mimes' => 'Format lampiran harus docx, pdf, atau rar.',
    //     ];

    //     $validator = Validator::make($request->all(), [
    //         // 'id_tugas' => 'required|unique:tugas',
    //         'user_id' => 'required',
    //         'tujuan' => 'required',
    //         'perihal' => 'required',
    //         'tenggat_waktu_jam' => 'required',
    //         'tenggat_waktu_tanggal' => 'required',
    //         'url' => 'nullable|url',
    //         'lampiran' => 'nullable|file|mimes:docx,pdf,rar',
    //         'ket_tujuan' => 'nullable|in:menunggu_konfirmasi,diterima,ditolak',
    //     ], $messages);

    //     // Cek apakah validasi berhasil
    //     if ($validator->fails()) {
    //         // Jika validasi gagal, kembalikan ke halaman sebelumnya dengan pesan error
    //         return redirect()->back()->withErrors($validator)->withInput();
    //     }

    //     $validateData = $request->all();

    //     $filename = time() . '.' . $request->file->extension();
    //     $request->file->move(public_path('documents'), $filename);

    //     $validateData['lampiran'] = $filename;
    //     $validateData['id_tugas'] = $uuid;
    //     $validateData['user_id'] = $userIdnew;
    //     $validateData['tenggat_waktu_tanggal'] = $selectedTime;
    //     $validateData['ket_tujuan'] = $ket_tujuan;

    //     Tugas::create($validateData);

    //     return redirect('s/delegasi-tugas')->with('success', 'Tugas berhasil didelegasikan');
    // }

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
            'tujuan.required' => 'Tujuan harus diisi.',
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

        if (isset($request->lampiran)) {
            $lampiran = $request->file('lampiran');
            $name = 'PSTI_' . $userIdnew . '_' . date('Ymdhis') . '.' . $request->file('lampiran')->getClientOriginalExtension();
            $lampiran->move('lampiran/', $name);
            $validateData['lampiran'] = $name;
        }

        $validateData['id_tugas'] = $uuid;
        $validateData['user_id'] = $userIdnew;
        $validateData['tenggat_waktu_tanggal'] = $selectedTime;
        $validateData['ket_tujuan'] = $ket_tujuan;

        Tugas::create($validateData);

        return redirect('s/delegasi-tugas')->with('success', 'Tugas berhasil didelegasikan');
    }

    //method tugas masuk
    public function tugasMasuk(Request $request)
    {
        if ($request->has('search')) {
            $nama_pengguna = Auth::user()->nama_pengguna;

            $semuaTugas = Tugas::where(function ($query) use ($request, $nama_pengguna) {
                $query->where('perihal', 'like', '%' . $request->search . '%')
                    ->orWhere('tujuan', 'like', '%' . $request->search . '%');
            })
                ->where('tujuan', $nama_pengguna)
                ->where('ket_tujuan', 'menunggu_konfirmasi')
                ->paginate(15);

            $jumlahTugas = Tugas::where(function ($query) use ($request, $nama_pengguna) {
                $query->where('perihal', 'like', '%' . $request->search . '%')
                    ->orWhere('tujuan', 'like', '%' . $request->search . '%');
            })
                ->where('tujuan', $nama_pengguna)
                ->where('ket_tujuan', 'menunggu_konfirmasi')
                ->get();

            // $semuaTugas = Tugas::where('perihal', 'like', '%' . $request->search . '%')
            //     ->orWhere('tujuan', 'like', '%' . $request->search . '%')
            //     ->where('tujuan', $nama_pengguna)
            //     ->where('ket_tujuan', 'menunggu_konfirmasi')
            //     ->paginate(15);

            // $jumlahTugas = Tugas::where('perihal', 'like', '%' . $request->search . '%')
            //     ->orWhere('tujuan', 'like', '%' . $request->search . '%')
            //     ->where('tujuan', $nama_pengguna)
            //     ->where('ket_tujuan', 'menunggu_konfirmasi')
            //     ->get();

            $jumlahTugas = count($jumlahTugas);
        } else {
            $nama_pengguna = Auth::user()->nama_pengguna;
            $semuaTugas = Tugas::where('tujuan', $nama_pengguna)
                ->where('ket_tujuan', 'menunggu_konfirmasi')
                ->paginate(15);
            $jumlahTugas = Tugas::where('tujuan', $nama_pengguna)
                ->where('ket_tujuan', 'menunggu_konfirmasi')
                ->get();
            $jumlahTugas = count($jumlahTugas);
        }

        foreach ($semuaTugas as $tugas) {
            // Ubah $created_at menjadi objek Carbon
            $createdAt = Carbon::parse($tugas->created_at);

            // Formatkan tanggal sesuai dengan format yang diinginkan
            $tugas->formattedDate = $createdAt->format('d M Y, g:i a');
        }

        $nama_pengirim = ''; //inisialisai nilai default nama pengirim

        foreach ($semuaTugas as $tugas) {
            // Mengakses properti user_id dari model Tugas
            $user_id = $tugas->user_id;
            $nama_pengirim = User::where('id', $user_id)
                ->get('nama_pengguna');

            $data = json_decode($nama_pengirim, true); // Mengambil data dari JSON karena query diatas menghasilkan data dalam format JSON
            $nama_pengirim = $data[0]['nama_pengguna'];
        }

        $title = 'Delegasi Tugas';
        $nama_pengguna = Auth::user()->nama_pengguna;
        $role = Auth::user()->roles[0]->name;

        return view('s/tugas-masuk', compact('semuaTugas', 'jumlahTugas', 'nama_pengguna', 'role', 'title', 'nama_pengirim'));
    }

    // public function show(Tugas $tugas)
    // {

    //     // $semuaTugas = Tugas::where('id_tugas', $tugas);
    //     // dd($semuaTugas);

    //     // $nama_pengguna = Auth::user()->nama_pengguna;
    //     // $semuaTugas = Tugas::where('tujuan', $nama_pengguna)->paginate(15);
    //     // $jumlahTugas = Tugas::where('tujuan', $nama_pengguna)->get();
    //     // $jumlahTugas = count($jumlahTugas);

    //     // $user_id = Auth::user()->id;
    //     // $semuaTugas = Tugas::where('user_id', $user_id)->paginate(15);
    //     // dd($semuaTugas);
    //     // $jumlahTugas = Tugas::where('user_id', $user_id)->get();
    //     // $jumlahTugas = count($jumlahTugas);

    //     // dd($tugas);

    //     // $tugas = Tugas::all();
    //     // foreach ($tugas as $tugas) {
    //     // Ubah $created_at menjadi objek Carbon
    //     // $createdAt = Carbon::parse($tugas->created_at);

    //     // // Formatkan tanggal sesuai dengan format yang diinginkan
    //     // $tugas->formattedDate = $createdAt->format('d M Y, g:i a');
    //     // }

    //     $title = 'Detail Tugas Masuk';
    //     $nama_pengguna = Auth::user()->nama_pengguna;
    //     $role = Auth::user()->roles[0]->name;

    //     return view('s.show', compact('tugas', 'nama_pengguna', 'role', 'title'));

    //     // return view('s.show', compact('tugas', 'title', 'nama_pengguna', 'role'));
    // }

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


        //mengambil nama pengirim dari suatu tugas
        $user_id = $tugas->user_id;
        $nama_pengirim = User::where('id', $user_id)
            ->get('nama_pengguna');
        $data = json_decode($nama_pengirim, true); // Mengambil data dari JSON karena query diatas menghasilkan data dalam format JSON
        $nama_pengirim = $data[0]['nama_pengguna'];

        return view('s.show', compact('tugas', 'title', 'nama_pengguna', 'role', 'nama_hari', 'tanggal', 'jam', 'nama_pengirim'));
    }

    // public function accept($id_tugas)
    // {
    //     $tugas = Tugas::findOrFail($id_tugas);
    //     // Lakukan logika untuk menerima tugas di sini
    //     $tugas->update(['ket_tujuan' => 'diterima']);

    //     return redirect('s/tugas-masuk')->with('success', 'Tugas diterima!');
    // }

    // INI YANG SIDAH BERHASIL
    public function accept(Request $request, $id_tugas)
    {
        $userIdnew = $request->session()->get('user_id'); // Mendapatkan ID pengguna dari sesi
        $nama_pengguna = User::where('id', $userIdnew)
            ->get('nama_pengguna');

        $data = json_decode($nama_pengguna, true); // Mengambil data dari JSON karena query diatas menghasilkan data dalam format JSON
        $nama_pengguna = $data[0]['nama_pengguna'];

        // Buat UUID baru sebagai nilai id_penolakan
        $uuid = Uuid::uuid4()->toString();

        // Temukan tugas berdasarkan $id_tugas
        $tugas = Tugas::findOrFail($id_tugas);

        // Ubah status tugas menjadi "ditolak"
        $tugas->update([
            'ket_tujuan' => 'diterima',
        ]);

        // Simpan riwayat ke dalam tabel RiwayatPenerimaan
        $riwayatPenerimaan = new RiwayatPenerimaan([
            'id_tugas' => $tugas->id_tugas,
            'nama_pengguna' => $nama_pengguna
        ]);
        $riwayatPenerimaan->save();

        return redirect('s/tugas-masuk')->with('success', 'Tugas diterima!');
    }

    // public function reject(Request $request, $id_tugas)
    // {
    //     $userIdnew = $request->session()->get('user_id'); // Mendapatkan ID pengguna dari sesi
    //     $nama_pengguna = User::where('id', $userIdnew)
    //         ->get('nama_pengguna');

    //     $data = json_decode($nama_pengguna, true); // Mengambil data dari JSON karena query diatas menghasilkan data dalam format JSON
    //     $nama_pengguna = $data[0]['nama_pengguna'];

    //     // Buat UUID baru sebagai nilai id_penolakan
    //     $uuid = Uuid::uuid4()->toString();

    //     // Validasi input alasan penolakan
    //     $request->validate([
    //         'alasan_penolakan' => 'required|max:255',
    //     ]);

    //     // Temukan tugas berdasarkan $id_tugas
    //     $tugas = Tugas::findOrFail($id_tugas);

    //     // Ubah status tugas menjadi "ditolak"
    //     $tugas->update([
    //         'ket_tujuan' => 'ditolak',
    //     ]);

    //     // Simpan alasan penolakan ke dalam tabel RiwayatPenolakan (jika ada)
    //     // $riwayatPenolakan = new RiwayatPenolakan([
    //     //     'id_tugas' => $tugas->id_tugas,
    //     //     'alasan_penolakan' => $request->input('alasan_penolakan'),
    //     //     'id_penolakan' => $uuid,
    //     //     'nama_pengguna' => $nama_pengguna
    //     // ]);
    //     // $riwayatPenolakan->save();

    //     // Show JavaScript alert with a success message
    //     echo "<script>alert('Tugas ditolak!');</script>";

    //     // Redirect back to the previous page
    //     return back();
    // }


    // INI YANG SIDAH BERHASIL
    public function reject(Request $request, $id_tugas)
    {
        $userIdnew = $request->session()->get('user_id'); // Mendapatkan ID pengguna dari sesi
        $nama_pengguna = User::where('id', $userIdnew)
            ->get('nama_pengguna');

        $data = json_decode($nama_pengguna, true); // Mengambil data dari JSON karena query diatas menghasilkan data dalam format JSON
        $nama_pengguna = $data[0]['nama_pengguna'];

        // Buat UUID baru sebagai nilai id_penolakan
        $uuid = Uuid::uuid4()->toString();

        // Validasi input alasan penolakan
        $request->validate([
            'alasan_penolakan' => 'required|max:255',
        ]);

        // Temukan tugas berdasarkan $id_tugas
        $tugas = Tugas::findOrFail($id_tugas);

        // Ubah status tugas menjadi "ditolak"
        $tugas->update([
            'ket_tujuan' => 'ditolak',
        ]);

        // Simpan alasan penolakan ke dalam tabel RiwayatPenolakan (jika ada)
        $riwayatPenolakan = new RiwayatPenolakan([
            'id_tugas' => $tugas->id_tugas,
            'alasan_penolakan' => $request->input('alasan_penolakan'),
            'id_penolakan' => $uuid,
            'nama_pengguna' => $nama_pengguna
        ]);
        $riwayatPenolakan->save();

        return redirect('s/tugas-masuk')->with('success', 'Tugas ditolak!');
    }

    public function forward(Request $request, $id_tugas)
    {
        $userIdnew = $request->session()->get('user_id'); // Mendapatkan ID pengguna dari sesi
        $nama_pengguna = User::where('id', $userIdnew)
            ->get('nama_pengguna');

        $data = json_decode($nama_pengguna, true); // Mengambil data dari JSON karena query diatas menghasilkan data dalam format JSON
        $nama_pengguna = $data[0]['nama_pengguna'];

        // Buat UUID baru sebagai nilai id_penolakan
        $uuid = Uuid::uuid4()->toString();

        // Validasi input alasan penolakan
        $request->validate([
            'tujuan' => 'required',
        ]);

        // Ambil user_id dari tujuan
        $nama_penggunaNew = $request->tujuan;
        $tujuanNew = User::where('nama_pengguna', $nama_penggunaNew)
            ->get('id');
        $data = json_decode($tujuanNew, true);
        $tujuanNew = $data[0]['id'];

        // Temukan tugas berdasarkan $id_tugas
        $tugas = Tugas::findOrFail($id_tugas);

        // Ubah status tugas menjadi "ditolak"
        $tugas->update([
            'ket_tujuan' => 'diteruskan',
        ]);

        // Simpan alasan penolakan ke dalam tabel RiwayatPenolakan (jika ada)
        $riwayatteruskan = new RiwayatTeruskan([
            'id_tugas' => $tugas->id_tugas,
            'tujuan' => $tujuanNew,
            'id_teruskan' => $uuid,
            'nama_pengguna' => $nama_pengguna
        ]);
        $riwayatteruskan->save();

        return redirect('s/tugas-masuk')->with('success', 'Tugas diteruskan!');
    }

    public function download($tugas)
    {
        // Tentukan path lengkap ke file yang akan diunduh
        $path = public_path('lampiran/' . $tugas);
        return response()->download($path);
    }

    public function showTugas(Tugas $tugas)
    {
        return view('s/showTugas', [
            'tugas' => $tugas
        ]);
    }
}
