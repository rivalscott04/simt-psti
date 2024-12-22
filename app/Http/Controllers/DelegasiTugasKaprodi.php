<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use App\Models\RoleUser;
use App\Models\Tugas;
use Ramsey\Uuid\Uuid;
use App\Models\Perkembangan;
use Illuminate\Http\Request;
use App\Models\RiwayatRevisi;
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


class DelegasiTugasKaprodi extends Controller
{
    public function index(Request $request)
    {
        $title = 'Delegasi Tugas';
        $nama_pengguna = Auth::user()->nama_pengguna;
        // $role = Auth::user()->roles[0]->name;
        $role = $request->session()->get('role');

        $user_id = Auth::user()->id;
        // dd($role);

        if ($request->has('search')) {
            $search = $request->input('search');

            $semuaTugas = DB::table('tugas')
                ->where(function ($query) use ($search) {
                    $query->where('perihal', 'like', '%' . $search . '%')
                        ->orWhere('tujuan', 'like', '%' . $search . '%');
                })
                ->where('user_id', $user_id)
                ->orderBy('updated_at', 'desc')
                ->paginate(15);

            $jumlahTugas = DB::table('tugas')
                ->where(function ($query) use ($search) {
                    $query->where('perihal', 'like', '%' . $search . '%')
                        ->orWhere('tujuan', 'like', '%' . $search . '%');
                })
                ->where('user_id', $user_id)
                ->orderBy('updated_at', 'desc')
                ->get();

            $jumlahTugas = count($jumlahTugas);
        } else {
            $semuaTugas = Tugas::where('user_id', $user_id)
                ->orderBy('updated_at', 'desc')
                ->paginate(15);
            $jumlahTugas = Tugas::where('user_id', $user_id)->get();
            $jumlahTugas = count($jumlahTugas);
        }

        //Ambil alasan penolakan pada tugas yang memiliki ket_tujuan ditolak
        $alasan_penolakan = $semuaTugas->map(function ($tugas) {
            return RiwayatPenolakan::where('id_tugas', $tugas->id_tugas)
                ->where('nama_pengguna', $tugas->tujuan)
                // ->orderBy('created_at', 'desc') // Urutkan berdasarkan tanggal terbaru
                ->value('alasan_penolakan');
        })->all();

        // Menggunakan array_filter untuk mengambil nilai array yang tidak null
        $alasan_penolakan = array_filter($alasan_penolakan, function ($nilai) {
            return $nilai !== null;
        });

        // Menggunakan implode untuk mengubah array menjadi string
        $alasan_penolakan = implode(", ", $alasan_penolakan);

        foreach ($semuaTugas as $tugas) {
            // Ubah $updated_at menjadi objek Carbon
            $createdAt = Carbon::parse($tugas->updated_at);

            // Formatkan tanggal sesuai dengan format yang diinginkan
            $tugas->formattedDate = $createdAt->format('d M Y, g:i a');
        }

        return view('k/delegasi-tugas', compact('semuaTugas', 'jumlahTugas', 'nama_pengguna', 'role', 'title', 'alasan_penolakan'));
    }

    // public function index()
    // {
    //     $title = 'Delegasi Tugas';
    //     $nama_pengguna = Auth::user()->nama_pengguna;
    //     $role = Auth::user()->roles[0]->name;
    //     $user_id = Auth::user()->id;

    //     $semuaTugas = Tugas::where('user_id', $user_id)
    //         ->orderBy('created_at', 'desc')
    //         ->paginate(15);
    //     $jumlahTugas = Tugas::where('user_id', $user_id)->get();
    //     $jumlahTugas = count($jumlahTugas);

    //     //Ambil alasan penolakan pada tugas yang memiliki ket_tujuan ditolak
    //     $alasan_penolakan = $semuaTugas->map(function ($tugas) {
    //         return RiwayatPenolakan::where('id_tugas', $tugas->id_tugas)
    //             ->where('nama_pengguna', $tugas->tujuan)
    //             ->value('alasan_penolakan');
    //     })->all();

    //     // Menggunakan array_filter untuk mengambil nilai array yang tidak null
    //     $alasan_penolakan = array_filter($alasan_penolakan, function ($nilai) {
    //         return $nilai !== null;
    //     });

    //     // Menggunakan implode untuk mengubah array menjadi string
    //     $alasan_penolakan = implode(", ", $alasan_penolakan);

    //     foreach ($semuaTugas as $tugas) {
    //         // Ubah $created_at menjadi objek Carbon
    //         $createdAt = Carbon::parse($tugas->created_at);

    //         // Formatkan tanggal sesuai dengan format yang diinginkan
    //         $tugas->formattedDate = $createdAt->format('d M Y, g:i a');
    //     }

    //     return view('k/delegasi-tugas', compact('semuaTugas', 'jumlahTugas', 'nama_pengguna', 'role', 'title', 'alasan_penolakan'));
    // }

    public function create()
    {
        return view('k/tambah-delegasi-tugas', [
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

        $nama_pengirim = Auth::user()->nama_pengguna; //ambil nama_pengguna untuk menjadi nama pengirim


        // Simpan data waktu yang dipilih dalam format yang sesuai (misalnya: Y-m-d H:i:s)
        $selectedTime = date('Y-m-d H:i:s', strtotime($request->input('tenggat_waktu_tanggal')));

        $role = $request->session()->get('role');

        // Inisialisasi nilai default keterangan tujuan
        $ket_tujuan = 'menunggu_konfirmasi';

        // Buat UUID baru sebagai nilai id_tugas
        $uuid = Uuid::uuid4()->toString();

        $messages = [
            'tujuan.required' => 'Tujuan harus diisi.',
            'tenggat_waktu_jam.required' => 'Jam harus diisi.',
            'tenggat_waktu_tanggal.required' => 'Tanggal harus diisi.',
            'url.url' => 'Format URL tidak valid.',
            'lampiran.mimes' => 'Format lampiran harus docx, pdf, zip, rar, png, jpg, atau jpeg.',
        ];

        $validator = Validator::make($request->all(), [
            // 'id_tugas' => 'required|unique:tugas',
            'user_id' => 'required',
            'nama_pengirim' => 'required',
            'role_pengirim' => 'required',
            'tujuan' => 'required',
            'role_tujuan' => 'required',
            'perihal' => 'required',
            'tenggat_waktu_jam' => 'required',
            'tenggat_waktu_tanggal' => 'required',
            'url' => 'nullable|url',
            'lampiran' => 'nullable|mimes:pdf,docx,zip,rar,png,jpg,jpeg',
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
        $validateData['nama_pengirim'] = $nama_pengirim;
        $validateData['role_pengirim'] = $role;
        $validateData['tenggat_waktu_tanggal'] = $selectedTime;
        $validateData['ket_tujuan'] = $ket_tujuan;

        Tugas::create($validateData);

        return redirect('k/delegasi-tugas')->with('success', 'Tugas berhasil didelegasikan');
    }

    // Method to show the edit form
    public function edit(Request $request, $id_tugas)
    {
        $title = 'Edit Delegasi Tugas';
        $nama_pengguna = Auth::user()->nama_pengguna;
        // $role = Auth::user()->roles[0]->name;
        $role = $request->session()->get('role');
        // dd($role);

        $tugas = Tugas::findOrFail($id_tugas);
        $tujuan = $tugas->tujuan;

        $perihal = $tugas->perihal;
        $perihal = str_replace("\r\n", " ", $perihal);


        //penentuan format jam
        $jam = Carbon::parse($tugas->tenggat_waktu_jam); // Buat objek Carbon dari jam
        $jam = $jam->format('H:i'); // Format waktu sesuai dengan format yang diinginkan contoh '23:59'

        //penentuan format tanggal
        $tanggal = Carbon::parse($tugas->tenggat_waktu_tanggal); // Ubah tanggal menjadi objek Carbon
        $tanggalFormatted = $tanggal->format('m/d/Y'); // Format tanggal menjadi "07/19/2023"

        return view('k/edit-delegasi-tugas', compact('tugas', 'title', 'nama_pengguna', 'role', 'jam', 'tanggalFormatted', 'perihal', 'tujuan'));
    }

    // Method to handle the form submission and update the task
    public function update(Request $request, $id_tugas)
    {
        // $tugas = Tugas::findOrFail($id_tugas);
        // dd($tugas->lampiran);
        // $request->validate([
        //     'tujuan' => 'required',
        //     'perihal' => 'required',
        //     'tenggat_waktu_jam' => 'required',
        //     'tenggat_waktu_tanggal' => 'required',
        //     'url' => 'nullable|url',
        //     'lampiran' => 'nullable|file|mimes:docx,pdf,rar',
        //     'ket_tujuan' => 'nullable|in:menunggu_konfirmasi,diterima,ditolak',
        // ]);

        // Mendapatkan ID pengguna dari sesi
        $userIdnew = $request->session()->get('user_id');



        // Inisialisasi nilai default keterangan tujuan
        $ket_tujuan = 'menunggu_konfirmasi';

        // Buat UUID baru sebagai nilai id_tugas
        $uuid = Uuid::uuid4()->toString();

        $messages = [
            'tenggat_waktu_jam.required' => 'Jam harus diisi.',
            'tenggat_waktu_tanggal.required' => 'Tanggal harus diisi.',
            'url.url' => 'Format URL tidak valid.',
            'lampiran.mimes' => 'Format lampiran harus docx, pdf, zip, rar, png, jpg, atau jpeg.',
        ];

        $validator = Validator::make($request->all(), [
            // 'id_tugas' => 'required|unique:tugas',
            'user_id' => 'required',
            'tujuan' => 'required',
            'role_tujuan' => 'required',
            'perihal' => 'required',
            'tenggat_waktu_jam' => 'required',
            'tenggat_waktu_tanggal' => 'required',
            'url' => 'nullable|url',
            'lampiran' => 'nullable|mimes:docx,pdf,rar,zip,png,jpg,jpeg',
            'ket_tujuan' => 'nullable|in:menunggu_konfirmasi,diterima,ditolak',
        ], $messages);

        // Cek apakah validasi berhasil
        if ($validator->fails()) {
            // Jika validasi gagal, kembalikan ke halaman sebelumnya dengan pesan error
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $tugas = Tugas::findOrFail($id_tugas);

        //ambil lampiran sebelumnya
        $name = $tugas->lampiran;

        if (isset($request->lampiran)) {
            $lampiran = $request->file('lampiran');
            $name = 'PSTI_' . $userIdnew . '_' . date('Ymdhis') . '.' . $request->file('lampiran')->getClientOriginalExtension();
            $lampiran->move('lampiran/', $name);
            $validateData['lampiran'] = $name;
        }

        // Simpan data waktu yang dipilih dalam format yang sesuai (misalnya: Y-m-d H:i:s)
        $selectedTime = date('Y-m-d H:i:s', strtotime($request->input('tenggat_waktu_tanggal')));

        // Update the task fields with the submitted data
        $tugas->update([
            'tujuan' => $request->tujuan,
            'role_tujuan' => $request->role_tujuan,
            'perihal' => $request->perihal,
            'tenggat_waktu_jam' => $request->tenggat_waktu_jam,
            'tenggat_waktu_tanggal' => $selectedTime,
            'url' => $request->url,
            'lampiran' => $name,
            'ket_tujuan' => $ket_tujuan,
        ]);

        return redirect()->route('k.edit', $tugas->id_tugas)->with('success', 'Tugas berhasil diperbarui!');
    }

    public function download($tugas)
    {
        // Tentukan path lengkap ke file yang akan diunduh
        $path = public_path('lampiran/' . $tugas);
        return response()->download($path);
    }

    public function riwayatTugas(Request $request, $id_tugas)
    {
        $title = 'Riwayat Tugas';
        $nama_pengguna = Auth::user()->nama_pengguna;
        // $role = Auth::user()->roles[0]->name;
        $role = $request->session()->get('role');

        // nama pengirim
        // hari
        // tanggal
        // jam
        // perihal : tapi yang ditampilin todo_list nya
        // url
        // lampiran

        // $semuaRiwayat = Tugas::select(
        //     'tugas.id_tugas',
        //     'tugas.nama_pengirim as nama_pengirim_tugas',
        //     'tugas.tujuan as nama_tujuan_tugas',
        //     'tugas.created_at as dateTimeTugas',

        //     'perkembangans.id_perkembangan',
        //     'perkembangans.created_at as dateTimePerkembangan',

        //     'riwayat_penerimaans.id_penerimaan',
        //     'riwayat_penerimaans.nama_pengguna as nama_pengguna_penerimaan ',
        //     'riwayat_penerimaans.created_at as dateTimePenerimaan',

        //     'riwayat_penolakans.id_penolakan',
        //     'riwayat_penolakans.nama_pengguna as nama_pengguna_penolakan ',
        //     'riwayat_penolakans.created_at as dateTimePenolakan',

        //     'riwayat_teruskans.id_teruskan',
        //     'riwayat_teruskans.nama_pengirim as nama_pengirim_teruskan ',
        //     'riwayat_teruskans.nama_tujuan as nama_tujuan_teruskan ',
        //     'riwayat_teruskans.created_at as dateTimeTeruskan',
        // )
        //     ->leftJoin('riwayat_penerimaans', 'tugas.id_tugas', '=', 'riwayat_penerimaans.id_tugas')
        //     ->leftJoin('riwayat_penolakans', 'tugas.id_tugas', '=', 'riwayat_penolakans.id_tugas')
        //     ->leftJoin('riwayat_teruskans', 'tugas.id_tugas', '=', 'riwayat_teruskans.id_tugas')
        //     ->leftJoin('perkembangans', 'tugas.id_tugas', '=', 'perkembangans.id_tugas')
        //     ->orderBy('dateTimePenerimaan', 'desc')
        //     ->orderBy('dateTimePenolakan', 'desc')
        //     ->orderBy('dateTimeTeruskan', 'desc')
        //     ->orderBy('dateTimePerkembangan', 'desc')
        //     ->where('tugas.id_tugas', $id_tugas)
        //     ->get();

        // dd($semuaRiwayat);


        // // mengambil id_tugas saja dari setiap riwayat
        // $riwayatTugasTunggal = $semuaRiwayat->pluck('id_tugas')->toArray();

        // //mengambil riwayat-riwayat dari satu tugas
        // $riwayat =


        //     dd($riwayatTugasTunggal);

        // $tugas = Tugas::findOrFail($id_tugas);

        // // Mengakses semua riwayat penerimaan yang terhubung dengan tugas
        // $riwayatPenerimaans = $tugas->riwayatPenerimaan;
        // // dd($riwayatPenerimaans);

        // // Mengakses semua riwayat penolakan yang terhubung dengan tugas
        // $perkembangans = $tugas->perkembangan;
        // $semuaRiwayat = $riwayatPenerimaans->merge($perkembangans);

        //mengambil semua riwayat yang dimiliki oleh semua tugas
        $riwayatPenerimaans = RiwayatPenerimaan::where('id_tugas', $id_tugas)->get();
        $riwayatPenolakans = RiwayatPenolakan::where('id_tugas', $id_tugas)->get();
        $riwayatTeruskans = RiwayatTeruskan::where('id_tugas', $id_tugas)->get();
        $perkembangans = Perkembangan::where('id_tugas', $id_tugas)->get();

        // $semuaRiwayat = $riwayatPenerimaans->concat($riwayatPenolakans)->concat($riwayatTeruskans)->concat($perkembangans);
        // Combine all collections into one using the concat() method
        $semuaRiwayat = new Collection();
        $semuaRiwayat = $semuaRiwayat->concat($riwayatPenerimaans);
        $semuaRiwayat = $semuaRiwayat->concat($riwayatPenolakans);
        $semuaRiwayat = $semuaRiwayat->concat($riwayatTeruskans);
        $semuaRiwayat = $semuaRiwayat->concat($perkembangans);

        // Sort the combined collection by 'created_at' in descending order
        $semuaRiwayat = $semuaRiwayat->sortByDesc('updated_at');


        // Menguraikan data JSON menjadi array PHP
        foreach ($semuaRiwayat as $riwayat) {
            $riwayatBaru = $riwayat->pihak_terlibat;
            // dd($riwayatBaru);
        }

        return view('k/riwayat-tugas', compact('perkembangans', 'semuaRiwayat', 'title', 'nama_pengguna', 'role'));
    }

    public function perkembanganTugas(Request $request, $id_tugas)
    {
        $perkembangans = Perkembangan::where('id_tugas', $id_tugas)->paginate();

        // $perkembangan = Perkembangan::where('id_tugas', $id_tugas)->first();
        // dd($perkembangan);

        $semuaTask = Perkembangan::orderBy('created_at', 'desc')->get();

        foreach ($semuaTask as $task) {
            // Ubah $created_at menjadi objek Carbon
            $createdAt = Carbon::parse($task->created_at);

            // Formatkan tanggal sesuai dengan format yang diinginkan
            $task->formattedDate = $createdAt->format('d M Y');
        }

        //Ambil title, nama pengguna dan role pengguna
        $title = 'Update Perkembangan Tugas';
        $nama_pengguna = Auth::user()->nama_pengguna;
        // $role = Auth::user()->roles[0]->name;
        $role = $request->session()->get('role');

        //Ambil jumlah tugas masuk
        $jumlahTugasMasuk = Tugas::where('tujuan', $nama_pengguna)
            ->where('ket_tujuan', 'menunggu_konfirmasi')
            ->get();
        $jumlahTugasMasuk = count($jumlahTugasMasuk);

        // $tugas = Tugas::findOrFail($id_tugas);
        // $tujuan = $tugas->tujuan;

        // $perihal = $tugas->perihal;
        // $perihal = str_replace("\r\n", " ", $perihal);

        // $title = 'Delegasi Tugas';
        // $nama_pengguna = Auth::user()->nama_pengguna;
        // $role = Auth::user()->roles[0]->name;

        // //penentuan format jam
        // $jam = Carbon::parse($tugas->tenggat_waktu_jam); // Buat objek Carbon dari jam
        // $jam = $jam->format('H:i'); // Format waktu sesuai dengan format yang diinginkan contoh '23:59'

        // //penentuan format tanggal
        // $tanggal = Carbon::parse($tugas->tenggat_waktu_tanggal); // Ubah tanggal menjadi objek Carbon
        // $tanggalFormatted = $tanggal->format('m/d/Y'); // Format tanggal menjadi "07/19/2023"

        // return view('k/edit-delegasi-tugas', compact('tugas', 'title', 'nama_pengguna', 'role', 'jam', 'tanggalFormatted', 'perihal', 'tujuan'));
        return view('k/perkembangan-tugas', compact('id_tugas', 'jumlahTugasMasuk', 'title', 'nama_pengguna', 'role', 'semuaTask', 'perkembangans'));
    }

    public function revisi(Request $request, $id_perkembangan)
    {
        $userIdnew = $request->session()->get('user_id'); // Mendapatkan ID pengguna dari sesi
        $nama_pengguna = User::where('id', $userIdnew)
            ->get('nama_pengguna');

        $data = json_decode($nama_pengguna, true); // Mengambil data dari JSON karena query diatas menghasilkan data dalam format JSON
        $nama_pengguna = $data[0]['nama_pengguna'];

        $uuid = Uuid::uuid4()->toString(); // Buat UUID baru sebagai nilai id_penolakan

        $validator = Validator::make($request->all(), [
            'alasan_revisi' => 'required',
        ]);

        // Cek apakah validasi berhasil
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $perkembangan = Perkembangan::find($id_perkembangan);
        if ($perkembangan) {
            Perkembangan::where('id_perkembangan', $id_perkembangan)->update([
                'keterangan' => 'revisi',
                'alasan_revisi' => $request->input('alasan_revisi')
            ]);
        }

        return redirect()->back()->with('success', 'Revisi berhasil dikirim.');
    }

    // Update status setelah
    public function perkembanganSelesai($id_perkembangan)
    {
        $perkembangan = Perkembangan::find($id_perkembangan);
        if ($perkembangan) {
            Perkembangan::where('id_perkembangan', $id_perkembangan)->update(['keterangan' => 'completed']);
        }

        return redirect()->back()->with('success', 'Hasil tugas diterima!');
    }

    // statistik tugas Dosen dan Staf
    public function statistikTugas(Request $request)
    {
        //Ambil title, nama pengguna dan role pengguna
        $title = 'Statistik Tugas Dosen dan Staf';
        $nama_pengguna = Auth::user()->nama_pengguna;
        $role = $request->session()->get('role');

        //Ambil jumlah tugas masuk
        $jumlahTugasMasuk = Tugas::where('tujuan', $nama_pengguna)
            ->where('ket_tujuan', 'menunggu_konfirmasi')
            ->get();
        $jumlahTugasMasuk = count($jumlahTugasMasuk);

        $role_name = 'Dosen';
        $dosens = DB::table('users')
            ->join('role_users', 'users.id', '=', 'role_users.user_id')
            ->join('roles', 'role_users.role_id', '=', 'roles.id')
            ->where('roles.name', $role_name)
            ->orderBy('nama_pengguna')
            // ->select('users.nama_pengguna')
            ->get();

        foreach ($dosens as $dosen) {
            $nama_dosen = $dosen->nama_pengguna;
            $jumlahTugasInProgress[$nama_dosen] = RiwayatPenerimaan::where('nama_pengguna', $nama_dosen)
                ->where('keterangan', 'incomplete')
                ->count();

            $jumlahTugasTotal[$nama_dosen] = RiwayatPenerimaan::where('nama_pengguna', $nama_dosen)
                ->count();
        }

        $role_name = 'Staf';
        $stafs = DB::table('users')
            ->join('role_users', 'users.id', '=', 'role_users.user_id')
            ->join('roles', 'role_users.role_id', '=', 'roles.id')
            ->where('roles.name', $role_name)
            ->orderBy('nama_pengguna')
            // ->select('users.nama_pengguna')
            ->get();

        foreach ($stafs as $staf) {
            $nama_staf = $staf->nama_pengguna;
            $jumlahTugasInProgress[$nama_staf] = RiwayatPenerimaan::where('nama_pengguna', $nama_staf)
                ->where('keterangan', 'incomplete')
                ->count();

            $jumlahTugasTotal[$nama_staf] = RiwayatPenerimaan::where('nama_pengguna', $nama_staf)
                ->count();
        }

        return view('k/statistik-tugas', compact('title', 'nama_pengguna', 'role', 'dosens', 'stafs', 'jumlahTugasInProgress', 'jumlahTugasTotal'));
    }

    public function detailStatistikTugas(Request $request, $nama_dosen_staf)
    {
        $title = 'Detail Statistik Tugas';
        $nama_pengguna = Auth::user()->nama_pengguna;
        $role = $request->session()->get('role');

        $nama_dosen_staf = $nama_dosen_staf;

        // $riwayatTeruskans = RiwayatTeruskan::where('nama_tujuan', $nama_dosen_staf)
        //     ->where('ket_tujuan', 'diterima')
        //     ->get();

        // $tugas = Tugas::where('tujuan', $nama_dosen_staf)
        //     ->where('ket_tujuan', 'diterima')
        //     ->get();

        $riwayatTeruskans = RiwayatTeruskan::select(
            'riwayat_teruskans.id_teruskan',
            'riwayat_teruskans.id_tugas as id_tugas_teruskan',
            'riwayat_teruskans.nama_pengirim as nama_pengirim',
            'riwayat_teruskans.nama_tujuan as nama_tujuan_teruskan ',
            'riwayat_teruskans.ket_tujuan as ket_tujuan_teruskan ',
            'riwayat_teruskans.created_at as dateTimeTeruskan',

            'tugas.perihal',
            'tugas.tenggat_waktu_tanggal',

            'riwayat_penerimaans.keterangan'
        )
            ->where('riwayat_teruskans.nama_tujuan', $nama_dosen_staf)
            ->where('riwayat_teruskans.ket_tujuan', 'diterima')
            ->join('tugas', 'tugas.id_tugas', '=', 'riwayat_teruskans.id_tugas')
            ->join('riwayat_penerimaans', 'riwayat_penerimaans.id_tugas', '=', 'riwayat_teruskans.id_tugas')
            ->get();

        // $tugas = tugas::select(
        //     'tugas.id_tugas',
        //     'tugas.id_tugas as id_tugas_teruskan',
        //     'riwayat_teruskans.nama_pengirim as nama_pengirim_teruskan ',
        //     'riwayat_teruskans.nama_tujuan as nama_tujuan_teruskan ',
        //     'riwayat_teruskans.ket_tujuan as ket_tujuan_teruskan ',
        //     'riwayat_teruskans.created_at as dateTimeTeruskan',

        //     'tugas.perihal',

        //     'riwayat_penerimaans.keterangan'
        // )
        //     ->where('riwayat_teruskans.nama_tujuan', $nama_dosen_staf)
        //     ->where('riwayat_teruskans.ket_tujuan', 'diterima')
        //     ->join('riwayat_teruskans', 'riwayat_teruskans.id_tugas', '=', 'tugas.id_tugas')
        //     ->get();

        $tugas = Tugas::where('tujuan', $nama_dosen_staf)
            ->where('tugas.ket_tujuan', 'diterima')
            ->join('riwayat_penerimaans', 'riwayat_penerimaans.id_tugas', '=', 'tugas.id_tugas')
            ->get();

        $semuaTugas = new Collection();
        $semuaTugas = $semuaTugas->concat($riwayatTeruskans);
        $semuaTugas = $semuaTugas->concat($tugas);

        // dd($semuaTugas);

        foreach ($semuaTugas as $tugas) {
            //penentuan nama hari
            $nama_hari = Carbon::parse($tugas->tenggat_waktu_tanggal); // Buat objek Carbon dari tanggal
            $nama_hari->locale('id'); // Set bahasa pada objek Carbon (Indonesia)
            $tugas->nama_hari = $nama_hari->isoFormat('dddd'); // Dapatkan nama hari dalam bahasa Indonesia

            //penentuan format tanggal
            $tanggal = Carbon::parse($tugas->tenggat_waktu_tanggal); // Buat objek Carbon dari tanggal
            $tugas->tanggal = $tanggal->format('j F Y'); // Format tanggal sesuai dengan format yang diinginkan contoh '8 Maret 2023'

            //penentuan format jam
            $jam = Carbon::parse($tugas->tenggat_waktu_jam); // Buat objek Carbon dari jam
            $tugas->jam = $jam->format('H:i'); // Format waktu sesuai dengan format yang diinginkan contoh '23:59'
        }

        return view('k/detail-statistik-tugas', compact('semuaTugas', 'title', 'nama_pengguna', 'role', 'nama_dosen_staf'));
    }

    public function adHoc(Request $request)
    {
        $title = 'Ad Hoc';
        $nama_pengguna = Auth::user()->nama_pengguna;
        $role = $request->session()->get('role');
        $user_id = Auth::user()->id;

        // if ($request->has('search')) {
        //     $search = $request->input('search');

        //     $usersWithRoles = DB::table('users')
        //         ->where(function ($query) use ($search) {
        //             $query->where('roles.name', 'like', '%' . $search . '%')
        //                 ->orWhere('role_users.user_id', 'like', '%' . $search . '%')
        //                 ->orWhere('users.nama_pengguna', 'like', '%' . $search . '%');
        //         })
        //         ->join('role_users', 'users.id', '=', 'role_users.user_id')
        //         ->join('roles', 'role_users.role_id', '=', 'roles.id')
        //         ->select('role_users.id', 'roles.id as id_roles', 'roles.name', 'role_users.user_id', 'users.nama_pengguna')
        //         ->get();

        //     $jumlahData = count($usersWithRoles);
        // } else {
        //     $usersWithRoles = DB::table('users')
        //         ->join('role_users', 'users.id', '=', 'role_users.user_id')
        //         ->join('roles', 'role_users.role_id', '=', 'roles.id')
        //         ->select('role_users.id', 'roles.id as id_roles', 'roles.name', 'role_users.user_id', 'users.nama_pengguna')
        //         ->get();

        //     $jumlahData = count($usersWithRoles);
        // }

        $usersWithRoles = DB::table('users')
            ->join('role_users', 'users.id', '=', 'role_users.user_id')
            ->join('roles', 'role_users.role_id', '=', 'roles.id')
            ->select('role_users.id', 'roles.id as id_roles', 'roles.name', 'role_users.user_id', 'users.nama_pengguna')
            ->where('roles.name', '=', 'AdHoc')
            ->get();

        $jumlahData = count($usersWithRoles);

        return view('k/ad-hoc', compact('usersWithRoles', 'jumlahData', 'title', 'nama_pengguna', 'role'));
    }

    public function storeAdHoc(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_pengguna' => 'required',
            // 'role' => 'required',
        ]);

        // Cek apakah validasi berhasil
        if ($validator->fails()) {
            // Jika validasi gagal, kembalikan ke halaman sebelumnya dengan pesan error
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::where('nama_pengguna', $request->nama_pengguna)->first();
        $role = Role::where('name', 'AdHoc')->first();

        $validateData = $request->all();
        $validateData['user_id'] = $user->id;
        $validateData['role_id'] = $role->id;

        RoleUser::create($validateData);

        return redirect('/k/ad-hoc')->with('success', 'Data berhasil ditambahkan.');
    }

    public function editAdHoc(Request $request, $id)
    {
        // $title = 'Delegasi Tugas';
        // $nama_pengguna = Auth::user()->nama_pengguna;
        // $role = $request->session()->get('role');
        

        $roleUser = RoleUser::findOrFail($id);

        // ambil nama pengguna yang akan di edit
        $user_id = $roleUser->user_id;
        $user = User::findOrFail($user_id);
        $nama_pengguna_edit = $user->nama_pengguna;

        $role_id = $roleUser->role_id;
        $role = Role::findOrFail($role_id);
        $nama_role_edit = $role->name;

        $title = 'Edit AdHoc';
        $nama_pengguna = Auth::user()->nama_pengguna;
        $role = $request->session()->get('role');
        $user_id = Auth::user()->id;

        return view('k/edit-ad-hoc', compact('nama_pengguna_edit', 'nama_role_edit', 'roleUser', 'title', 'nama_pengguna', 'role', ));
    }

    public function destroyAdHoc($id)
    {
        $roleUser = RoleUser::find($id);

        if ($roleUser) {
            $roleUser->delete();
            return redirect('/k/ad-hoc')->with('success', 'Data berhasil dihapus!');
        } else {
            return redirect('/k/ad-hoc')->with('error', 'Data tidak ditemukan.');
        }
    }

    public function updateAdHoc(Request $request, $id)
    {
        // Mendapatkan ID pengguna dari sesi
        $userIdnew = $request->session()->get('user_id');

        $validator = Validator::make($request->all(), [
            'nama_pengguna' => 'required',
            // 'role' => 'required',
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

        $roleUser = RoleUser::findOrFail($id);

        // Update the task fields with the submitted data
        $roleUser->update([
            'user_id' => $user_id,
            'role_id' => '4',
        ]);

        return redirect('k/ad-hoc')->with('success', 'Data berhasil diperbarui!');
    }
}
