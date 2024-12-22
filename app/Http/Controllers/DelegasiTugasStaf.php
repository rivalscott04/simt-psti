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
    // // Method tugasMasuk with fitur search
    public function tugasMasuk(Request $request)
    {
        $title = 'Tugas Masuk';
        $nama_pengguna = Auth::user()->nama_pengguna;
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
            $semuaTugas = DB::table('tugas')
                ->where('tujuan', $nama_pengguna)
                ->where('role_tujuan', $role)
                ->where('ket_tujuan', 'menunggu_konfirmasi')
                ->orderBy('tugas.updated_at', 'desc')
                ->paginate(15);

            $jumlahTugas = DB::table('tugas')
                ->where('tujuan', $nama_pengguna)
                ->where('role_tujuan', $role)
                ->where('ket_tujuan', 'menunggu_konfirmasi')
                ->get();

            $jumlahTugas = count($jumlahTugas);
        }

        foreach ($semuaTugas as $tugas) {
            $createdAt = Carbon::parse($tugas->updated_at);
            $tugas->formattedDate = $createdAt->format('d M Y, g:i a');
        }

        $nama_pengirim = ''; //inisialisai nilai default nama pengirim

        foreach ($semuaTugas as $tugas) {
            $user_id = $tugas->user_id;
            $nama_pengirim = User::where('id', $user_id)
                ->get('nama_pengguna');

            $data = json_decode($nama_pengirim, true); // Mengambil data dari JSON karena query diatas menghasilkan data dalam format JSON
            $nama_pengirim = $data[0]['nama_pengguna'];
        }

        if ($request->has('searchTeruskan')) {
            // $semuaTugasTeruskan = Tugas::select(
            //     'riwayat_teruskans.updated_at as updated_at_teruskan',
            //     'tugas.id_tugas',
            //     'tugas.perihal',
            //     'tugas.tujuan',
            //     'riwayat_teruskans.nama_pengirim as nama_pengirim_teruskan',
            //     'riwayat_teruskans.nama_tujuan as nama_tujuan_teruskan',
            //     'riwayat_teruskans.ket_tujuan as ket_tujuan_teruskan',
            // )
            //     ->join('riwayat_teruskans', 'tugas.id_tugas', '=', 'riwayat_teruskans.id_tugas')
            //     ->where('tugas.perihal', 'like', '%' . $request->searchTeruskan . '%')
            //     ->orwhere('riwayat_teruskans.nama_tujuan', 'like', '%' . $request->searchTeruskan . '%')
            //     ->where('riwayat_teruskans.role_pengirim', $role)
            //     ->paginate(15);

            // $jumlahTugasTeruskan = Tugas::select(
            //     'riwayat_teruskans.updated_at as updated_at_teruskan',
            //     'tugas.id_tugas',
            //     'tugas.perihal',
            //     'tugas.tujuan',
            //     'riwayat_teruskans.nama_pengirim as nama_pengirim_teruskan',
            //     'riwayat_teruskans.nama_tujuan as nama_tujuan_teruskan',
            //     'riwayat_teruskans.ket_tujuan as ket_tujuan_teruskan',
            // )
            //     ->join('riwayat_teruskans', 'tugas.id_tugas', '=', 'riwayat_teruskans.id_tugas')
            //     ->where('tugas.perihal', 'like', '%' . $request->searchTeruskan . '%')
            //     ->orwhere('riwayat_teruskans.nama_tujuan', 'like', '%' . $request->searchTeruskan . '%')
            //     ->where('riwayat_teruskans.role_pengirim', $role)
            //     ->paginate(15);

            // $jumlahTugasTeruskan = count($jumlahTugasTeruskan);

            $semuaTugasTeruskan = DB::table('tugas')
                ->select(
                    'tugas.id_tugas',
                    'tugas.user_id',
                    'tugas.nama_pengirim',
                    'tugas.perihal',
                    'tugas.updated_at',
                    'riwayat_teruskans.nama_pengirim as nama_pengirim_teruskan',
                    'riwayat_teruskans.nama_tujuan'
                )
                ->join('riwayat_teruskans', function ($join) use ($role) {
                    $join->on('tugas.id_tugas', '=', 'riwayat_teruskans.id_tugas')
                        ->Where('riwayat_teruskans.role_tujuan', $role)
                        ->Where('riwayat_teruskans.ket_tujuan', 'menunggu_konfirmasi');
                })
                ->where('tugas.perihal', 'like', '%' . $request->searchTeruskan . '%')
                ->orwhere('riwayat_teruskans.nama_pengirim', 'like', '%' . $request->searchTeruskan . '%')
                ->distinct()
                ->orderBy('tugas.updated_at', 'desc')
                ->paginate(15);

            $jumlahTugasTeruskan = DB::table('tugas')
                ->select(
                    'tugas.id_tugas',
                    'tugas.user_id',
                    'tugas.nama_pengirim',
                    'tugas.perihal',
                    'tugas.updated_at',
                    'riwayat_teruskans.nama_pengirim as nama_pengirim_teruskan',
                    'riwayat_teruskans.nama_tujuan'
                )
                ->join('riwayat_teruskans', function ($join) use ($role) {
                    $join->on('tugas.id_tugas', '=', 'riwayat_teruskans.id_tugas')
                        ->Where('riwayat_teruskans.role_tujuan', $role)
                        ->Where('riwayat_teruskans.ket_tujuan', 'menunggu_konfirmasi');
                })
                ->where('tugas.perihal', 'like', '%' . $request->searchTeruskan . '%')
                ->orwhere('riwayat_teruskans.nama_pengirim', 'like', '%' . $request->searchTeruskan . '%')
                ->distinct()
                ->orderBy('tugas.updated_at', 'desc')
                ->count();
        } else {
            $semuaTugasTeruskan = DB::table('tugas')
                ->select(
                    'tugas.id_tugas',
                    'tugas.user_id',
                    'tugas.nama_pengirim',
                    'tugas.perihal',
                    'tugas.updated_at',
                    'riwayat_teruskans.nama_pengirim as nama_pengirim_teruskan',
                    'riwayat_teruskans.nama_tujuan'
                )
                ->join('riwayat_teruskans', function ($join) use ($role) {
                    $join->on('tugas.id_tugas', '=', 'riwayat_teruskans.id_tugas')
                        ->Where('riwayat_teruskans.role_tujuan', $role)
                        ->Where('riwayat_teruskans.ket_tujuan', 'menunggu_konfirmasi');
                })
                ->distinct()
                ->orderBy('tugas.updated_at', 'desc')
                ->paginate(15);

            $jumlahTugasTeruskan = DB::table('tugas')
                ->select(
                    'tugas.id_tugas',
                    'tugas.user_id',
                    'tugas.nama_pengirim',
                    'tugas.perihal',
                    'tugas.updated_at',
                    'riwayat_teruskans.nama_pengirim as nama_pengirim_teruskan',
                    'riwayat_teruskans.nama_tujuan'
                )
                ->join('riwayat_teruskans', function ($join) use ($role) {
                    $join->on('tugas.id_tugas', '=', 'riwayat_teruskans.id_tugas')
                        ->Where('riwayat_teruskans.role_tujuan', $role)
                        ->Where('riwayat_teruskans.ket_tujuan', 'menunggu_konfirmasi');
                })
                ->distinct()
                ->get();

            $jumlahTugasTeruskan = count($jumlahTugasTeruskan);
        }

        foreach ($semuaTugasTeruskan as $tugas) {
            // Ubah $updated_at menjadi objek Carbon
            $createdAt = Carbon::parse($tugas->updated_at);

            // Formatkan tanggal sesuai dengan format yang diinginkan
            $tugas->formattedDate = $createdAt->format('d M Y, g:i a');
        }

        $nama_pengirim = ''; //inisialisai nilai default nama pengirim

        foreach ($semuaTugasTeruskan as $tugas) {
            // Mengakses properti user_id dari model Tugas
            $user_id = $tugas->user_id;
            $nama_pengirim = User::where('id', $user_id)
                ->get('nama_pengguna');

            $data = json_decode($nama_pengirim, true); // Mengambil data dari JSON karena query diatas menghasilkan data dalam format JSON
            $nama_pengirim = $data[0]['nama_pengguna'];
        }

        //Ambil jumlah tugas masuk
        $jumlahTugasMasuk1 = DB::table('tugas')
            ->where('tujuan', $nama_pengguna)
            ->where('role_tujuan', $role)
            ->where('ket_tujuan', 'menunggu_konfirmasi')
            ->count();

        $jumlahTugasMasuk2 = DB::table('tugas')
            ->select(
                'tugas.id_tugas',
                'tugas.user_id',
                'tugas.nama_pengirim',
                'tugas.perihal',
                'tugas.updated_at',
                'riwayat_teruskans.nama_pengirim as nama_pengirim_teruskan',
                'riwayat_teruskans.nama_tujuan'
            )
            ->join('riwayat_teruskans', function ($join) use ($role) {
                $join->on('tugas.id_tugas', '=', 'riwayat_teruskans.id_tugas')
                    ->Where('riwayat_teruskans.role_tujuan', $role)
                    ->Where('riwayat_teruskans.ket_tujuan', 'menunggu_konfirmasi');
            })
            ->distinct()
            ->count();

        $jumlahTugasMasuk = $jumlahTugasMasuk1 + $jumlahTugasMasuk2;

        return view('st/tugas-masuk', compact('semuaTugasTeruskan', 'jumlahTugasTeruskan', 'semuaTugas', 'jumlahTugas', 'jumlahTugasMasuk', 'nama_pengguna', 'role', 'title', 'nama_pengirim'));
    }

    // public function show(Tugas $tugas)
    public function show(Request $request, Tugas $tugas)
    {
        $title = 'Detail Tugas Masuk';
        $nama_pengguna = Auth::user()->nama_pengguna;
        $role = $request->session()->get('role');

        // cek jika tugas merupakan tugas terusan, maka mengambil nama_pengirim dari tabel riwayat_teruskans
        $tugas_terusans = RiwayatTeruskan::where('id_tugas', $tugas->id_tugas)->get();

        if ($tugas_terusans->isEmpty()) {
            $tugas->nama_pengirim = $tugas->nama_pengirim;
        } else {
            $nama_pengirim = RiwayatTeruskan::where('id_tugas', $tugas->id_tugas)
                ->orderBy('created_at', 'desc')
                ->limit(1)
                ->get('nama_pengirim');

            $data = json_decode($nama_pengirim, true);
            $nama_pengirim = $data[0]['nama_pengirim'];

            $tugas->nama_pengirim = $nama_pengirim;
        }

        //Ambil jumlah tugas masuk
        $jumlahTugasMasuk1 = DB::table('tugas')
            ->where('tujuan', $nama_pengguna)
            ->where('role_tujuan', $role)
            ->where('ket_tujuan', 'menunggu_konfirmasi')
            ->count();

        $jumlahTugasMasuk2 = DB::table('tugas')
            ->select(
                'tugas.id_tugas',
                'tugas.user_id',
                'tugas.nama_pengirim',
                'tugas.perihal',
                'tugas.updated_at',
                'riwayat_teruskans.nama_pengirim as nama_pengirim_teruskan',
                'riwayat_teruskans.nama_tujuan'
            )
            ->join('riwayat_teruskans', function ($join) use ($role) {
                $join->on('tugas.id_tugas', '=', 'riwayat_teruskans.id_tugas')
                    ->Where('riwayat_teruskans.role_tujuan', $role)
                    ->Where('riwayat_teruskans.ket_tujuan', 'menunggu_konfirmasi');
            })
            ->distinct()
            ->count();

        $jumlahTugasMasuk = $jumlahTugasMasuk1 + $jumlahTugasMasuk2;

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

        return view('st.show', compact('jumlahTugasMasuk', 'tugas', 'title', 'nama_pengguna', 'role', 'nama_hari', 'tanggal', 'jam'));
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

        $tugas_terusans = RiwayatTeruskan::where('id_tugas', $id_tugas)->get();

        if ($tugas_terusans->isEmpty()) {

            $tugas->update([
                'ket_tujuan' => 'diterima',
            ]);

            // Buat dan simpan riwayat penerimaan baru
            $riwayatPenerimaan = new RiwayatPenerimaan([
                'id_penerimaan' => $uuid,
                'id_tugas' => $tugas->id_tugas,
                'nama_pengguna' => $nama_pengguna,
                'keterangan' => 'incomplete'
            ]);
            $riwayatPenerimaan->save();
        } else {
            RiwayatTeruskan::where('id_tugas', $id_tugas)
                ->orderBy('created_at', 'desc')
                ->limit(1)
                ->update(['ket_tujuan' => 'diterima']);

            // Buat dan simpan riwayat penerimaan baru
            $riwayatPenerimaan = new RiwayatPenerimaan([
                'id_penerimaan' => $uuid,
                'id_tugas' => $tugas->id_tugas,
                'nama_pengguna' => $nama_pengguna,
                'keterangan' => 'incomplete'
            ]);
            $riwayatPenerimaan->save();
        }

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

        $tugas_terusans = RiwayatTeruskan::where('id_tugas', $id_tugas)->get();

        if ($tugas_terusans->isEmpty()) {

            $tugas->update([
                'ket_tujuan' => 'ditolak',
            ]);

            $riwayatPenolakan = new RiwayatPenolakan([
                'id_tugas' => $tugas->id_tugas,
                'alasan_penolakan' => $request->input('alasan_penolakan'),
                'id_penolakan' => $uuid,
                'nama_pengguna' => $nama_pengguna
            ]);
            $riwayatPenolakan->save();
        } else {
            $tugas->update([
                'ket_tujuan' => 'menunggu_konfirmasi',
            ]);

            RiwayatTeruskan::where('id_tugas', $id_tugas)
                ->orderBy('created_at', 'desc')
                ->limit(1)
                ->update(['ket_tujuan' => 'ditolak']);

            $riwayatPenolakan = new RiwayatPenolakan([
                'id_tugas' => $tugas->id_tugas,
                'alasan_penolakan' => $request->input('alasan_penolakan'),
                'id_penolakan' => $uuid,
                'nama_pengguna' => $nama_pengguna
            ]);
            $riwayatPenolakan->save();
        }

        return redirect('st/tugas-masuk')->with('success', 'Tugas ditolak!');
    }

    public function download($tugas)
    {
        $path = public_path('lampiran/' . $tugas);
        return response()->download($path);
    }

    // method tugas with fitur search
    public function tugas(Request $request)
    {
        $title = 'Tugas';
        $nama_pengguna = Auth::user()->nama_pengguna;
        $role = $request->session()->get('role');

        //Ambil jumlah tugas masuk
        $jumlahTugasMasuk1 = DB::table('tugas')
            ->where('tujuan', $nama_pengguna)
            ->where('role_tujuan', $role)
            ->where('ket_tujuan', 'menunggu_konfirmasi')
            ->count();

        $jumlahTugasMasuk2 = DB::table('tugas')
            ->select(
                'tugas.id_tugas',
                'tugas.user_id',
                'tugas.nama_pengirim',
                'tugas.perihal',
                'tugas.updated_at',
                'riwayat_teruskans.nama_pengirim as nama_pengirim_teruskan',
                'riwayat_teruskans.nama_tujuan'
            )
            ->join('riwayat_teruskans', function ($join) use ($role) {
                $join->on('tugas.id_tugas', '=', 'riwayat_teruskans.id_tugas')
                    ->Where('riwayat_teruskans.role_tujuan', $role)
                    ->Where('riwayat_teruskans.ket_tujuan', 'menunggu_konfirmasi');
            })
            ->distinct()
            ->count();

        $jumlahTugasMasuk = $jumlahTugasMasuk1 + $jumlahTugasMasuk2;

        if ($request->has('search')) {
            // before penambahan join ke tabel riwayat penerimaan untuk mendapatkan atribut "keterangan"
            // $semuaTugas = Tugas::where(function ($query) use ($request, $nama_pengguna) {
            //     $query->where('perihal', 'like', '%' . $request->search . '%');
            // })
            //     ->where('tujuan', $nama_pengguna)
            //     ->where('ket_tujuan', 'diterima')
            //     ->where('role_tujuan', $role)
            //     ->orderBy('tugas.tenggat_waktu_tanggal')
            //     ->orderBy('tugas.tenggat_waktu_jam')
            //     ->paginate(15);

            // $jumlahTugas = Tugas::where(function ($query) use ($request, $nama_pengguna) {
            //     $query->where('perihal', 'like', '%' . $request->search . '%');
            // })
            //     ->where('tujuan', $nama_pengguna)
            //     ->where('ket_tujuan', 'diterima')
            //     ->where('role_tujuan', $role)
            //     ->get();
            // $jumlahTugas = count($jumlahTugas);

            $semuaTugas = Tugas::join('riwayat_penerimaans', 'tugas.id_tugas', '=', 'riwayat_penerimaans.id_tugas')
                ->where(function ($query) use ($request, $nama_pengguna) {
                    $query->where('perihal', 'like', '%' . $request->search . '%');
                })
                ->where('tujuan', $nama_pengguna)
                ->where('ket_tujuan', 'diterima')
                ->where('role_tujuan', $role)
                ->orderBy('tugas.tenggat_waktu_tanggal')
                ->orderBy('tugas.tenggat_waktu_jam')
                ->paginate(15);

            $jumlahTugas = Tugas::join('riwayat_penerimaans', 'tugas.id_tugas', '=', 'riwayat_penerimaans.id_tugas')
                ->where(function ($query) use ($request, $nama_pengguna) {
                    $query->where('perihal', 'like', '%' . $request->search . '%');
                })
                ->where('tujuan', $nama_pengguna)
                ->where('ket_tujuan', 'diterima')
                ->where('role_tujuan', $role)
                ->get();
            $jumlahTugas = count($jumlahTugas);
        } else {
            // before penambahan join ke tabel riwayat penerimaan untuk mendapatkan atribut "keterangan"
            // $semuaTugas = Tugas::where('tujuan', $nama_pengguna)
            //     ->where('ket_tujuan', 'diterima')
            //     ->where('role_tujuan', $role)
            //     ->orderBy('tugas.tenggat_waktu_tanggal')
            //     ->orderBy('tugas.tenggat_waktu_jam')
            //     ->paginate(15);
            // $jumlahTugas = Tugas::where('tujuan', $nama_pengguna)
            //     ->where('ket_tujuan', 'diterima')
            //     ->where('role_tujuan', $role)
            //     ->get();
            // $jumlahTugas = count($jumlahTugas);

            $semuaTugas = Tugas::join('riwayat_penerimaans', 'tugas.id_tugas', '=', 'riwayat_penerimaans.id_tugas')
                ->where('tujuan', $nama_pengguna)
                ->where('ket_tujuan', 'diterima')
                ->where('role_tujuan', $role)
                ->orderBy('tugas.tenggat_waktu_tanggal')
                ->orderBy('tugas.tenggat_waktu_jam')
                ->paginate(15);

            $jumlahTugas = Tugas::join('riwayat_penerimaans', 'tugas.id_tugas', '=', 'riwayat_penerimaans.id_tugas')
                ->where('tujuan', $nama_pengguna)
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

        // tambahan untuk tugas yang diterima yang merupakan hasil terusan
        if ($request->has('searchTeruskan')) {
            // before penambahan join ke tabel riwayat penerimaan untuk mendapatkan atribut "keterangan"
            // $semuaTugasTeruskan = DB::table('tugas')
            //     ->join('riwayat_teruskans', function ($join) use ($role) {
            //         $join->on('tugas.id_tugas', '=', 'riwayat_teruskans.id_tugas')
            //             ->Where('riwayat_teruskans.role_tujuan', $role)
            //             ->Where('riwayat_teruskans.ket_tujuan', 'diterima');
            //     })
            //     ->where('tugas.perihal', 'like', '%' . $request->searchTeruskan . '%')
            //     ->distinct()
            //     ->orderBy('tugas.tenggat_waktu_tanggal')
            //     ->orderBy('tugas.tenggat_waktu_jam')
            //     ->paginate(15);

            // $jumlahTugasTeruskan = DB::table('tugas')
            //     ->join('riwayat_teruskans', function ($join) use ($role) {
            //         $join->on('tugas.id_tugas', '=', 'riwayat_teruskans.id_tugas')
            //             ->Where('riwayat_teruskans.role_tujuan', $role)
            //             ->Where('riwayat_teruskans.ket_tujuan', 'diterima');
            //     })
            //     ->where('tugas.perihal', 'like', '%' . $request->searchTeruskan . '%')
            //     ->distinct()
            //     ->count();

            $semuaTugasTeruskan = DB::table('tugas')
                ->join('riwayat_penerimaans', 'tugas.id_tugas', '=', 'riwayat_penerimaans.id_tugas')
                ->join('riwayat_teruskans', function ($join) use ($role) {
                    $join->on('tugas.id_tugas', '=', 'riwayat_teruskans.id_tugas')
                        ->Where('riwayat_teruskans.role_tujuan', $role)
                        ->Where('riwayat_teruskans.ket_tujuan', 'diterima');
                })
                ->where('tugas.perihal', 'like', '%' . $request->searchTeruskan . '%')
                ->distinct()
                ->orderBy('tugas.tenggat_waktu_tanggal')
                ->orderBy('tugas.tenggat_waktu_jam')
                ->paginate(15);

            $jumlahTugasTeruskan = DB::table('tugas')
                ->join('riwayat_penerimaans', 'tugas.id_tugas', '=', 'riwayat_penerimaans.id_tugas')
                ->join('riwayat_teruskans', function ($join) use ($role) {
                    $join->on('tugas.id_tugas', '=', 'riwayat_teruskans.id_tugas')
                        ->Where('riwayat_teruskans.role_tujuan', $role)
                        ->Where('riwayat_teruskans.ket_tujuan', 'diterima');
                })
                ->where('tugas.perihal', 'like', '%' . $request->searchTeruskan . '%')
                ->distinct()
                ->count();
        } else {
            // before penambahan join ke tabel riwayat penerimaan untuk mendapatkan atribut "keterangan"
            // $semuaTugasTeruskan = DB::table('tugas')
            //     ->join('riwayat_teruskans', function ($join) use ($role) {
            //         $join->on('tugas.id_tugas', '=', 'riwayat_teruskans.id_tugas')
            //             ->Where('riwayat_teruskans.role_tujuan', $role)
            //             ->Where('riwayat_teruskans.ket_tujuan', 'diterima');
            //     })
            //     ->distinct()
            //     ->orderBy('tugas.tenggat_waktu_tanggal')
            //     ->orderBy('tugas.tenggat_waktu_jam')
            //     ->paginate(15);

            // $jumlahTugasTeruskan = DB::table('tugas')
            //     ->join('riwayat_teruskans', function ($join) use ($role) {
            //         $join->on('tugas.id_tugas', '=', 'riwayat_teruskans.id_tugas')
            //             ->Where('riwayat_teruskans.role_tujuan', $role)
            //             ->Where('riwayat_teruskans.ket_tujuan', 'diterima');
            //     })
            //     ->distinct()
            //     ->count();

            $semuaTugasTeruskan = DB::table('tugas')
                ->join('riwayat_penerimaans', 'tugas.id_tugas', '=', 'riwayat_penerimaans.id_tugas')
                ->join('riwayat_teruskans', function ($join) use ($role) {
                    $join->on('tugas.id_tugas', '=', 'riwayat_teruskans.id_tugas')
                        ->Where('riwayat_teruskans.role_tujuan', $role)
                        ->Where('riwayat_teruskans.ket_tujuan', 'diterima');
                })
                ->distinct()
                ->orderBy('tugas.tenggat_waktu_tanggal')
                ->orderBy('tugas.tenggat_waktu_jam')
                ->paginate(15);

            $jumlahTugasTeruskan = DB::table('tugas')
                ->join('riwayat_penerimaans', 'tugas.id_tugas', '=', 'riwayat_penerimaans.id_tugas')
                ->join('riwayat_teruskans', function ($join) use ($role) {
                    $join->on('tugas.id_tugas', '=', 'riwayat_teruskans.id_tugas')
                        ->Where('riwayat_teruskans.role_tujuan', $role)
                        ->Where('riwayat_teruskans.ket_tujuan', 'diterima');
                })
                ->distinct()
                ->count();
        }

        foreach ($semuaTugasTeruskan as $tugas) {
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

        return view('st/tugas', compact('semuaTugasTeruskan', 'jumlahTugasTeruskan', 'semuaTugas', 'jumlahTugas', 'jumlahTugasMasuk', 'nama_pengguna', 'role', 'title'));
    }

    // Method to show the edit form
    public function updatePerkembangan(Request $request, $id_tugas)
    {
        $title = 'Update Perkembangan Tugas';
        $nama_pengguna = Auth::user()->nama_pengguna;
        $role = $request->session()->get('role');

        $tugas = Tugas::findOrFail($id_tugas); // Temukan tugas berdasarkan $id_tugas
        $riwayat_penerimaan = $tugas->riwayatPenerimaan; // mengambil riwayat_penerimaan ketika id_tugas sama dengan id_tugas pada tabel tugas menggunakan

        $perkembangans = Perkembangan::where('id_tugas', $id_tugas)
            ->orderBy('created_at')
            ->paginate();

        $semuaTask = Perkembangan::orderBy('created_at', 'desc')->get();

        foreach ($semuaTask as $task) {
            // Ubah $created_at menjadi objek Carbon
            $createdAt = Carbon::parse($task->created_at);

            // Formatkan tanggal sesuai dengan format yang diinginkan
            $task->formattedDate = $createdAt->format('d M Y');
        }

        //Ambil jumlah tugas masuk
        $jumlahTugasMasuk1 = DB::table('tugas')
            ->where('tujuan', $nama_pengguna)
            ->where('role_tujuan', $role)
            ->where('ket_tujuan', 'menunggu_konfirmasi')
            ->count();

        $jumlahTugasMasuk2 = DB::table('tugas')
            ->select(
                'tugas.id_tugas',
                'tugas.user_id',
                'tugas.nama_pengirim',
                'tugas.perihal',
                'tugas.updated_at',
                'riwayat_teruskans.nama_pengirim as nama_pengirim_teruskan',
                'riwayat_teruskans.nama_tujuan'
            )
            ->join('riwayat_teruskans', function ($join) use ($role) {
                $join->on('tugas.id_tugas', '=', 'riwayat_teruskans.id_tugas')
                    ->Where('riwayat_teruskans.role_tujuan', $role)
                    ->Where('riwayat_teruskans.ket_tujuan', 'menunggu_konfirmasi');
            })
            ->distinct()
            ->count();

        $jumlahTugasMasuk = $jumlahTugasMasuk1 + $jumlahTugasMasuk2;

        return view('st/update-perkembangan-tugas', compact('tugas', 'riwayat_penerimaan', 'perkembangans', 'semuaTask', 'jumlahTugasMasuk', 'id_tugas', 'title', 'nama_pengguna', 'role'));
    }

    //method yang digunakan untuk passing data
    public function addTodoList(Request $request, $id_tugas)
    {
        $userIdnew = $request->session()->get('user_id'); // Mendapatkan ID pengguna dari sesi
        $nama_pengguna = User::where('id', $userIdnew)
            ->get('nama_pengguna');

        $data = json_decode($nama_pengguna, true); // Mengambil data dari JSON karena query diatas menghasilkan data dalam format JSON
        $nama_pengguna = $data[0]['nama_pengguna'];

        $uuid = Uuid::uuid4()->toString(); // Buat UUID baru sebagai nilai id_tugas

        $tugas = Tugas::findOrFail($id_tugas); // Temukan tugas berdasarkan $id_tugas

        $keterangan = $request->input('keterangan');
        $pihak_terlibat = null;

        $validator = Validator::make($request->all(), [
            'todo_list' => 'required|unique:perkembangans',
        ]);

        // Cek apakah validasi berhasil
        if ($validator->fails()) {
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
    }

    // Update status setelah
    public function updateStatusPerkembangan($id_perkembangan)
    {
        $perkembangan = Perkembangan::find($id_perkembangan);
        if ($perkembangan) {
            Perkembangan::where('id_perkembangan', $id_perkembangan)->update(['keterangan' => 'menunggu_konfirmasi']);
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

    public function riwayatTugas(Request $request, $id_tugas)
    {
        $title = 'Riwayat Tugas';
        $nama_pengguna = Auth::user()->nama_pengguna;
        $role = $request->session()->get('role');

        //Ambil jumlah tugas masuk
        $jumlahTugasMasuk1 = DB::table('tugas')
            ->where('tujuan', $nama_pengguna)
            ->where('role_tujuan', $role)
            ->where('ket_tujuan', 'menunggu_konfirmasi')
            ->count();

        $jumlahTugasMasuk2 = DB::table('tugas')
            ->select(
                'tugas.id_tugas',
                'tugas.user_id',
                'tugas.nama_pengirim',
                'tugas.perihal',
                'tugas.updated_at',
                'riwayat_teruskans.nama_pengirim as nama_pengirim_teruskan',
                'riwayat_teruskans.nama_tujuan'
            )
            ->join('riwayat_teruskans', function ($join) use ($role) {
                $join->on('tugas.id_tugas', '=', 'riwayat_teruskans.id_tugas')
                    ->Where('riwayat_teruskans.role_tujuan', $role)
                    ->Where('riwayat_teruskans.ket_tujuan', 'menunggu_konfirmasi');
            })
            ->distinct()
            ->count();

        $jumlahTugasMasuk = $jumlahTugasMasuk1 + $jumlahTugasMasuk2;

        //mengambil semua riwayat yang dimiliki oleh semua tugas
        $riwayatPenerimaans = RiwayatPenerimaan::where('id_tugas', $id_tugas)->get();
        $riwayatPenolakans = RiwayatPenolakan::where('id_tugas', $id_tugas)->get();
        $riwayatTeruskans = RiwayatTeruskan::where('id_tugas', $id_tugas)->get();
        $perkembangans = Perkembangan::where('id_tugas', $id_tugas)->get();

        // Combine all collections into one using the concat() method
        $semuaRiwayat = new Collection();
        $semuaRiwayat = $semuaRiwayat->concat($riwayatPenerimaans);
        $semuaRiwayat = $semuaRiwayat->concat($riwayatPenolakans);
        $semuaRiwayat = $semuaRiwayat->concat($riwayatTeruskans);
        $semuaRiwayat = $semuaRiwayat->concat($perkembangans);

        // Sort the combined collection by 'created_at' in descending order
        $semuaRiwayat = $semuaRiwayat->sortByDesc('created_at');

        // Menguraikan data JSON menjadi array PHP
        foreach ($semuaRiwayat as $riwayat) {
            $riwayatBaru = $riwayat->pihak_terlibat;
        }

        return view('st/riwayat-tugas', compact('jumlahTugasMasuk', 'perkembangans', 'semuaRiwayat', 'title', 'nama_pengguna', 'role'));
    }

    public function updateStatusRiwayatPenerimaan($id_tugas)
    {
        $riwayatPenerimaan = RiwayatPenerimaan::where('id_tugas', $id_tugas);
        if ($riwayatPenerimaan) {
            RiwayatPenerimaan::where('id_tugas', $id_tugas)->update(['keterangan' => 'completed']);
        }

        return redirect()->route('st.tugas')->with('success', 'Tugas telah selesai. Semangat mengerjakan tugas berikutnya :)');
    }
}
