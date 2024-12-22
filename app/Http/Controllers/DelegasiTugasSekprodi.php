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
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DelegasiTugasSekprodi extends Controller
{
    // public function index(Request $request)
    // {
    //     $user_id = Auth::user()->id;
    //     $title = 'Delegasi Tugas';
    //     $nama_pengguna = Auth::user()->nama_pengguna;
    //     $role = Auth::user()->roles[0]->name;

    //     if ($request->has('search')) {
    //         $search = $request->input('search');

    //         $semuaTugas = DB::table('tugas')
    //             ->where(function ($query) use ($search) {
    //                 $query->where('perihal', 'like', '%' . $search . '%')
    //                     ->orWhere('tujuan', 'like', '%' . $search . '%');
    //             })
    //             ->where('user_id', $user_id)
    //             ->orderBy('created_at', 'desc')
    //             ->paginate(1);

    //         $jumlahTugas = DB::table('tugas')
    //             ->where(function ($query) use ($search) {
    //                 $query->where('perihal', 'like', '%' . $search . '%')
    //                     ->orWhere('tujuan', 'like', '%' . $search . '%');
    //             })
    //             ->where('user_id', $user_id)
    //             ->orderBy('created_at', 'desc')
    //             ->get();

    //         $jumlahTugas = count($jumlahTugas);

    //         $semuaTugasTeruskan = Tugas::select(
    //             'riwayat_teruskans.created_at as created_at_teruskan',
    //             'tugas.id_tugas',
    //             'tugas.perihal as tugas_perihal',
    //             'tugas.tujuan as tugas_tujuan',
    //             'tugas.user_id',
    //             'tugas.ket_tujuan',
    //             'riwayat_teruskans.nama_pengirim',
    //             'riwayat_teruskans.nama_tujuan',
    //             'riwayat_teruskans.ket_tujuan as ket_tujuan_teruskan',
    //         )
    //             ->join('riwayat_teruskans', 'tugas.id_tugas', '=', 'riwayat_teruskans.id_tugas')
    //             ->where('tugas.perihal', 'like', '%' . $request->searchTeruskan . '%')
    //             ->where('tugas.tujuan', 'like', '%' . $request->searchTeruskan . '%')
    //             ->paginate(1);

    //         $jumlahTugasTeruskan = Tugas::select(
    //             'riwayat_teruskans.created_at as created_at_teruskan',
    //             'tugas.id_tugas',
    //             'tugas.perihal',
    //             'tugas.tujuan',
    //             'tugas.user_id',
    //             'tugas.ket_tujuan',
    //             'riwayat_teruskans.nama_pengirim',
    //             'riwayat_teruskans.nama_tujuan',
    //             'riwayat_teruskans.ket_tujuan as ket_tujuan_teruskan',
    //         )
    //             ->join('riwayat_teruskans', 'tugas.id_tugas', '=', 'riwayat_teruskans.id_tugas')
    //             ->where('tugas.perihal', 'like', '%' . $request->searchTeruskan . '%')
    //             ->where('tugas.tujuan', 'like', '%' . $request->searchTeruskan . '%')
    //             ->get();

    //         $jumlahTugasTeruskan = count($jumlahTugasTeruskan);
    //     } else {
    //         // $tugas = Tugas::select(
    //         //     'tugas.id_tugas',
    //         //     'tugas.nama_pengirim as nama_pengirim_tugas',
    //         //     'tugas.tujuan as nama_tujuan_tugas',
    //         //     'tugas.created_at as dateTimeTugas',

    //         //     'perkembangans.id_perkembangan',
    //         //     'perkembangans.created_at as dateTimePerkembangan',

    //         //     'riwayat_penerimaans.id_penerimaan',
    //         //     'riwayat_penerimaans.nama_pengguna as nama_pengguna_penerimaan ',
    //         //     'riwayat_penerimaans.created_at as dateTimePenerimaan',

    //         //     'riwayat_penolakans.id_penolakan',
    //         //     'riwayat_penolakans.nama_pengguna as nama_pengguna_penolakan ',
    //         //     'riwayat_penolakans.created_at as dateTimePenolakan',

    //         //     'riwayat_teruskans.id_teruskan',
    //         //     'riwayat_teruskans.nama_pengirim as nama_pengirim_teruskan ',
    //         //     'riwayat_teruskans.nama_tujuan as nama_tujuan_teruskan ',
    //         //     'riwayat_teruskans.created_at as dateTimeTeruskan',
    //         // )
    //         //     ->leftJoin('riwayat_penerimaans', 'tugas.id_tugas', '=', 'riwayat_penerimaans.id_tugas')
    //         //     ->leftJoin('riwayat_penolakans', 'tugas.id_tugas', '=', 'riwayat_penolakans.id_tugas')
    //         //     ->leftJoin('riwayat_teruskans', 'tugas.id_tugas', '=', 'riwayat_teruskans.id_tugas')
    //         //     ->leftJoin('perkembangans', 'tugas.id_tugas', '=', 'perkembangans.id_tugas')
    //         //     ->orderBy('dateTimePenerimaan', 'desc')
    //         //     ->orderBy('dateTimePenolakan', 'desc')
    //         //     ->orderBy('dateTimeTeruskan', 'desc')
    //         //     ->orderBy('dateTimePerkembangan', 'desc')
    //         //     ->get();

    //         //     dd($tugas);

    //         // tabel teruskan
    //         // nama, created_at, nama_tujuan

    //         // $idTugas = 'c66a334a-6bf7-47bb-a975-797bf41d6026'; // Ganti dengan id_tugas yang diinginkan

    //         // $riwayatGabungan = Tugas::find($idTugas)
    //         //     ->riwayatPenerimaan()
    //         //     ->select('id_tugas', 'created_at')
    //         //     ->union(Tugas::find($idTugas)->riwayatPenolakan()->select('id_tugas', 'created_at'))
    //         //     ->union(Tugas::find($idTugas)->riwayatTeruskan()->select('id_tugas', 'created_at'))
    //         //     ->union(Tugas::find($idTugas)->perkembangan()->select('id_tugas', 'created_at'))
    //         //     ->orderBy('created_at', 'desc')
    //         //     ->get();

    //         //     dd($riwayatGabungan);

    //         $user_id = Auth::user()->id;
    //         $semuaTugas = Tugas::where('user_id', $user_id)
    //             ->orderBy('created_at', 'desc')
    //             ->paginate(15);
    //         $jumlahTugas = Tugas::where('user_id', $user_id)->get();
    //         $jumlahTugas = count($jumlahTugas);

    //         $semuaTugasTeruskan = Tugas::select(
    //             'riwayat_teruskans.created_at as created_at_teruskan',
    //             'tugas.id_tugas',
    //             'tugas.perihal',
    //             'tugas.tujuan',
    //             'tugas.user_id',
    //             'tugas.ket_tujuan',
    //             'riwayat_teruskans.nama_pengirim',
    //             'riwayat_teruskans.nama_tujuan',
    //             'riwayat_teruskans.ket_tujuan as ket_tujuan_teruskan',
    //         )
    //             ->join('riwayat_teruskans', 'tugas.id_tugas', '=', 'riwayat_teruskans.id_tugas')
    //             ->distinct('tugas.id_tugas')
    //             ->paginate(15);

    //         $jumlahTugasTeruskan = Tugas::select(
    //             'riwayat_teruskans.created_at as created_at_teruskan',
    //             'tugas.perihal',
    //             'tugas.tujuan',
    //             'tugas.user_id',
    //             'tugas.ket_tujuan',
    //             'riwayat_teruskans.nama_pengirim',
    //             'riwayat_teruskans.nama_tujuan',
    //             'riwayat_teruskans.ket_tujuan as ket_tujuan_teruskan',
    //         )
    //             ->join('riwayat_teruskans', 'tugas.id_tugas', '=', 'riwayat_teruskans.id_tugas')
    //             ->distinct('tugas.id_tugas')
    //             ->get();

    //         $jumlahTugasTeruskan = count($jumlahTugasTeruskan);
    //     }

    //     //Ambil jumlah tugas masuk
    //     $nama_pengguna = Auth::user()->nama_pengguna;
    //     $jumlahTugasMasuk = Tugas::where('tujuan', $nama_pengguna)
    //         ->where('ket_tujuan', 'menunggu_konfirmasi')
    //         ->where('role_tujuan', $role)
    //         ->get();
    //     $jumlahTugasMasuk = count($jumlahTugasMasuk);

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

    //     foreach ($semuaTugasTeruskan as $tugasTeruskan) {
    //         // Ubah $created_at menjadi objek Carbon
    //         $createdAt = Carbon::parse($tugasTeruskan->created_at_teruskan);

    //         // Formatkan tanggal sesuai dengan format yang diinginkan
    //         $tugasTeruskan->formattedDate = $createdAt->format('d M Y, g:i a');
    //     }

    //     foreach ($semuaTugasTeruskan as $tugasTeruskan) {
    //         // Ubah $created_at menjadi objek Carbon
    //         $tugasTeruskan->id_tugas = $tugasTeruskan->id_tugas;
    //         // dd($tugasTeruskan->id_tugas);
    //     }

    //     return view('s/delegasi-tugas', compact('semuaTugas', 'jumlahTugas', 'jumlahTugasMasuk', 'semuaTugasTeruskan', 'jumlahTugasTeruskan', 'nama_pengguna', 'role', 'title', 'alasan_penolakan'));
    //     // return view('s/delegasi-tugas', compact('semuaTugas', 'jumlahTugas', 'jumlahTugasMasuk', 'nama_pengguna', 'role', 'title', 'alasan_penolakan'));

    // }

    // method coba index with fitur search
    public function index(Request $request)
    {
        $user_id = Auth::user()->id;
        $title = 'Delegasi Tugas';
        $nama_pengguna = Auth::user()->nama_pengguna;
        // $role = Auth::user()->roles[0]->name;
        $role = $request->session()->get('role');

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
            $user_id = Auth::user()->id;
            $semuaTugas = Tugas::where('user_id', $user_id)
                ->orderBy('updated_at', 'desc')
                ->paginate(15);
            $jumlahTugas = Tugas::where('user_id', $user_id)->get();
            $jumlahTugas = count($jumlahTugas);
        }

        if ($request->has('searchTeruskan')) {
            // $semuaTugasTeruskan = Tugas::select(
            //     'riwayat_teruskans.updated_at as updated_at_teruskan',
            //     'tugas.id_tugas',
            //     'tugas.perihal as tugas_perihal',
            //     'tugas.tujuan as tugas_tujuan',
            //     'tugas.user_id',
            //     'tugas.ket_tujuan',
            //     'riwayat_teruskans.nama_pengirim',
            //     'riwayat_teruskans.nama_tujuan',
            //     'riwayat_teruskans.ket_tujuan as ket_tujuan_teruskan',
            // )
            //     ->join('riwayat_teruskans', 'tugas.id_tugas', '=', 'riwayat_teruskans.id_tugas')
            //     ->where('tugas.perihal', 'like', '%' . $request->searchTeruskan . '%')
            //     ->where('tugas.tujuan', 'like', '%' . $request->searchTeruskan . '%')
            //     ->paginate(1);

            // $semuaTugasTeruskan = Tugas::select(
            //     'riwayat_teruskans.updated_at as updated_at_teruskan',
            //     // 'tugas.id_tugas',
            //     'tugas.perihal',
            //     'tugas.tujuan',
            //     // 'tugas.user_id',
            //     // 'tugas.ket_tujuan',
            //     'riwayat_teruskans.nama_pengirim as nama_pengirim_teruskan',
            //     'riwayat_teruskans.nama_tujuan as nama_tujuan_teruskan',
            //     'riwayat_teruskans.ket_tujuan as ket_tujuan_teruskan',
            // )
            //     ->join('riwayat_teruskans', 'tugas.id_tugas', '=', 'riwayat_teruskans.id_tugas')
            //     ->where('tugas.perihal', 'like', '%' . $request->searchTeruskan . '%')
            //     ->where('tugas.tujuan', 'like', '%' . $request->searchTeruskan . '%')
            //     ->paginate(1);

            $semuaTugasTeruskan = Tugas::select(
                'riwayat_teruskans.updated_at as updated_at_teruskan',
                'tugas.id_tugas',
                'tugas.perihal',
                'tugas.tujuan',
                // 'tugas.user_id',
                // 'tugas.ket_tujuan',
                'riwayat_teruskans.nama_pengirim as nama_pengirim_teruskan',
                'riwayat_teruskans.nama_tujuan as nama_tujuan_teruskan',
                'riwayat_teruskans.ket_tujuan as ket_tujuan_teruskan',
            )
                ->join('riwayat_teruskans', 'tugas.id_tugas', '=', 'riwayat_teruskans.id_tugas')
                ->where('riwayat_teruskans.role_pengirim', $role)
                ->where('tugas.perihal', 'like', '%' . $request->searchTeruskan . '%')
                ->orwhere('riwayat_teruskans.nama_tujuan', 'like', '%' . $request->searchTeruskan . '%')
                // ->where('tugas.role_tujuan', $role)
                ->orderBy('riwayat_teruskans.updated_at', 'desc') // Mengurutkan berdasarkan waktu pembuatan terbaru (descending order)
                ->paginate(15);

            $jumlahTugasTeruskan = Tugas::select(
                'riwayat_teruskans.updated_at as updated_at_teruskan',
                'tugas.id_tugas',
                'tugas.perihal',
                'tugas.tujuan',
                // 'tugas.user_id',
                // 'tugas.ket_tujuan',
                'riwayat_teruskans.nama_pengirim as nama_pengirim_teruskan',
                'riwayat_teruskans.nama_tujuan as nama_tujuan_teruskan',
                'riwayat_teruskans.ket_tujuan as ket_tujuan_teruskan',
            )
                ->join('riwayat_teruskans', 'tugas.id_tugas', '=', 'riwayat_teruskans.id_tugas')
                ->where('riwayat_teruskans.role_pengirim', $role)
                ->where('tugas.perihal', 'like', '%' . $request->searchTeruskan . '%')
                ->orwhere('riwayat_teruskans.nama_tujuan', 'like', '%' . $request->searchTeruskan . '%')
                ->paginate(15);

            $jumlahTugasTeruskan = count($jumlahTugasTeruskan);
        } else {
            // $semuaTugasTeruskan = Tugas::select(
            //     'riwayat_teruskans.updated_at as updated_at_teruskan',
            //     'tugas.id_tugas',
            //     'tugas.perihal',
            //     'tugas.tujuan',
            //     'tugas.user_id',
            //     'tugas.ket_tujuan',
            //     'riwayat_teruskans.nama_pengirim',
            //     'riwayat_teruskans.nama_tujuan',
            //     'riwayat_teruskans.ket_tujuan as ket_tujuan_teruskan',
            // )
            //     ->join('riwayat_teruskans', 'tugas.id_tugas', '=', 'riwayat_teruskans.id_tugas')
            //     // ->distinct('tugas.id_tugas')
            //     ->paginate(15);

            $semuaTugasTeruskan = Tugas::select(
                'riwayat_teruskans.updated_at as updated_at_teruskan',
                'tugas.id_tugas',
                'tugas.perihal',
                'tugas.tujuan',
                // 'tugas.user_id',
                // 'tugas.ket_tujuan',
                'riwayat_teruskans.nama_pengirim as nama_pengirim_teruskan',
                'riwayat_teruskans.nama_tujuan as nama_tujuan_teruskan',
                'riwayat_teruskans.ket_tujuan as ket_tujuan_teruskan',
            )
                ->join('riwayat_teruskans', 'tugas.id_tugas', '=', 'riwayat_teruskans.id_tugas')
                // ->where('tugas.perihal', 'like', '%' . $request->searchTeruskan . '%')
                // ->where('riwayat_teruskans.nama_tujuan', 'like', '%' . $request->searchTeruskan . '%')
                // ->where('tugas.role_tujuan', $role)
                ->where('riwayat_teruskans.role_pengirim', $role)
                ->orderBy('riwayat_teruskans.updated_at', 'desc') // Mengurutkan berdasarkan waktu pembuatan terbaru (descending order)
                ->paginate(15);

            $jumlahTugasTeruskan = Tugas::select(
                'riwayat_teruskans.updated_at as updated_at_teruskan',
                'tugas.perihal',
                'tugas.tujuan',
                'tugas.user_id',
                'tugas.ket_tujuan',
                'riwayat_teruskans.nama_pengirim',
                'riwayat_teruskans.nama_tujuan',
                'riwayat_teruskans.ket_tujuan as ket_tujuan_teruskan',
            )
                ->join('riwayat_teruskans', 'tugas.id_tugas', '=', 'riwayat_teruskans.id_tugas')
                // ->distinct('tugas.id_tugas')
                ->where('riwayat_teruskans.role_pengirim', $role)
                ->get();

            $jumlahTugasTeruskan = count($jumlahTugasTeruskan);
        }

        //Ambil jumlah tugas masuk
        $nama_pengguna = Auth::user()->nama_pengguna;
        $jumlahTugasMasuk = Tugas::where('tujuan', $nama_pengguna)
            ->where('ket_tujuan', 'menunggu_konfirmasi')
            ->where('role_tujuan', $role)
            ->get();
        $jumlahTugasMasuk = count($jumlahTugasMasuk);

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

        foreach ($semuaTugasTeruskan as $tugasTeruskan) {
            // Ubah $updated_at menjadi objek Carbon
            $createdAt = Carbon::parse($tugasTeruskan->updated_at_teruskan);

            // Formatkan tanggal sesuai dengan format yang diinginkan
            $tugasTeruskan->formattedDate = $createdAt->format('d M Y, g:i a');
        }

        foreach ($semuaTugasTeruskan as $tugasTeruskan) {
            // Ubah $updated_at menjadi objek Carbon
            $tugasTeruskan->id_tugas = $tugasTeruskan->id_tugas;
            // dd($tugasTeruskan->id_tugas);
        }

        return view('s/delegasi-tugas', compact('semuaTugas', 'jumlahTugas', 'jumlahTugasMasuk', 'semuaTugasTeruskan', 'jumlahTugasTeruskan', 'nama_pengguna', 'role', 'title', 'alasan_penolakan'));
        // return view('s/delegasi-tugas', compact('semuaTugas', 'jumlahTugas', 'jumlahTugasMasuk', 'nama_pengguna', 'role', 'title', 'alasan_penolakan'));

    }

    // method index tanpa fitur search
    // public function index(Request $request)
    // {
    //     $user_id = Auth::user()->id;
    //     $title = 'Delegasi Tugas';
    //     $nama_pengguna = Auth::user()->nama_pengguna;
    //     $role = Auth::user()->roles[0]->name;

    //     $semuaTugas = Tugas::where('user_id', $user_id)
    //         ->orderBy('created_at', 'desc')
    //         ->paginate(15);
    //     $jumlahTugas = Tugas::where('user_id', $user_id)->get();
    //     $jumlahTugas = count($jumlahTugas);

    //     $semuaTugasTeruskan = Tugas::select(
    //         'riwayat_teruskans.created_at as created_at_teruskan',
    //         'tugas.id_tugas',
    //         'tugas.perihal',
    //         'tugas.tujuan',
    //         'tugas.user_id',
    //         'tugas.ket_tujuan',
    //         'riwayat_teruskans.nama_pengirim',
    //         'riwayat_teruskans.nama_tujuan',
    //         'riwayat_teruskans.ket_tujuan as ket_tujuan_teruskan',
    //     )
    //         ->join('riwayat_teruskans', 'tugas.id_tugas', '=', 'riwayat_teruskans.id_tugas')
    //         ->distinct('tugas.id_tugas')
    //         ->paginate(15);

    //     $jumlahTugasTeruskan = Tugas::select(
    //         'riwayat_teruskans.created_at as created_at_teruskan',
    //         'tugas.perihal',
    //         'tugas.tujuan',
    //         'tugas.user_id',
    //         'tugas.ket_tujuan',
    //         'riwayat_teruskans.nama_pengirim',
    //         'riwayat_teruskans.nama_tujuan',
    //         'riwayat_teruskans.ket_tujuan as ket_tujuan_teruskan',
    //     )
    //         ->join('riwayat_teruskans', 'tugas.id_tugas', '=', 'riwayat_teruskans.id_tugas')
    //         ->distinct('tugas.id_tugas')
    //         ->get();

    //     $jumlahTugasTeruskan = count($jumlahTugasTeruskan);

    //     //Ambil jumlah tugas masuk
    //     $nama_pengguna = Auth::user()->nama_pengguna;
    //     $jumlahTugasMasuk = Tugas::where('tujuan', $nama_pengguna)
    //         ->where('ket_tujuan', 'menunggu_konfirmasi')
    //         ->where('role_tujuan', $role)
    //         ->get();
    //     $jumlahTugasMasuk = count($jumlahTugasMasuk);

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

    //     foreach ($semuaTugasTeruskan as $tugasTeruskan) {
    //         // Ubah $created_at menjadi objek Carbon
    //         $createdAt = Carbon::parse($tugasTeruskan->created_at_teruskan);

    //         // Formatkan tanggal sesuai dengan format yang diinginkan
    //         $tugasTeruskan->formattedDate = $createdAt->format('d M Y, g:i a');
    //     }


    //     return view('s/delegasi-tugas', compact('semuaTugas', 'jumlahTugas', 'jumlahTugasMasuk', 'semuaTugasTeruskan', 'jumlahTugasTeruskan', 'nama_pengguna', 'role', 'title', 'alasan_penolakan'));
    // }

    // public function index(Request $request)
    // {
    //     if ($request->has('search')) {
    //         $user_id = Auth::user()->id;

    //         // cari tugas berdasarkan keterangan
    //         $semuaTugas = Tugas::where('perihal', 'like', '%' . $request->search . '%')
    //             ->where('user_id', $user_id)
    //             ->paginate(15);

    //         if (is_null($semuaTugas)) {
    //             $name = User::where('');

    //             $idUser = User::where('nama_pengguna', 'like', '%' . $request->search . '%')
    //                 ->get('user_id');

    //             $semuaTugas = Tugas::where('user_id', $idUser)
    //                 ->where('user_id', $user_id)
    //                 ->paginate(15);

    //             $jumlahTugas = Tugas::where('user_id', $idUser)
    //                 ->where('user_id', $user_id)
    //                 ->get();

    //             $jumlahTugas = count($jumlahTugas);
    //         }

    //         $jumlahTugas = Tugas::where('perihal', 'like', '%' . $request->search . '%')
    //             ->where('user_id', $user_id)
    //             ->get();

    //         $jumlahTugas = count($jumlahTugas);
    //     } else {
    //         $user_id = Auth::user()->id;
    //         $semuaTugas = Tugas::where('user_id', $user_id)->paginate(15);
    //         $jumlahTugas = Tugas::where('user_id', $user_id)->get();
    //         $jumlahTugas = count($jumlahTugas);
    //     }

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

    //     $title = 'Delegasi Tugas';
    //     $nama_pengguna = Auth::user()->nama_pengguna;
    //     $role = Auth::user()->roles[0]->name;

    //     return view('s/delegasi-tugas', compact('semuaTugas', 'jumlahTugas', 'nama_pengguna', 'role', 'title', 'alasan_penolakan'));
    // }

    public function create(Request $request)
    {
        $title = 'Tambah Delegasi Tugas';
        $nama_pengguna = Auth::user()->nama_pengguna;
        // $role = Auth::user()->roles[0]->name;
        $role = $request->session()->get('role');

        //Ambil jumlah tugas masuk
        $jumlahTugasMasuk = Tugas::where('tujuan', $nama_pengguna)
            ->where('ket_tujuan', 'menunggu_konfirmasi')
            ->where('role_tujuan', $role)
            ->get();
        $jumlahTugasMasuk = count($jumlahTugasMasuk);

        return view('s/tambah-delegasi-tugas', compact('title', 'nama_pengguna', 'role', 'jumlahTugasMasuk'));

        // return view('s/tambah-delegasi-tugas', [
        //     'title' => 'Tambah Delegasi Tugas',
        //     'nama_pengguna' => Auth::user()->nama_pengguna,
        //     'role' => Auth::user()->roles[0]->name
        // ]);
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

    // //method yang digunakan untuk passing data
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
    //         'tujuan.required' => 'Tujuan harus diisi.',
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

    //     if (isset($request->lampiran)) {
    //         $lampiran = $request->file('lampiran');
    //         $name = 'PSTI_' . $userIdnew . '_' . date('Ymdhis') . '.' . $request->file('lampiran')->getClientOriginalExtension();
    //         $lampiran->move('lampiran/', $name);
    //         $validateData['lampiran'] = $name;
    //     }

    //     $validateData['id_tugas'] = $uuid;
    //     $validateData['user_id'] = $userIdnew;
    //     $validateData['tenggat_waktu_tanggal'] = $selectedTime;
    //     $validateData['ket_tujuan'] = $ket_tujuan;

    //     Tugas::create($validateData);

    //     return redirect('s/delegasi-tugas')->with('success', 'Tugas berhasil didelegasikan');
    // }

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
            'lampiran' => 'nullable|mimes:docx,pdf,rar,zip,png,jpg,jpeg',
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

        return redirect('s/delegasi-tugas')->with('success', 'Tugas berhasil didelegasikan');
    }

    // Method to show the edit form
    public function edit(Request $request, $id_tugas)
    {
        $tugas = Tugas::findOrFail($id_tugas);
        $tujuan = $tugas->tujuan;

        $perihal = $tugas->perihal;
        $perihal = str_replace("\r\n", " ", $perihal);

        $title = 'Edit Delegasi Tugas';
        $nama_pengguna = Auth::user()->nama_pengguna;
        // $role = Auth::user()->roles[0]->name;
        $role = $request->session()->get('role');

        //Ambil jumlah tugas masuk
        $jumlahTugasMasuk = Tugas::where('tujuan', $nama_pengguna)
            ->where('ket_tujuan', 'menunggu_konfirmasi')
            ->where('role_tujuan', $role)
            ->get();
        $jumlahTugasMasuk = count($jumlahTugasMasuk);

        //penentuan format jam
        $jam = Carbon::parse($tugas->tenggat_waktu_jam); // Buat objek Carbon dari jam
        $jam = $jam->format('H:i'); // Format waktu sesuai dengan format yang diinginkan contoh '23:59'

        //penentuan format tanggal
        $tanggal = Carbon::parse($tugas->tenggat_waktu_tanggal); // Ubah tanggal menjadi objek Carbon
        $tanggalFormatted = $tanggal->format('m/d/Y'); // Format tanggal menjadi "07/19/2023"

        return view('s/edit-delegasi-tugas', compact('jumlahTugasMasuk', 'tugas', 'title', 'nama_pengguna', 'role', 'jam', 'tanggalFormatted', 'perihal', 'tujuan'));
    }

    // Method to handle the form submission and update the task
    public function update(Request $request, $id_tugas)
    {
        // Mendapatkan ID pengguna dari sesi
        $userIdnew = $request->session()->get('user_id');

        // Inisialisasi nilai default keterangan tujuan
        $ket_tujuan = 'menunggu_konfirmasi';

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

        return redirect()->route('s.edit', $tugas->id_tugas)->with('success', 'Tugas berhasil diperbarui!');
    }

    public function editTeruskan(Request $request, $id_tugas)
    {
        $tugas = Tugas::findOrFail($id_tugas);
        $tujuan = $tugas->tujuan;

        $perihal = $tugas->perihal;
        $perihal = str_replace("\r\n", " ", $perihal);

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

        //penentuan format jam
        $jam = Carbon::parse($tugas->tenggat_waktu_jam); // Buat objek Carbon dari jam
        $jam = $jam->format('H:i'); // Format waktu sesuai dengan format yang diinginkan contoh '23:59'

        //penentuan format tanggal
        $tanggal = Carbon::parse($tugas->tenggat_waktu_tanggal); // Ubah tanggal menjadi objek Carbon
        $tanggalFormatted = $tanggal->format('m/d/Y'); // Format tanggal menjadi "07/19/2023"

        return view('s/edit-delegasi-tugas-teruskan', compact('jumlahTugasMasuk', 'tugas', 'title', 'nama_pengguna', 'role', 'jam', 'tanggalFormatted', 'perihal', 'tujuan'));
    }

    // Update tugas teruskan final
    public function updateTeruskan($id_perkembangan)
    {
        $perkembangan = Perkembangan::find($id_perkembangan);
        if ($perkembangan) {
            Perkembangan::where('id_perkembangan', $id_perkembangan)->update(['keterangan' => 'completed']);
        }

        return redirect()->back()->with('success', 'Status task berhasil diperbarui.');
    }


    // public function updateTeruskan(Request $request, $id_tugas)
    // {
    //     // Mendapatkan ID pengguna dari sesi
    //     $userIdnew = $request->session()->get('user_id');

    //     // Inisialisasi nilai default keterangan tujuan
    //     $ket_tujuan = 'menunggu_konfirmasi';

    //     $validator = Validator::make($request->all(), [
    //         'tujuan' => 'required',
    //         'role_tujuan' => 'required',
    //     ]);

    //     // Cek apakah validasi berhasil
    //     if ($validator->fails()) {
    //         // Jika validasi gagal, kembalikan ke halaman sebelumnya dengan pesan error
    //         return redirect()->back()->withErrors($validator)->withInput();
    //     }

    //     $tugas = Tugas::findOrFail($id_tugas);

    //     // Update the task fields with the submitted data
    //     $tugas->update([
    //         'tujuan' => $request->tujuan,
    //         'role_tujuan' => $request->role_tujuan,
    //         'ket_tujuan' => $ket_tujuan,
    //     ]);

    //     RiwayatTeruskan::where('id_tugas', $id_tugas)->update([
    //         'nama_tujuan' => $request->tujuan,
    //         'role_tujuan' => $request->role_tujuan,
    //         'ket_tujuan' => $ket_tujuan,
    //     ]);

    //     // $riwayatteruskan = new RiwayatTeruskan([
    //     //     'id_tugas' => $tugas->id_tugas,
    //     //     'nama_tujuan' => $request->tujuan,
    //     //     'role_tujuan' => $request->role_tujuan,
    //     //     'id_teruskan' => $uuid,
    //     //     'nama_pengirim' => $nama_pengirim,
    //     //     'role_pengirim' => $role,
    //     //     'ket_tujuan' => $ket_tujuan,
    //     // ]);
    //     // $riwayatteruskan->save();

    //     return redirect()->route('s.editTeruskan', $tugas->id_tugas)->with('success', 'Tugas berhasil diperbarui!');
    // }

    // Method tugasMasuk with fitur search
    public function tugasMasuk(Request $request)
    {
        $title = 'Tugas Masuk';
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

        return view('s/tugas-masuk', compact('semuaTugas', 'jumlahTugas', 'jumlahTugasMasuk', 'nama_pengguna', 'role', 'title', 'nama_pengirim'));
    }

    // method tugas masuk without fitur search
    // public function tugasMasuk()
    // {
    //     $title = 'Delegasi Tugas';
    //     $nama_pengguna = Auth::user()->nama_pengguna;
    //     $role = Auth::user()->roles[0]->name;

    //     $nama_pengguna = Auth::user()->nama_pengguna;
    //     $semuaTugas = Tugas::where('tujuan', $nama_pengguna)
    //         ->where('ket_tujuan', 'menunggu_konfirmasi')
    //         ->where('role_tujuan', $role)
    //         ->orderBy('updated_at', 'desc') // Mengurutkan berdasarkan waktu pembuatan terbaru (descending order)
    //         ->paginate(15);
    //     $jumlahTugas = Tugas::where('tujuan', $nama_pengguna)
    //         ->where('ket_tujuan', 'menunggu_konfirmasi')
    //         ->where('role_tujuan', $role)
    //         ->get();
    //     $jumlahTugas = count($jumlahTugas);

    //     foreach ($semuaTugas as $tugas) {
    //         // Ubah $created_at menjadi objek Carbon
    //         $createdAt = Carbon::parse($tugas->created_at);

    //         // Formatkan tanggal sesuai dengan format yang diinginkan
    //         $tugas->formattedDate = $createdAt->format('d M Y, g:i a');
    //     }

    //     // $nama_pengirim = ''; //inisialisai nilai default nama pengirim

    //     // foreach ($semuaTugas as $tugas) {
    //     //     // Mengakses properti user_id dari model Tugas
    //     //     $nama_pengirim = $tugas->nama_pengirim;
    //     //     // $user_id = $tugas->user_id;
    //     //     // $nama_pengirim = User::where('id', $user_id)
    //     //     //     ->get('nama_pengguna');

    //     //     // $data = json_decode($nama_pengirim, true); // Mengambil data dari JSON karena query diatas menghasilkan data dalam format JSON
    //     //     // $nama_pengirim = $data[0]['nama_pengguna'];
    //     // }


    //     return view('s/tugas-masuk', compact('semuaTugas', 'jumlahTugas', 'nama_pengguna', 'role', 'title'));
    // }

    // public function tugasMasuk(Request $request)
    // {
    //     if ($request->has('search')) {
    //         $nama_pengguna = Auth::user()->nama_pengguna;

    //         // Cek apakah input pencarian (searchName) telah diberikan
    //         if ($request->has('searchName')) {
    //             $searchName = $request->input('searchName');
    //         } else {
    //             // Jika input pencarian (searchName) belum diberikan, atur nilai $searchName menjadi null atau sesuai kebutuhan
    //             $searchName = null;
    //         }

    //         // Cek apakah input pencarian (searchPerihal) telah diberikan
    //         if ($request->has('searchPerihal')) {
    //             $searchPerihal = $request->input('searchPerihal');
    //         } else {
    //             // Jika input pencarian (searchPerihal) belum diberikan, atur nilai $searchPerihal menjadi null atau sesuai kebutuhan
    //             $searchPerihal = null;
    //         }

    //         // Lakukan query pencarian berdasarkan kriteria tertentu menggunakan metode paginate()
    //         $semuaTugas = Tugas::where(function ($query) use ($searchName, $searchPerihal, $nama_pengguna) {
    //             if ($searchName) {
    //                 $query->where('nama', 'like', '%' . $searchName . '%');
    //             }
    //             if ($searchPerihal) {
    //                 $query->where('perihal', 'like', '%' . $searchPerihal . '%');
    //             }
    //             $query->where('tujuan', $nama_pengguna)
    //                 ->where('ket_tujuan', 'menunggu_konfirmasi');
    //         })->paginate(15);

    //         $jumlahTugas = $semuaTugas->total();
    //     } else {
    //         $nama_pengguna = Auth::user()->nama_pengguna;
    //         $semuaTugas = Tugas::where('tujuan', $nama_pengguna)
    //             ->where('ket_tujuan', 'menunggu_konfirmasi')
    //             ->paginate(15);

    //         // dd($semuaTugas);

    //         $jumlahTugas = Tugas::where('tujuan', $nama_pengguna)
    //             ->where('ket_tujuan', 'menunggu_konfirmasi')
    //             ->get();

    //         $jumlahTugas = count($jumlahTugas);
    //     }

    //     foreach ($semuaTugas as $tugas) {
    //         // Ubah $created_at menjadi objek Carbon
    //         $createdAt = Carbon::parse($tugas->created_at);

    //         // Formatkan tanggal sesuai dengan format yang diinginkan
    //         $tugas->formattedDate = $createdAt->format('d M Y, g:i a');
    //     }

    //     $nama_pengirim = ''; //inisialisai nilai default nama pengirim

    //     foreach ($semuaTugas as $tugas) {
    //         // Mengakses properti user_id dari model Tugas
    //         $user_id = $tugas->user_id;
    //         $nama_pengirim = User::where('id', $user_id)
    //             ->get('nama_pengguna');

    //         $data = json_decode($nama_pengirim, true); // Mengambil data dari JSON karena query diatas menghasilkan data dalam format JSON
    //         $nama_pengirim = $data[0]['nama_pengguna'];
    //     }

    //     $title = 'Delegasi Tugas';
    //     $nama_pengguna = Auth::user()->nama_pengguna;
    //     $role = Auth::user()->roles[0]->name;

    //     return view('s/tugas-masuk', compact('semuaTugas', 'jumlahTugas', 'nama_pengguna', 'role', 'title', 'nama_pengirim'));
    // }

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


        //mengambil nama pengirim dari suatu tugas
        // $user_id = $tugas->user_id;
        // $nama_pengirim = User::where('id', $user_id)
        //     ->get('nama_pengguna');
        // $data = json_decode($nama_pengirim, true); // Mengambil data dari JSON karena query diatas menghasilkan data dalam format JSON
        // $nama_pengirim = $data[0]['nama_pengguna'];

        return view('s.show', compact('jumlahTugas', 'tugas', 'title', 'nama_pengguna', 'role', 'nama_hari', 'tanggal', 'jam'));
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

        // Temukan tugas berdasarkan $id_tugas
        // $riwayat_penerimaan = RiwayatPenerimaan::findOrFail($id_tugas);

        // Ubah status tugas menjadi "diterima"
        $tugas->update([
            'ket_tujuan' => 'diterima',
        ]);

        // Ubah keterangan riwayat_penerimaan  "incomplete"
        // $riwayat_penerimaan->update([
        //     'keterangan' => 'incomplete',
        // ]);

        // Simpan riwayat ke dalam tabel RiwayatPenerimaan
        $riwayatPenerimaan = new RiwayatPenerimaan([
            'id_penerimaan' => $uuid,
            'id_tugas' => $tugas->id_tugas,
            'nama_pengguna' => $nama_pengguna,
            'keterangan' => 'incomplete'
        ]);
        $riwayatPenerimaan->save();

        return redirect('s/tugas-masuk')->with('success', 'Tugas diterima!');
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

        // Validasi input alasan penolakan
        // $request->validate([
        //     'alasan_penolakan' => 'required|max:255',
        // ]);

        //coba
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
        // End coba

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
        $nama_pengirim = User::where('id', $userIdnew)
            ->get('nama_pengguna');

        $data = json_decode($nama_pengirim, true); // Mengambil data dari JSON karena query diatas menghasilkan data dalam format JSON
        $nama_pengirim = $data[0]['nama_pengguna'];

        // mengambil role user yang sedang login
        $role = $request->session()->get('role');

        // Buat UUID baru sebagai nilai id_penolakan
        $uuid = Uuid::uuid4()->toString();

        // inisialisasi variabel keterangan tujuan
        $ket_tujuan = 'menunggu_konfirmasi';

        // Validasi input alasan penolakan
        $request->validate([
            'tujuan' => 'required',
            'role_tujuan' => 'required',
        ]);

        // Ambil user_id dari tujuan
        // $nama_tujuan = $request->tujuan;
        // $nama_tujuan = User::where('nama_pengguna', $nama_tujuan)
        //     ->get('nama_pengguna');
        // $data = json_decode($nama_tujuan, true);
        // $nama_tujuan = $data[0]['nama_pengguna'];

        // Temukan tugas berdasarkan $id_tugas
        $tugas = Tugas::findOrFail($id_tugas);

        // Ubah status tugas menjadi "ditolak"
        $tugas->update([
            'ket_tujuan' => 'diteruskan'
            // 'ket_tujuan' => $ket_tujuan,
            // 'tujuan' => $request->tujuan,
            // 'role_tujuan' => $request->role_tujuan
        ]);

        // Simpan alasan penolakan ke dalam tabel RiwayatPenolakan (jika ada)
        $riwayatteruskan = new RiwayatTeruskan([
            'id_tugas' => $tugas->id_tugas,
            'nama_tujuan' => $request->tujuan,
            'role_tujuan' => $request->role_tujuan,
            'id_teruskan' => $uuid,
            'nama_pengirim' => $nama_pengirim,
            'role_pengirim' => $role,
            'ket_tujuan' => $ket_tujuan,
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

    //method tugas masuk with fitur search
    // public function tugas(Request $request)
    // {
    //     if ($request->has('search')) {
    //         $nama_pengguna = Auth::user()->nama_pengguna;

    //         $semuaTugas = Tugas::where(function ($query) use ($request, $nama_pengguna) {
    //             $query->where('perihal', 'like', '%' . $request->search . '%');
    //         })
    //             ->where('tujuan', $nama_pengguna)
    //             ->where('ket_tujuan', 'diterima')
    //             ->orderBy('created_at', 'desc')
    //             ->paginate(15);

    //         $jumlahTugas = Tugas::where(function ($query) use ($request, $nama_pengguna) {
    //             $query->where('perihal', 'like', '%' . $request->search . '%');
    //         })
    //             ->where('tujuan', $nama_pengguna)
    //             ->where('ket_tujuan', 'diterima')
    //             ->get();

    //         $jumlahTugas = count($jumlahTugas);
    //     } else {
    //         $nama_pengguna = Auth::user()->nama_pengguna;
    //         $semuaTugas = Tugas::where('tujuan', $nama_pengguna)
    //             ->where('ket_tujuan', 'diterima')
    //             ->orderBy('created_at', 'desc')
    //             ->paginate(15);
    //         $jumlahTugas = Tugas::where('tujuan', $nama_pengguna)
    //             ->where('ket_tujuan', 'diterima')
    //             ->get();
    //         $jumlahTugas = count($jumlahTugas);
    //     }

    //     foreach ($semuaTugas as $tugas) {
    //         //penentuan nama hari
    //         $nama_hari = Carbon::parse($tugas->tenggat_waktu_tanggal); // Buat objek Carbon dari tanggal
    //         $nama_hari->locale('id'); // Set bahasa pada objek Carbon (Indonesia)
    //         $tugas->nama_hari = $nama_hari->isoFormat('dddd'); // Dapatkan nama hari dalam bahasa Indonesia

    //         //penentuan format tanggal
    //         $tanggal = Carbon::parse($tugas->tenggat_waktu_tanggal); // Buat objek Carbon dari tanggal
    //         $tugas->tanggal = $tanggal->format('j F Y'); // Format tanggal sesuai dengan format yang diinginkan contoh '8 Maret 2023'

    //         //penentuan format jam
    //         $jam = Carbon::parse($tugas->tenggat_waktu_jam); // Buat objek Carbon dari jam
    //         $tugas->jam = $jam->format('H:i'); // Format waktu sesuai dengan format yang diinginkan contoh '23:59'
    //     }

    //     // $nama_pengirim = ''; //inisialisai nilai default nama pengirim

    //     // foreach ($semuaTugas as $tugas) {
    //     //     // Mengakses properti user_id dari model Tugas
    //     //     $user_id = $tugas->user_id;
    //     //     $nama_pengirim = User::where('id', $user_id)
    //     //         ->get('nama_pengguna');

    //     //     $data = json_decode($nama_pengirim, true); // Mengambil data dari JSON karena query diatas menghasilkan data dalam format JSON
    //     //     $nama_pengirim = $data[0]['nama_pengguna'];
    //     // }

    //     $title = 'Delegasi Tugas';
    //     $nama_pengguna = Auth::user()->nama_pengguna;
    //     $role = Auth::user()->roles[0]->name;

    //     //Ambil jumlah tugas masuk
    //     $jumlahTugasMasuk = Tugas::where('tujuan', $nama_pengguna)
    //         ->where('ket_tujuan', 'menunggu_konfirmasi')
    //         ->get();
    //     $jumlahTugasMasuk = count($jumlahTugasMasuk);

    //     return view('s/tugas', compact('semuaTugas', 'jumlahTugas', 'jumlahTugasMasuk', 'nama_pengguna', 'role', 'title'));
    // }

    // method tugas with fitur search
    public function tugas(Request $request)
    {
        $title = 'Tugas';
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

        // $nama_pengirim = ''; //inisialisai nilai default nama pengirim

        // foreach ($semuaTugas as $tugas) {
        //     // Mengakses properti user_id dari model Tugas
        //     $user_id = $tugas->user_id;
        //     $nama_pengirim = User::where('id', $user_id)
        //         ->get('nama_pengguna');

        //     $data = json_decode($nama_pengirim, true); // Mengambil data dari JSON karena query diatas menghasilkan data dalam format JSON
        //     $nama_pengirim = $data[0]['nama_pengguna'];
        // }



        return view('s/tugas', compact('semuaTugas', 'jumlahTugas', 'jumlahTugasMasuk', 'nama_pengguna', 'role', 'title'));
    }

    // method tugas without fitur search
    // public function tugas(Request $request)
    // {
    //     $title = 'Delegasi Tugas';
    //     $nama_pengguna = Auth::user()->nama_pengguna;
    //     $role = Auth::user()->roles[0]->name;

    //     // ambil jumlah tugas masuk
    //     $jumlahTugasMasuk = Tugas::where('tujuan', $nama_pengguna)
    //         ->where('ket_tujuan', 'menunggu_konfirmasi')
    //         ->where('role_tujuan', $role)
    //         ->get();
    //     $jumlahTugasMasuk = count($jumlahTugasMasuk);

    //     // ambil semua tugas
    //     $semuaTugas = Tugas::where('tujuan', $nama_pengguna)
    //         ->where('ket_tujuan', 'diterima')
    //         ->where('role_tujuan', $role)
    //         ->orderBy('updated_at', 'desc')
    //         ->paginate(15);
    //     $jumlahTugas = Tugas::where('tujuan', $nama_pengguna)
    //         ->where('ket_tujuan', 'diterima')
    //         ->where('role_tujuan', $role)
    //         ->get();
    //     $jumlahTugas = count($jumlahTugas);

    //     foreach ($semuaTugas as $tugas) {
    //         //penentuan nama hari
    //         $nama_hari = Carbon::parse($tugas->tenggat_waktu_tanggal); // Buat objek Carbon dari tanggal
    //         $nama_hari->locale('id'); // Set bahasa pada objek Carbon (Indonesia)
    //         $tugas->nama_hari = $nama_hari->isoFormat('dddd'); // Dapatkan nama hari dalam bahasa Indonesia

    //         //penentuan format tanggal
    //         $tanggal = Carbon::parse($tugas->tenggat_waktu_tanggal); // Buat objek Carbon dari tanggal
    //         $tugas->tanggal = $tanggal->format('j F Y'); // Format tanggal sesuai dengan format yang diinginkan contoh '8 Maret 2023'

    //         //penentuan format jam
    //         $jam = Carbon::parse($tugas->tenggat_waktu_jam); // Buat objek Carbon dari jam
    //         $tugas->jam = $jam->format('H:i'); // Format waktu sesuai dengan format yang diinginkan contoh '23:59'
    //     }

    //     return view('s/tugas', compact('semuaTugas', 'jumlahTugas', 'jumlahTugasMasuk', 'nama_pengguna', 'role', 'title'));
    // }

    // Method to show the edit form
    public function updatePerkembangan(Request $request, $id_tugas)
    {
        $perkembangans = Perkembangan::where('id_tugas', $id_tugas)
        ->orderBy('updated_at', 'desc')
        ->paginate();

        // $perkembangan = Perkembangan::where('id_tugas', $id_tugas)->first();
        // dd($perkembangan);

        $semuaTask = Perkembangan::orderBy('created_at', 'desc')->get();

        $tugas = Tugas::findOrFail($id_tugas); // Temukan tugas berdasarkan $id_tugas

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

        return view('s/update-perkembangan-tugas', compact('tugas', 'perkembangans', 'semuaTask', 'jumlahTugasMasuk', 'id_tugas', 'title', 'nama_pengguna', 'role'));
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
        // dd($keterangan);
        // $keterangan = 'incomplete'; // Inisialisasi nilai default keterangan tujuan
        $pihak_terlibat = null;

        // Buat UUID baru sebagai nilai id_tugas
        $uuid = Uuid::uuid4()->toString();

        $messages = [
            'todo_list.unique:perkembangans' => 'Task harus bersifat unik.',
        ];

        $validator = Validator::make($request->all(), [
            'todo_list' => 'required|unique:perkembangans',
            // 'todo_list' => 'required',
        ]);

        // Cek apakah validasi berhasil
        if ($validator->fails()) {
            // // Jika validasi gagal, kembalikan ke halaman sebelumnya dengan pesan error
            // return redirect()->back()->withErrors($validator)->withInput();

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

        return redirect()->route('s.updatePerkembangan', $tugas->id_tugas)->with('success', 'New task berhasil ditambahkan.');
        // return view('s.update-perkembangan-tugas')->with('success', 'New task berhasil ditambahkan.');
    }

    // Method to handle the form submission and update the task
    // public function updateTodoList(Request $request, $id_tugas)
    // {
    //     // Mendapatkan ID pengguna dari sesi
    //     $userIdnew = $request->session()->get('user_id');

    //     // Inisialisasi nilai default keterangan tujuan
    //     $ket_tujuan = 'menunggu_konfirmasi';

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

    //     $tugas = Tugas::findOrFail($id_tugas);

    //     //ambil lampiran sebelumnya
    //     $name = $tugas->lampiran;

    //     if (isset($request->lampiran)) {
    //         $lampiran = $request->file('lampiran');
    //         $name = 'PSTI_' . $userIdnew . '_' . date('Ymdhis') . '.' . $request->file('lampiran')->getClientOriginalExtension();
    //         $lampiran->move('lampiran/', $name);
    //         $validateData['lampiran'] = $name;
    //     }

    //     // Simpan data waktu yang dipilih dalam format yang sesuai (misalnya: Y-m-d H:i:s)
    //     $selectedTime = date('Y-m-d H:i:s', strtotime($request->input('tenggat_waktu_tanggal')));

    //     // Update the task fields with the submitted data
    //     $tugas->update([
    //         'tujuan' => $request->tujuan,
    //         'perihal' => $request->perihal,
    //         'tenggat_waktu_jam' => $request->tenggat_waktu_jam,
    //         'tenggat_waktu_tanggal' => $selectedTime,
    //         'url' => $request->url,
    //         'lampiran' => $name,
    //         'ket_tujuan' => $ket_tujuan,
    //     ]);

    //     return redirect()->route('s.edit', $tugas->id_tugas)->with('success', 'Tugas berhasil diperbarui!');
    // }

    // Method Update Status Sebelumnya
    // public function updateStatus(Request $request)
    // {
    //     // $taskIds = $request->input('task');
    //     // $allTaskIds = Perkembangan::pluck('id_perkembangan')->toArray();

    //     // if (is_array($taskIds)) {
    //     //     $completedTaskIds = array_intersect($allTaskIds, $taskIds);
    //     //     $incompletedTaskIds = array_diff($allTaskIds, $completedTaskIds);

    //     //     Perkembangan::where('id_perkembangan', $completedTaskIds)->update(['keterangan' => 'completed']);
    //     //     Perkembangan::where('id_perkembangan', $incompletedTaskIds)->update(['keterangan' => 'incomplete']);
    //     // }

    //     // $id_perkembangan = $request->input('task');
    //     // // dd($id_perkembangan);

    //     $taskTodoList = $request->input('task');
    //     // dd($taskTodoList);

    //     $allTodoList = Perkembangan::pluck('todo_list')->toArray();
    //     // dd($Allid_perkembangan);

    //     if (isset($taskTodoList)) {
    //         $completedTaskIds = array_intersect($allTodoList, $taskTodoList);
    //         // dd($completedTaskIds);

    //         $incompletedTaskIds = array_diff($allTodoList, $completedTaskIds);

    //         Perkembangan::where('todo_list', $completedTaskIds)->update(['keterangan' => 'completed']);
    //         Perkembangan::where('todo_list', $incompletedTaskIds)->update(['keterangan' => 'incomplete']);
    //     } else {
    //         Perkembangan::query()->update(['keterangan' => 'incomplete']);
    //     }

    //     return redirect()->route('s.tugas')->with('success', 'Status task berhasil diperbarui.');
    //     // return redirect()->back()->with('success', 'Status task berhasil diperbarui. Jika tidak ter-reset, coba sekali lagi.');
    // }

    public function perkembanganSelesai($id_perkembangan)
    {
        $perkembangan = Perkembangan::find($id_perkembangan);
        if ($perkembangan) {
            Perkembangan::where('id_perkembangan', $id_perkembangan)->update(['keterangan' => 'completed']);
        }

        return redirect()->back()->with('success', 'Hasil tugas diterima!');
    }

    public function updateStatusPerkembangan($id_perkembangan)
    {
        $perkembangan = Perkembangan::find($id_perkembangan);
        if ($perkembangan) {

            Perkembangan::where('id_perkembangan', $id_perkembangan)->update(['keterangan' => 'menunggu_konfirmasi']);
        }

        return redirect()->back()->with('success', 'Status task berhasil diperbarui.');
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



    //method yang digunakan untuk passing data
    // public function storePerkembanganTugas(Request $request)
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
    //         'url.url' => 'Format URL tidak valid.',
    //         'lampiran.mimes' => 'Format lampiran harus docx, pdf, atau rar.',
    //     ];

    //     $validator = Validator::make($request->all(), [
    //         'id_tugas' => 'required',
    //         'todo_list' => 'required',
    //         'keterangan' => 'nullable|in:menunggu_konfirmasi,diterima,ditolak',
    //         'pihak_terlibat' => 'required',
    //         'url' => 'nullable|url',
    //         'lampiran' => 'nullable|file|mimes:docx,pdf,rar',
    //         'nama_pengguna' => 'required',
    //     ], $messages);

    //     // Cek apakah validasi berhasil
    //     if ($validator->fails()) {
    //         // Jika validasi gagal, kembalikan ke halaman sebelumnya dengan pesan error
    //         return redirect()->back()->withErrors($validator)->withInput();
    //     }

    //     $validateData = $request->all();

    //     if (isset($request->lampiran)) {
    //         $lampiran = $request->file('lampiran');
    //         $name = 'PSTI_' . $userIdnew . '_' . date('Ymdhis') . '.' . $request->file('lampiran')->getClientOriginalExtension();
    //         $lampiran->move('lampiran/', $name);
    //         $validateData['lampiran'] = $name;
    //     }

    //     $validateData['id_tugas'] = $uuid;
    //     $validateData['user_id'] = $userIdnew;
    //     $validateData['tenggat_waktu_tanggal'] = $selectedTime;
    //     $validateData['ket_tujuan'] = $ket_tujuan;

    //     Tugas::create($validateData);

    //     return redirect('s/delegasi-tugas')->with('success', 'Tugas berhasil didelegasikan');
    // }

    //method untuk mengambil data user berdasarkan role yang dipilih pengguna menggunakan JQuery Select2
    public function getTask($id_tugas)
    {
        // $nama_pengguna = Auth::user()->nama_pengguna;
        // $todo_list  = Perkembangan::where('todo_list', 'LIKE', '%' . request('q') . '%')
        //     ->where('nama_pengguna', $nama_pengguna)
        //     ->where('id_tugas', $id_tugas)
        //     ->paginate(5);


        // return response()->json($todo_list);

        // $todo_list  = Perkembangan::join('tugas', 'perkembangans.id_tugas', '=', 'tugas.id_tugas')
        //     ->where('tugas.id_tugas', $id_tugas)
        //     ->get('perkembangans.todo_list');

        // $data = User::whereIn('todo_list', $todo_list)->where('todo_list', 'LIKE', '%' . request('q') . '%')->paginate(10);

        // return response()->json($data);

        $todo_list  = Perkembangan::join('tugas', 'perkembangans.id_tugas', '=', 'tugas.id_tugas')
            // ->join('roles', 'role_users.role_id', '=', 'roles.id')
            ->where('tugas.id_tugas', $id_tugas)
            ->get('perkembangans.todo_list');

        $data = User::whereIn('todo_list', $todo_list)->where('todo_list', 'LIKE', '%' . request('q') . '%')->paginate(10);

        return response()->json($data);

        // $namaPengguna  = User::join('role_users', 'users.id', '=', 'role_users.user_id')
        //     ->join('roles', 'role_users.role_id', '=', 'roles.id')
        //     ->where('roles.name', $role)
        //     ->get('users.nama_pengguna');

        // $data = User::whereIn('nama_pengguna', $namaPengguna)->where('nama_pengguna', 'LIKE', '%' . request('q') . '%')->paginate(10);

        // return response()->json($data);




        // $todo_list  = Perkembangan::join('tugas', 'perkembangans.id_tugas', '=', 'tugas.id_tugas')
        //     ->where('perkembangans.id_tugas', $id_tugas)
        //     ->get('perkembangans.todo_list');

        // $todo_list = Perkembangan::whereIn('todo_list', $todo_list)->where('todo_list', 'LIKE', '%' . request('q') . '%')->paginate(10);

        // return response()->json($todo_list);
    }

    public function getAllUser()
    {
        $data = User::where('nama_pengguna', 'LIKE', '%' . request('q') . '%')->paginate(10);

        return response()->json($data);
    }

    // public function updateLampiranPerkembangan(Request $request, $id_tugas)
    // {
    //     // dd($request->all());
    //     $userIdnew = $request->session()->get('user_id'); // Mendapatkan ID pengguna dari sesi
    //     $nama_pengguna = User::where('id', $userIdnew)
    //         ->get('nama_pengguna');

    //     $data = json_decode($nama_pengguna, true); // Mengambil data dari JSON karena query diatas menghasilkan data dalam format JSON
    //     $nama_pengguna = $data[0]['nama_pengguna'];

    //     // $completed = 'incomplete'; // Inisialisasi nilai default keterangan tujuan
    //     // $pihak_terlibat = null;

    //     // Buat UUID baru sebagai nilai id_tugas
    //     $uuid = Uuid::uuid4()->toString();

    //     $validator = Validator::make($request->all(), [
    //         'todo_list' => 'required',
    //         'pihak_terlibat' => 'nullable|json',
    //         'url' => 'nullable|url',
    //         'lampiran' => 'nullable|file|mimes:docx,pdf,rar',
    //     ]);

    //     // Cek apakah validasi berhasil
    //     if ($validator->fails()) {
    //         // Jika validasi gagal, kembalikan ke halaman sebelumnya dengan pesan error
    //         return redirect()->back()->withErrors($validator)->withInput();
    //     }

    //     // Temukan tugas berdasarkan $id_tugas
    //     // $id_perkembangan = Perkembangan::where('todo_list', $request->todo_list)
    //     //     ->get('id_perkembangan');

    //     // dd($id_perkembangan);

    //     // $todo_list = $request->input('todo_list');
    //     // $pihak_terlibat = $request->input('nama_pengguna');
    //     // $url = $request->input('url');
    //     // $lampiran = $request->input('lampiran');


    //     $validateData = $request->all();

    //     if (isset($request->lampiran)) {
    //         $lampiran = $request->file('lampiran');
    //         $name = 'PSTI_' . $userIdnew . '_' . date('Ymdhis') . '.' . $request->file('lampiran')->getClientOriginalExtension();
    //         $lampiran->move('lampiran/', $name);
    //         $validateData['lampiran'] = $name;
    //     }

    //     $todo_list = $request->input('todo_list');
    //     $pihak_terlibat = $request->input('nama_pengguna');
    //     $url = $request->input('url');
    //     $lampiran = $request->input('lampiran');

    //     if ($pihak_terlibat === null && $url === null && $lampiran === null) {
    //         return redirect()->back()->with('warning', 'Tidak ada data yang anda kirim. Harap masukkan minimal 1 data pendukung.');
    //     }


    //     $validateData['id_tugas'] = $uuid;
    //     $validateData['user_id'] = $userIdnew;
    //     $validateData['tenggat_waktu_tanggal'] = $selectedTime;
    //     $validateData['ket_tujuan'] = $ket_tujuan;

    //     Tugas::create($validateData);




    //     return redirect()->back()->with('success', 'Lampiran berhasil dikirim.');
    // }

    // public function updateLampiranPerkembangan(Request $request, $id_tugas)
    // {
    //     $todo_list = $request->input('todo_list');
    //     // $id_tugas = $request->input('id_tugas');
    //     // dd($todo_list);
    //     // $perkembangan = Perkembangan::find($id_perkembangan);

    //     // Tangkap data dari input select dengan atribut multiple

    //     $userIdnew = $request->session()->get('user_id'); // Mendapatkan ID pengguna dari sesi

    //     $validator = Validator::make($request->all(), [
    //         'todo_list' => 'required',
    //         'pihak_terlibat' => 'nullable|array',
    //         'url' => 'nullable|url',
    //         'lampiran' => 'nullable|file|mimes:docx,pdf,rar',
    //     ]);

    //     // Cek apakah validasi berhasil
    //     if ($validator->fails()) {
    //         return redirect()->back()->withErrors($validator)->withInput();
    //     }

    //     $perkembangan = Perkembangan::where('id_tugas', $id_tugas)->where('todo_list', $todo_list)->paginate();

    //     $pihak_terlibat = $perkembangan->pluck('pihak_terlibat');
    //     $lampiran = $perkembangan->pluck('lampiran');

    //     // dd($lampiran);

    //     // mengambil pihak terlibat sebelumnya
    //     if ($request->input('pihak_terlibat') == null) {
    //         $pihak_terlibat = $perkembangan->pluck('pihak_terlibat');
    //     } else {
    //         // ambil lampiran sebelumnya
    //         $pihak_terlibat = $request->input('pihak_terlibat');
    //     }

    //     if (isset($request->lampiran)) {
    //         $lampiran = $request->file('lampiran');
    //         $name = 'PSTI_' . $userIdnew . '_' . date('Ymdhis') . '.' . $request->file('lampiran')->getClientOriginalExtension();
    //         $lampiran->move('lampiran/', $name);
    //         $validateData['lampiran'] = $name;
    //     } elseif ($request->lampiran == null){
    //         // ambil lampiran sebelumnya
    //         $name = $lampiran[0];
    //     }

    //     // Update the task fields with the submitted data
    //     $perkembangan->update([
    //         // 'todo_list' => $request->todo_list,
    //         'pihak_terlibat' => $pihak_terlibat,
    //         'url' => $request->url,
    //         'lampiran' => $name,
    //     ]);

    //     // $perkembangan = $perkembangan->pihak_terlibat;
    //     // dd($perkembangan);

    //     // return redirect()->route('s.updatePerkembangan', $id_tugas)->with('success', 'Lampiran berhasil dikirim.');


    //     // return redirect()->route('s.updatePerkembangan', $id_tugas)->with('success', 'Lampiran berhasil dikirim.');
    //     return redirect()->back()->with('success', 'Lampiran berhasil dikirim.');

    // }

    public function updateLampiranPerkembangan(Request $request, $id_tugas)
    {
        $todo_list = $request->input('todo_list');
        $userIdnew = $request->session()->get('user_id');












        // $messages = [
        //     'url.url' => 'Format URL tidak valid.',
        //     'lampiran.mimes' => 'Format lampiran harus docx, pdf, atau rar.',
        // ];

        $validator = Validator::make($request->all(), [
            'todo_list' => 'required',
            'pihak_terlibat' => 'nullable|array',
            'url' => 'nullable|url',
            'lampiran' => 'nullable|mimes:docx,pdf,rar,zip,png,jpg,jpeg',
        ]);

        // Cek apakah validasi berhasil
        if ($validator->fails()) {
            // Jika validasi gagal, kembalikan ke halaman sebelumnya dengan pesan error
            // return redirect()->back()->withErrors($validator)->withInput();

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

        // $perkembangan->update([
        //     'pihak_terlibat' => $pihak_terlibat,
        //     'url' => $request->url,
        //     'lampiran' => $name,
        // ]);

        return redirect()->back()->with('success', 'Update pihak terlibat dan lampiran berhasil.');
    }

    public function riwayatTugas(Request $request, $id_tugas)
    {
        $title = 'Riwayat Tugas';
        $nama_pengguna = Auth::user()->nama_pengguna;
        // $role = Auth::user()->roles[0]->name;
        $role = $request->session()->get('role');

        //Ambil jumlah tugas masuk
        $jumlahTugasMasuk = Tugas::where('tujuan', $nama_pengguna)
            ->where('ket_tujuan', 'menunggu_konfirmasi')
            ->where('role_tujuan', $role)
            ->get();
        $jumlahTugasMasuk = count($jumlahTugasMasuk);

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

        //Ambil alasan penolakan pada tugas yang memiliki ket_tujuan ditolak
        // $alasan_penolakan = $semuaTugas->map(function ($tugas) {
        //     return RiwayatPenolakan::where('id_tugas', $tugas->id_tugas)
        //         ->where('nama_pengguna', $tugas->tujuan)
        //         // ->orderBy('created_at', 'desc') // Urutkan berdasarkan tanggal terbaru
        //         ->value('alasan_penolakan');
        // })->all();

        // // Menggunakan array_filter untuk mengambil nilai array yang tidak null
        // $alasan_penolakan = array_filter($alasan_penolakan, function ($nilai) {
        //     return $nilai !== null;
        // });

        // // Menggunakan implode untuk mengubah array menjadi string
        // $alasan_penolakan = implode(", ", $alasan_penolakan);

        // $alasan_penolakan

        return view('s/riwayat-tugas', compact('jumlahTugasMasuk', 'perkembangans', 'semuaRiwayat', 'title', 'nama_pengguna', 'role'));
    }

    // public function perkembanganTugas($id_tugas)
    // {
    //     $perkembangans = Perkembangan::where('id_tugas', $id_tugas)->paginate();
    //     $semuaTask = Perkembangan::orderBy('created_at', 'desc')->get();

    //     foreach ($semuaTask as $task) {
    //         // Ubah $created_at menjadi objek Carbon
    //         $createdAt = Carbon::parse($task->created_at);

    //         // Formatkan tanggal sesuai dengan format yang diinginkan
    //         $task->formattedDate = $createdAt->format('d M Y');
    //     }

    //     //Ambil title, nama pengguna dan role pengguna
    //     $title = 'Update Perkembangan Tugas';
    //     $nama_pengguna = Auth::user()->nama_pengguna;
    //     $role = Auth::user()->roles[0]->name;

    //     //Ambil jumlah tugas masuk
    //     $jumlahTugasMasuk = Tugas::where('tujuan', $nama_pengguna)
    //         ->where('ket_tujuan', 'menunggu_konfirmasi')
    //         ->get();
    //     $jumlahTugasMasuk = count($jumlahTugasMasuk);

    //     return view('s/perkembangan-tugas', compact('id_tugas', 'jumlahTugasMasuk', 'title', 'nama_pengguna', 'role', 'semuaTask', 'perkembangans'));
    // }

    public function perkembanganTugas(Request $request, $id_tugas)
    {
        $perkembangans = Perkembangan::where('id_tugas', $id_tugas)->paginate();

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

        return view('s/perkembangan-tugas', compact('id_tugas', 'jumlahTugasMasuk', 'title', 'nama_pengguna', 'role', 'semuaTask', 'perkembangans'));
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
            ->get();

        foreach ($stafs as $staf) {
            $nama_staf = $staf->nama_pengguna;
            $jumlahTugasInProgress[$nama_staf] = RiwayatPenerimaan::where('nama_pengguna', $nama_staf)
                ->where('keterangan', 'incomplete')
                ->count();

            $jumlahTugasTotal[$nama_staf] = RiwayatPenerimaan::where('nama_pengguna', $nama_staf)
                ->count();
        }

        return view('s/statistik-tugas', compact('title', 'nama_pengguna', 'role', 'dosens', 'stafs', 'jumlahTugasMasuk', 'jumlahTugasInProgress', 'jumlahTugasTotal'));
    }

    public function detailStatistikTugas(Request $request, $nama_dosen_staf)
    {
        $title = 'Detail Statistik Tugas';
        $nama_pengguna = Auth::user()->nama_pengguna;
        $role = $request->session()->get('role');
        
        //Ambil jumlah tugas masuk
        $jumlahTugasMasuk = Tugas::where('tujuan', $nama_pengguna)
        ->where('ket_tujuan', 'menunggu_konfirmasi')
        ->get();
        $jumlahTugasMasuk = count($jumlahTugasMasuk);
        
        $nama_dosen_staf = $nama_dosen_staf;

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

        $tugas = Tugas::where('tujuan', $nama_dosen_staf)
            ->where('tugas.ket_tujuan', 'diterima')
            ->join('riwayat_penerimaans', 'riwayat_penerimaans.id_tugas', '=', 'tugas.id_tugas')
            ->get();
        $semuaTugas = new Collection();
        $semuaTugas = $semuaTugas->concat($riwayatTeruskans);
        $semuaTugas = $semuaTugas->concat($tugas);

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

        return view('s/detail-statistik-tugas', compact('semuaTugas', 'title', 'nama_pengguna', 'role', 'nama_dosen_staf', 'jumlahTugasMasuk'));
    }

    public function adHoc(Request $request)
    {
        $title = 'Ad Hoc';
        $nama_pengguna = Auth::user()->nama_pengguna;
        $role = $request->session()->get('role');
        $user_id = Auth::user()->id;

        //Ambil jumlah tugas masuk
        $jumlahTugasMasuk = Tugas::where('tujuan', $nama_pengguna)
        ->where('ket_tujuan', 'menunggu_konfirmasi')
        ->get();
        $jumlahTugasMasuk = count($jumlahTugasMasuk);

        $usersWithRoles = DB::table('users')
            ->join('role_users', 'users.id', '=', 'role_users.user_id')
            ->join('roles', 'role_users.role_id', '=', 'roles.id')
            ->select('role_users.id', 'roles.id as id_roles', 'roles.name', 'role_users.user_id', 'users.nama_pengguna')
            ->where('roles.name', '=', 'AdHoc')
            ->get();

        $jumlahData = count($usersWithRoles);

        return view('s/ad-hoc', compact('usersWithRoles', 'jumlahData', 'title', 'nama_pengguna', 'role', 'jumlahTugasMasuk'));
    }

    public function storeAdHoc(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_pengguna' => 'required',
        ]);

        // Cek apakah validasi berhasil
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::where('nama_pengguna', $request->nama_pengguna)->first();
        $role = Role::where('name', 'AdHoc')->first();

        $validateData = $request->all();
        $validateData['user_id'] = $user->id;
        $validateData['role_id'] = $role->id;
        RoleUser::create($validateData);

        return redirect('/s/ad-hoc')->with('success', 'Data berhasil ditambahkan.');
    }

    public function editAdHoc(Request $request, $id)
    {
        $roleUser = RoleUser::findOrFail($id);

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

        //Ambil jumlah tugas masuk
        $jumlahTugasMasuk = Tugas::where('tujuan', $nama_pengguna)
        ->where('ket_tujuan', 'menunggu_konfirmasi')
        ->get();
        $jumlahTugasMasuk = count($jumlahTugasMasuk);

        return view('s/edit-ad-hoc', compact('nama_pengguna_edit', 'nama_role_edit', 'roleUser', 'title', 'nama_pengguna', 'role', 'jumlahTugasMasuk'));
    }

    public function destroyAdHoc($id)
    {
        $roleUser = RoleUser::find($id);

        if ($roleUser) {
            $roleUser->delete();
            return redirect('/s/ad-hoc')->with('success', 'Data berhasil dihapus!');
        } else {
            return redirect('/s/ad-hoc')->with('error', 'Data tidak ditemukan.');
        }
    }

    public function updateAdHoc(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_pengguna' => 'required',
        ]);

        if ($validator->fails()) {
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

        return redirect('s/ad-hoc')->with('success', 'Data berhasil diperbarui!');
    }
}
