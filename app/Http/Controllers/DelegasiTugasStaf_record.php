<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use App\Models\Tugas;
use Ramsey\Uuid\Uuid;
use App\Models\Perkembangan;
use Illuminate\Http\Request;
use App\Models\RiwayatTeruskan;
use App\Models\RiwayatPenolakan;
use App\Models\RiwayatPenerimaan;
use Illuminate\Routing\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DelegasiTugasStaf extends Controller
{
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

    // Method tugasMasuk with fitur search
    public function tugasMasuk(Request $request)
    {
        $title = 'Delegasi Tugas';
        $nama_pengguna = Auth::user()->nama_pengguna;
        // $role = Auth::user()->roles[0]->name;
        $role = $request->session()->get('role');

        if ($request->has('search')) {

            $semuaTugas = Tugas::where(function ($query) use ($request) {
                $query->where('perihal', 'like', '%' . $request->search . '%')
                    ->orWhere('nama_pengirim', 'like', '%' . $request->search . '%');
            })
                ->where('tujuan', $nama_pengguna)
                ->where('role_tujuan', $role)
                ->where('ket_tujuan', 'menunggu_konfirmasi')
                ->orderBy('updated_at', 'desc') // Mengurutkan berdasarkan waktu pembuatan terbaru (descending order)
                ->paginate(15);

            $jumlahTugas = Tugas::where(function ($query) use ($request) {
                $query->where('perihal', 'like', '%' . $request->search . '%')
                    ->orWhere('nama_pengirim', 'like', '%' . $request->search . '%');
            })
                ->where('tujuan', $nama_pengguna)
                ->where('role_tujuan', $role)
                ->where('ket_tujuan', 'menunggu_konfirmasi')
                ->get();

            $jumlahTugas = count($jumlahTugas);
        } else {
            $nama_pengguna = Auth::user()->nama_pengguna;
            $semuaTugas = Tugas::where('tujuan', $nama_pengguna)
                ->where('ket_tujuan', 'menunggu_konfirmasi')
                ->where('role_tujuan', $role)
                ->orderBy('updated_at', 'desc') // Mengurutkan berdasarkan waktu pembuatan terbaru (descending order)
                ->paginate(15);
            $jumlahTugas = Tugas::where('tujuan', $nama_pengguna)
                ->where('ket_tujuan', 'menunggu_konfirmasi')
                ->where('role_tujuan', $role)
                ->get();
            $jumlahTugas = count($jumlahTugas);
        }

        foreach ($semuaTugas as $tugas) {
            // Ubah $updated_at menjadi objek Carbon
            $createdAt = Carbon::parse($tugas->updated_at);

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

        //Ambil jumlah tugas masuk
        $jumlahTugasMasuk = Tugas::where('tujuan', $nama_pengguna)
            ->where('ket_tujuan', 'menunggu_konfirmasi')
            ->where('role_tujuan', $role)
            ->get();
        $jumlahTugasMasuk = count($jumlahTugasMasuk);

        return view('st/tugas-masuk', compact('semuaTugas', 'jumlahTugas', 'jumlahTugasMasuk', 'nama_pengguna', 'role', 'title', 'nama_pengirim'));
    }

    // public function show(Tugas $tugas)
    public function show(Request $request, Tugas $tugas)
    {
        $title = 'Detail Tugas Masuk';
        $nama_pengguna = Auth::user()->nama_pengguna;
        // $role = Auth::user()->roles[0]->name;
        $role = $request->session()->get('role');

        //pengambilan jumlah tugas masuk
        $jumlahTugas = Tugas::where('tujuan', $nama_pengguna)
            ->where('ket_tujuan', 'menunggu_konfirmasi')
            ->where('role_tujuan', $role)
            ->get();
        $jumlahTugas = count($jumlahTugas);

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

        return view('st.show', compact('jumlahTugas', 'tugas', 'title', 'nama_pengguna', 'role', 'nama_hari', 'tanggal', 'jam'));
    }

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
            'id_penerimaan' => $uuid,
            'id_tugas' => $tugas->id_tugas,
            'nama_pengguna' => $nama_pengguna
        ]);
        $riwayatPenerimaan->save();

        return redirect('st/tugas-masuk')->with('success', 'Tugas diterima!');
    }

    public function reject(Request $request, $id_tugas)
    {
        $userIdnew = $request->session()->get('user_id'); // Mendapatkan ID pengguna dari sesi
        $nama_pengguna = User::where('id', $userIdnew)
            ->get('nama_pengguna');

        $data = json_decode($nama_pengguna, true); // Mengambil data dari JSON karena query diatas menghasilkan data dalam format JSON
        $nama_pengguna = $data[0]['nama_pengguna'];

        // Buat UUID baru sebagai nilai id_penolakan
        $uuid = Uuid::uuid4()->toString();

        $messages = [
            'alasan_penolakan.required' => 'Alasan penolakan maksimal 255 kata harus diisi.',
        ];

        $validator = Validator::make($request->all(), [
            'alasan_penolakan' => 'required',
        ], $messages);

        // Cek apakah validasi berhasil
        if ($validator->fails()) {
            // Jika validasi gagal, kembalikan ke halaman sebelumnya dengan pesan error
            return redirect()->back()->withErrors($validator)->withInput();
        }

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

        return redirect('st/tugas-masuk')->with('success', 'Tugas ditolak!');
    }

    public function download($tugas)
    {
        // Tentukan path lengkap ke file yang akan diunduh
        $path = public_path('lampiran/' . $tugas);
        return response()->download($path);
    }

    public function showTugas(Tugas $tugas)
    {
        return view('st/showTugas', [
            'tugas' => $tugas
        ]);
    }

    // method tugas with fitur search
    public function tugas(Request $request)
    {
        $title = 'Delegasi Tugas';
        $nama_pengguna = Auth::user()->nama_pengguna;
        // $role = Auth::user()->roles[0]->name;
        $role = $request->session()->get('role');

        //Ambil jumlah tugas masuk
        $jumlahTugasMasuk = Tugas::where('tujuan', $nama_pengguna)
            ->where('ket_tujuan', 'menunggu_konfirmasi')
            ->where('role_tujuan', $role)
            ->get();
        $jumlahTugasMasuk = count($jumlahTugasMasuk);

        if ($request->has('search')) {
            $semuaTugas = Tugas::where(function ($query) use ($request, $nama_pengguna) {
                $query->where('perihal', 'like', '%' . $request->search . '%');
            })
                ->where('tujuan', $nama_pengguna)
                ->where('ket_tujuan', 'diterima')
                ->where('role_tujuan', $role)
                ->orderBy('updated_at', 'desc')
                ->paginate(15);

            $jumlahTugas = Tugas::where(function ($query) use ($request, $nama_pengguna) {
                $query->where('perihal', 'like', '%' . $request->search . '%');
            })
                ->where('tujuan', $nama_pengguna)
                ->where('ket_tujuan', 'diterima')
                ->where('role_tujuan', $role)
                ->get();

            $jumlahTugas = count($jumlahTugas);
        } else {
            $semuaTugas = Tugas::where('tujuan', $nama_pengguna)
                ->where('ket_tujuan', 'diterima')
                ->where('role_tujuan', $role)
                ->orderBy('updated_at', 'desc')
                ->paginate(15);
            $jumlahTugas = Tugas::where('tujuan', $nama_pengguna)
                ->where('ket_tujuan', 'diterima')
                ->where('role_tujuan', $role)
                ->get();
            $jumlahTugas = count($jumlahTugas);
        }

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

        return view('st/tugas', compact('semuaTugas', 'jumlahTugas', 'jumlahTugasMasuk', 'nama_pengguna', 'role', 'title'));
    }

    // Method to show the edit form
    public function updatePerkembangan(Request $request, $id_tugas)
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
            ->where('role_tujuan', $role)
            ->get();
        $jumlahTugasMasuk = count($jumlahTugasMasuk);

        return view('st/update-perkembangan-tugas', compact('perkembangans', 'semuaTask', 'jumlahTugasMasuk', 'id_tugas', 'title', 'nama_pengguna', 'role'));
    }

    //method yang digunakan untuk passing data
    public function addTodoList(Request $request, $id_tugas)
    {
        $userIdnew = $request->session()->get('user_id'); // Mendapatkan ID pengguna dari sesi
        $nama_pengguna = User::where('id', $userIdnew)
            ->get('nama_pengguna');

        $data = json_decode($nama_pengguna, true); // Mengambil data dari JSON karena query diatas menghasilkan data dalam format JSON
        $nama_pengguna = $data[0]['nama_pengguna'];

        // Temukan tugas berdasarkan $id_tugas
        $tugas = Tugas::findOrFail($id_tugas);

        $keterangan = $request->input('keterangan');
        $pihak_terlibat = null;

        // Buat UUID baru sebagai nilai id_tugas
        $uuid = Uuid::uuid4()->toString();

        $validator = Validator::make($request->all(), [
            'todo_list' => 'required|unique:perkembangans',
            // 'todo_list' => 'required',
        ]);

        // Cek apakah validasi berhasil
        if ($validator->fails()) {
            // Jika validasi gagal, Anda dapat melakukan penanganan kesalahan sesuai kebutuhan
            return redirect()->back()->with('warning', 'Nama subtask tersebut sudah ada sebelumnya. Mohon gunakan nama lain.');
        }

        // Simpan alasan penolakan ke dalam tabel RiwayatPenolakan (jika ada)
        $perkembangan = new Perkembangan([
            'id_perkembangan' => $uuid,
            'id_tugas' => $tugas->id_tugas,
            'todo_list' => $request->todo_list,
            'keterangan' => $keterangan,
            'pihak_terlibat' => $pihak_terlibat,
            'nama_pengguna' => $nama_pengguna
        ]);
        $perkembangan->save();

        return redirect()->route('st.updatePerkembangan', $tugas->id_tugas)->with('success', 'New task berhasil ditambahkan.');
        // return view('st.update-perkembangan-tugas')->with('success', 'New task berhasil ditambahkan.');
    }

    // Update status setelah
    public function perkembanganSelesai($id_perkembangan)
    {
        $perkembangan = Perkembangan::find($id_perkembangan);
        if ($perkembangan) {
            Perkembangan::where('id_perkembangan', $id_perkembangan)->update(['keterangan' => 'completed']);
        }

        return redirect()->back()->with('success', 'Status task berhasil diperbarui.');
    }

    //method untuk mengambil data user berdasarkan role yang dipilih pengguna menggunakan JQuery Select2
    public function getTask($id_tugas)
    {
        $todo_list  = Perkembangan::join('tugas', 'perkembangans.id_tugas', '=', 'tugas.id_tugas')
            // ->join('roles', 'role_users.role_id', '=', 'roles.id')
            ->where('tugas.id_tugas', $id_tugas)
            ->get('perkembangans.todo_list');

        $data = User::whereIn('todo_list', $todo_list)->where('todo_list', 'LIKE', '%' . request('q') . '%')->paginate(10);

        return response()->json($data);
    }

    public function getAllUser()
    {
        $data = User::where('nama_pengguna', 'LIKE', '%' . request('q') . '%')->paginate(10);

        return response()->json($data);
    }

    public function updateLampiranPerkembangan(Request $request, $id_tugas)
    {
        $todo_list = $request->input('todo_list');
        $userIdnew = $request->session()->get('user_id');

        $validator = Validator::make($request->all(), [
            'todo_list' => 'required',
            'pihak_terlibat' => 'nullable|array',
            'url' => 'nullable|url',
            'lampiran' => 'nullable|mimes:docx,pdf,rar,zip,png,jpg,jpeg',
        ]);

        // Cek apakah validasi berhasil
        if ($validator->fails()) {
            return redirect()->back()->with('error', 'Format URL atau Lampiran yang anda kirimkan tidak sesuai.');
        }

        $pihak_terlibat = $request->pihak_terlibat;
        $lampiran = $request->lampiran;
        $url = $request->url;

        if ($pihak_terlibat === null && $url === null && $lampiran === null) {
            return redirect()->back()->with('warning', 'Tidak ada data yang anda kirim. Harap masukkan minimal 1 data pendukung.');
        }

        //mengambil nilai sebelum update
        $perkembangan = Perkembangan::where('id_tugas', $id_tugas)->where('todo_list', $todo_list)->get();
        $pihak_terlibat = $perkembangan->pluck('pihak_terlibat');
        $lampiran = $perkembangan->pluck('lampiran');
        $url = $perkembangan->pluck('url');

        //jika user menginput pihak terlibat, maka akan diambil nilainya. Tetapi jika kosong maka akan mengambil nilai sebelumnya 
        if ($request->input('pihak_terlibat') == null) {
            foreach ($perkembangan as $perkembanganItem) {
                $pihak_terlibat = $perkembanganItem->pihak_terlibat;
            }
        } else {
            $pihak_terlibat = $request->input('pihak_terlibat');
        }

        //cek lampiran apakah kosong
        if (isset($request->lampiran)) {
            $lampiran = $request->file('lampiran');
            $name = 'PSTI_' . $userIdnew . '_' . date('Ymdhis') . '.' . $request->file('lampiran')->getClientOriginalExtension();
            $lampiran->move('lampiran/', $name);
            $validateData['lampiran'] = $name;
        } elseif ($request->lampiran == null) {
            $name = $lampiran[0];
        }

        //cek url apakah kosong
        if ($request->input('url') == null) {
            foreach ($perkembangan as $perkembanganItem) {
                $url = $perkembanganItem->url;
            }
        } else {
            $url = $request->input('url');
        }

        //update tabel perkembangan
        Perkembangan::where('id_tugas', $id_tugas)
            ->where('todo_list', $todo_list)
            ->update([
                'pihak_terlibat' => $pihak_terlibat,
                'url' => $url,
                'lampiran' => $name,
            ]);

        return redirect()->back()->with('success', 'Update pihak terlibat dan lampiran berhasil.');
    }
}
