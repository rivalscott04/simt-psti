<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Tugas;
use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;


class DelegasiTugasKaprodi extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('search')) {
            // $semuaTugas = Tugas::where('perihal', 'like', '%' . $request->search . '%')
            //     ->orWhere('tujuan', 'like', '%' . $request->search . '%')
            //     ->paginate(15);

            // $jumlahTugas = Tugas::where('perihal', 'like', '%' . $request->search . '%')
            //     ->orWhere('tujuan', 'like', '%' . $request->search . '%')
            //     ->get();

            // $jumlahTugas = count($jumlahTugas);

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
            // $semuaTugas = Tugas::paginate(15);
            // $jumlahTugas = Tugas::all();
            // $jumlahTugas = count($jumlahTugas);

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

        return view('k/delegasi-tugas', compact('semuaTugas', 'jumlahTugas', 'nama_pengguna', 'role', 'title'));
    }

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
        // dd($userIdnew);

        // Ambil data tujuan yang dikirimkan dari frontend
        // $selectedNama = $request->input('selectedNama');
        // dd($selectedNama);

        // Ambil data jam yang dikirimkan dari frontend
        // $tenggat_waktu_jam = $request->input('tenggat_waktu_jam');
        // dd($selectedTime);


        // Ambil data tanggal yang dikirimkan dari frontend
        // $tanggalDipilih = $request->input('tanggalDipilih');
        // Simpan data waktu yang dipilih dalam format yang sesuai (misalnya: Y-m-d H:i:s)
        $selectedTime = date('Y-m-d H:i:s', strtotime($request->input('tenggat_waktu_tanggal')));

        // Inisialisasi nilai default keterangan tujuan
        $ket_tujuan = 'menunggu_konfirmasi';

        // Buat UUID baru sebagai nilai id_tugas
        $uuid = Uuid::uuid4()->toString();

        // $validateData = $request->validate([
        //     'user_id' => $userId,
        //     'tujuan' => 'required',
        //     'perihal' => 'required',
        //     'tenggat_waktu_jam' => $selectedTime,
        //     'tenggat_waktu_tanggal' => $tanggalDipilih,
        //     'url' => 'nullable|url',
        //     'lampiran' => 'required|mimes:docx,pdf,rar',
        //     'ket_tujuan' => 'nullable|in:menunggu_konfirmasi,diterima,ditolak'
        // ]);

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


        // Jika validasi berhasil dan file diunggah, proses file
        // if ($request->hasFile('lampiran')) {
        //     $filename = time() . '.' . $request->file->extension();
        //     $request->file->move(public_path('documents'), $filename);

        //     // Simpan nama file unik ke dalam $validateData
        //     $validateData['lampiran'] = $filename;
        // }
        // $keterangan = $request->input('ket_tujuan', 'menunggu konfirmasi');



        $validateData = $request->all();
        $validateData['id_tugas'] = $uuid;
        $validateData['user_id'] = $userIdnew;

        // dd($validateData['user_id']);
        // $validateData['tujuan'] = $selectedNama;
        // $validateData['tenggat_waktu_jam'] = $tenggat_waktu_jam;
        $validateData['tenggat_waktu_tanggal'] = $selectedTime;
        $validateData['ket_tujuan'] = $ket_tujuan;

        // // Cek apakah validasi berhasil
        // if ($validator->fails()) {
        //     // Jika validasi gagal, kembalikan ke halaman sebelumnya dengan pesan error
        //     return redirect()->back()->withErrors($validator)->withInput();
        // }

        Tugas::create($validateData);

        // Tugas::create([
        //     'user_id' => $validateData->input('user_id'),
        //     'tujuan' => 'required',
        //     'perihal' => 'required',
        //     'tenggat_waktu_jam' => $selectedTime,
        //     'tenggat_waktu_tanggal' => $tanggalDipilih,
        //     'url' => 'nullable',
        //     'lampiran' => 'required|mimes:docx,pdf,rar',
        //     'ket_tujuan' => 'required',
        // ]);

        return redirect('k/delegasi-tugas')->with('success', 'Tugas berhasil didelegasikan');
    }
}
