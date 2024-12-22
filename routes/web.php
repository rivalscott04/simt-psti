<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SelectTujuan;
use App\Http\Controllers\TestController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DelegasiTugasStaf;
use App\Http\Controllers\DelegasiTugasAdHoc;
use App\Http\Controllers\DelegasiTugasDosen;
use App\Http\Controllers\DelegasiTugasKalab;
use App\Http\Controllers\DelegasiTugasKaprodi;
use App\Http\Controllers\DaftarTugas;
use App\Http\Controllers\DelegasiTugasSekprodi;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/coba', function () {
    return view('cobasweetalert');
});

Route::get('/', function () { return view('beranda'); });
// Route::resource('/daftar-tugas', DaftarTugas::class);

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('authenticate')->middleware('web');
Route::get('/selectedRole', [LoginController::class, 'index2'])->middleware('auth');
Route::post('/selectedRole', [LoginController::class, 'selectedRole'])->name('selectedRole')->middleware('auth');
Route::get('/logout', [LoginController::class, 'logout'])->middleware('auth');

//Select Tujuan
Route::group(['middleware' => ['auth', 'web']], function () {
    Route::get('selectRole', [SelectTujuan::class, 'role'])->name('selectRole');
    Route::get('getUser/{role_tujuan}', [SelectTujuan::class, 'getUser'])->name('get');
    Route::get('getAllUser', [SelectTujuan::class, 'getAllUser']);
    Route::get('getAllRole', [SelectTujuan::class, 'getAllRole']);
});

//Kaprodi
Route::group(['middleware' => ['auth', 'web', 'role:Kaprodi']], function () {
    Route::resource('k/delegasi-tugas', DelegasiTugasKaprodi::class);
    // Route::get('k/delegasi-tugas', [DelegasiTugasKaprodi::class, 'index']);
    Route::get('k/tambah-delegasi-tugas', [DelegasiTugasKaprodi::class, 'create']);
    Route::get('k/delegasi-tugas/{id_tugas}/edit', [DelegasiTugasKaprodi::class, 'edit'])->name('k.edit');
    Route::post('k/delegasi-tugas/{id_tugas}', [DelegasiTugasKaprodi::class, 'update'])->name('k.update');
    Route::get('k/download/{tugas}', [DelegasiTugasKaprodi::class, 'download'])->name('k.download');
    Route::get('k/riwayat-tugas/{id_tugas}', [DelegasiTugasKaprodi::class, 'riwayatTugas'])->name('k.riwayatTugas');
    Route::post('k/perkembangan-tugas-selesai/{id_perkembangan}', [DelegasiTugasKaprodi::class, 'perkembanganSelesai'])->name('k.perkembangan.selesai');
    Route::post('k/perkembangan-tugas-revisi/{id_perkembangan}', [DelegasiTugasKaprodi::class, 'revisi'])->name('k.revisi');
    Route::get('k/statistik-tugas', [DelegasiTugasKaprodi::class, 'statistikTugas']);
    Route::get('k/detail-statistik-tugas/{nama_dosen_staf}', [DelegasiTugasKaprodi::class, 'detailStatistikTugas'])->name('k.detailStatistikTugas');

    // Route::resource('k/ad-hoc', DelegasiTugasKaprodi::class);
    Route::get('k/ad-hoc', [DelegasiTugasKaprodi::class, 'adHoc']);
    Route::post('k/tambah-ad-hoc', [DelegasiTugasKaprodi::class, 'storeAdHoc'])->name('k.storeAdHoc');
    Route::get('k/ad-hoc/{id}/edit', [DelegasiTugasKaprodi::class, 'editAdHoc'])->name('k.editAdHoc');
    Route::post('k/ad-hoc/{id}/update', [DelegasiTugasKaprodi::class, 'updateAdHoc'])->name('k.updateAdHoc');
    Route::post('k/ad-hoc/{id}/destroy', [DelegasiTugasKaprodi::class, 'destroyAdHoc'])->name('k.destroyAdHoc');
    Route::get('k/getAllUser', [DelegasiTugasKaprodi::class, 'getAllUser'])->name('k.getAllUser');
});

//Sekprodi
Route::group(['middleware' => ['auth', 'web', 'role:Sekprodi']], function () {
    Route::resource('s/delegasi-tugas', DelegasiTugasSekprodi::class);
    Route::get('s/tambah-delegasi-tugas', [DelegasiTugasSekprodi::class, 'create']);
    Route::get('s/delegasi-tugas/{id_tugas}/edit', [DelegasiTugasSekprodi::class, 'edit'])->name('s.edit');
    Route::post('s/delegasi-tugas/{id_tugas}', [DelegasiTugasSekprodi::class, 'update'])->name('s.update');
    Route::get('s/delegasi-tugas-teruskan/{id_tugas}/edit', [DelegasiTugasSekprodi::class, 'editTeruskan'])->name('s.editTeruskan');
    Route::post('s/delegasi-tugas-teruskan/{id_tugas}', [DelegasiTugasSekprodi::class, 'updateTeruskan'])->name('s.updateTeruskan');
    Route::get('s/riwayat-tugas/{id_tugas}', [DelegasiTugasSekprodi::class, 'riwayatTugas'])->name('s.riwayatTugas');
    Route::post('s/perkembangan-tugas-selesai/{id_perkembangan}', [DelegasiTugasSekprodi::class, 'perkembanganSelesai'])->name('s.perkembangan.selesai');
    Route::post('s/perkembangan-tugas-revisi/{id_perkembangan}', [DelegasiTugasSekprodi::class, 'revisi'])->name('s.revisi');

    Route::get('s/tugas-masuk', [DelegasiTugasSekprodi::class, 'tugasMasuk']);
    Route::get('s/tugas-masuk/{tugas}', [DelegasiTugasSekprodi::class, 'show'])->name('s.show');
    Route::post('s/tugas-masuk/{id_tugas}/accept', [DelegasiTugasSekprodi::class, 'accept'])->name('s.accept');
    Route::post('s/tugas-masuk/{id_tugas}/reject', [DelegasiTugasSekprodi::class, 'reject'])->name('s.reject');
    Route::post('s/tugas-masuk/{id_tugas}/forward', [DelegasiTugasSekprodi::class, 'forward'])->name('s.forward');
    Route::get('download/{tugas}', [DelegasiTugasSekprodi::class, 'download'])->name('s.download');

    Route::get('s/tugas', [DelegasiTugasSekprodi::class, 'tugas'])->name('s.tugas');
    Route::get('s/perkembangan-tugas/{id_tugas}/update', [DelegasiTugasSekprodi::class, 'updatePerkembangan'])->name('s.updatePerkembangan');
    Route::post('s/update-perkembangan-tugas/{id_tugas}/tambah', [DelegasiTugasSekprodi::class, 'addTodoList'])->name('s.addTodoList');
    Route::post('s/update-status/{id_tugas}', [DelegasiTugasSekprodi::class, 'updateStatus'])->name('s.updateStatus');
    Route::get('getTask/{id_tugas}', [DelegasiTugasSekprodi::class, 'getTask'])->name('getTask');

    Route::post('s/perkembangan-tugas/{id_perkembangan}/update', [DelegasiTugasSekprodi::class, 'updateStatusPerkembangan'])->name('s.updateStatusPerkembangan');
    Route::post('s/perkembangan-tugas-lampiran/{id_tugas}', [DelegasiTugasSekprodi::class, 'updateLampiranPerkembangan'])->name('s.updateLampiranPerkembangan');
    Route::get('s/statistik-tugas', [DelegasiTugasSekprodi::class, 'statistikTugas']);
    Route::get('s/detail-statistik-tugas/{nama_dosen_staf}', [DelegasiTugasSekprodi::class, 'detailStatistikTugas'])->name('s.detailStatistikTugas');

    Route::get('s/ad-hoc', [DelegasiTugasSekprodi::class, 'adHoc']);
    Route::post('s/tambah-ad-hoc', [DelegasiTugasSekprodi::class, 'storeAdHoc'])->name('s.storeAdHoc');
    Route::get('s/ad-hoc/{id}/edit', [DelegasiTugasSekprodi::class, 'editAdHoc'])->name('s.editAdHoc');
    Route::post('s/ad-hoc/{id}/update', [DelegasiTugasSekprodi::class, 'updateAdHoc'])->name('s.updateAdHoc');
    Route::post('s/ad-hoc/{id}/destroy', [DelegasiTugasSekprodi::class, 'destroyAdHoc'])->name('s.destroyAdHoc');
    Route::get('s/getAllUser', [DelegasiTugasSekprodi::class, 'getAllUser'])->name('s.getAllUser');
});

//Kalab
Route::group(['middleware' => ['auth', 'web', 'role:Kalab']], function () {
    Route::resource('kl/delegasi-tugas', DelegasiTugasKalab::class);
    Route::get('kl/tambah-delegasi-tugas', [DelegasiTugasKalab::class, 'create']);
    Route::get('kl/delegasi-tugas/{id_tugas}/edit', [DelegasiTugasKalab::class, 'edit'])->name('kl.edit');
    Route::post('kl/delegasi-tugas/{id_tugas}', [DelegasiTugasKalab::class, 'update'])->name('kl.update');
    Route::get('kl/riwayat-tugas/{id_tugas}', [DelegasiTugasKalab::class, 'riwayatTugas'])->name('kl.riwayatTugas');
    Route::post('kl/perkembangan-tugas-selesai/{id_perkembangan}', [DelegasiTugasKalab::class, 'perkembanganSelesai'])->name('kl.perkembangan.selesai');
    Route::post('kl/perkembangan-tugas-revisi/{id_perkembangan}', [DelegasiTugasKalab::class, 'revisi'])->name('kl.revisi');

    Route::get('kl/tugas-masuk', [DelegasiTugasKalab::class, 'tugasMasuk']);
    Route::get('kl/tugas-masuk/{tugas}', [DelegasiTugasKalab::class, 'show'])->name('kl.show');
    Route::post('kl/tugas-masuk/{id_tugas}/accept', [DelegasiTugasKalab::class, 'accept'])->name('kl.accept');
    Route::post('kl/tugas-masuk/{id_tugas}/reject', [DelegasiTugasKalab::class, 'reject'])->name('kl.reject');
    Route::post('kl/tugas-masuk/{id_tugas}/forward', [DelegasiTugasKalab::class, 'forward'])->name('kl.forward');
    Route::get('kl/download/{tugas}', [DelegasiTugasKalab::class, 'download'])->name('kl.download');

    Route::get('kl/tugas', [DelegasiTugasKalab::class, 'tugas'])->name('kl.tugas');
    Route::get('kl/perkembangan-tugas/{id_tugas}/update', [DelegasiTugasKalab::class, 'updatePerkembangan'])->name('kl.updatePerkembangan');
    Route::post('kl/update-perkembangan-tugas/{id_tugas}/tambah', [DelegasiTugasKalab::class, 'addTodoList'])->name('kl.addTodoList');
    Route::post('kl/update-status/{id_tugas}', [DelegasiTugasKalab::class, 'updateStatus'])->name('kl.updateStatus');
    Route::get('kl/getTask/{id_tugas}', [DelegasiTugasKalab::class, 'getTask'])->name('kl.getTask');
    Route::get('kl/getAllUser', [DelegasiTugasKalab::class, 'getAllUser'])->name('kl.getAllUser');
    Route::post('kl/tugas/{id_perkembangan}/update', [DelegasiTugasKalab::class, 'updateStatusTugas'])->name('kl.updateStatusTugas'); //sepertinya ini tidak terpakai

    Route::post('kl/perkembangan-tugas/{id_perkembangan}/update', [DelegasiTugasKalab::class, 'updateStatusPerkembangan'])->name('kl.updateStatusPerkembangan');
    Route::post('kl/perkembangan-tugas-lampiran/{id_tugas}', [DelegasiTugasKalab::class, 'updateLampiranPerkembangan'])->name('kl.updateLampiranPerkembangan');
    Route::post('kl/perkembangan-tugas/{id_tugas}/updateStatusRiwayatPenerimaan', [DelegasiTugasKalab::class, 'updateStatusRiwayatPenerimaan'])->name('kl.updateStatusRiwayatPenerimaan');

    Route::get('kl/statistik-tugas', [DelegasiTugasKalab::class, 'statistikTugas']);
});

// AdHoc
Route::group(['middleware' => ['auth', 'web', 'role:AdHoc']], function () {
    Route::resource('ah/delegasi-tugas', DelegasiTugasAdHoc::class);
    Route::get('ah/tambah-delegasi-tugas', [DelegasiTugasAdHoc::class, 'create']);
    Route::get('ah/delegasi-tugas/{id_tugas}/edit', [DelegasiTugasAdHoc::class, 'edit'])->name('ah.edit');
    Route::post('ah/delegasi-tugas/{id_tugas}', [DelegasiTugasAdHoc::class, 'update'])->name('ah.update');
    Route::get('ah/riwayat-tugas/{id_tugas}', [DelegasiTugasAdHoc::class, 'riwayatTugas'])->name('ah.riwayatTugas');

    Route::post('ah/perkembangan-tugas-selesai/{id_perkembangan}', [DelegasiTugasAdHoc::class, 'perkembanganSelesai'])->name('ah.perkembangan.selesai');
    Route::post('ah/perkembangan-tugas-revisi/{id_perkembangan}', [DelegasiTugasAdHoc::class, 'revisi'])->name('ah.revisi');

    Route::get('ah/tugas-masuk', [DelegasiTugasAdHoc::class, 'tugasMasuk']);
    Route::get('ah/tugas-masuk/{tugas}', [DelegasiTugasAdHoc::class, 'show'])->name('ah.show');
    Route::post('ah/tugas-masuk/{id_tugas}/accept', [DelegasiTugasAdHoc::class, 'accept'])->name('ah.accept');
    Route::post('ah/tugas-masuk/{id_tugas}/reject', [DelegasiTugasAdHoc::class, 'reject'])->name('ah.reject');
    Route::post('ah/tugas-masuk/{id_tugas}/forward', [DelegasiTugasAdHoc::class, 'forward'])->name('ah.forward');
    Route::get('ah/download/{tugas}', [DelegasiTugasAdHoc::class, 'download'])->name('ah.download');

    Route::get('ah/tugas', [DelegasiTugasAdHoc::class, 'tugas'])->name('ah.tugas');
    Route::get('ah/perkembangan-tugas/{id_tugas}/update', [DelegasiTugasAdHoc::class, 'updatePerkembangan'])->name('ah.updatePerkembangan');
    Route::post('ah/update-perkembangan-tugas/{id_tugas}/tambah', [DelegasiTugasAdHoc::class, 'addTodoList'])->name('ah.addTodoList');
    Route::post('ah/update-status/{id_tugas}', [DelegasiTugasAdHoc::class, 'updateStatus'])->name('ah.updateStatus');
    Route::get('ah/getTask/{id_tugas}', [DelegasiTugasAdHoc::class, 'getTask'])->name('ah.getTask');
    Route::get('ah/getAllUser', [DelegasiTugasAdHoc::class, 'getAllUser'])->name('ah.getAllUser');

    Route::post('ah/perkembangan-tugas/{id_perkembangan}/update', [DelegasiTugasAdHoc::class, 'updateStatusPerkembangan'])->name('ah.updateStatusPerkembangan');
    Route::post('ah/perkembangan-tugas-lampiran/{id_tugas}', [DelegasiTugasAdHoc::class, 'updateLampiranPerkembangan'])->name('ah.updateLampiranPerkembangan');
    Route::post('ah/perkembangan-tugas/{id_tugas}/updateStatusRiwayatPenerimaan', [DelegasiTugasAdHoc::class, 'updateStatusRiwayatPenerimaan'])->name('ah.updateStatusRiwayatPenerimaan');

});

//Dosen
Route::group(['middleware' => ['auth', 'web', 'role:Dosen']], function () {
    Route::get('d/tugas-masuk', [DelegasiTugasDosen::class, 'tugasMasuk']);
    Route::get('d/tugas-masuk/{tugas}', [DelegasiTugasDosen::class, 'show'])->name('d.show');
    Route::post('d/tugas-masuk/{id_tugas}/accept', [DelegasiTugasDosen::class, 'accept'])->name('d.accept');
    Route::post('d/tugas-masuk/{id_tugas}/reject', [DelegasiTugasDosen::class, 'reject'])->name('d.reject');
    Route::get('d/download/{tugas}', [DelegasiTugasDosen::class, 'download'])->name('d.download');

    Route::get('d/tugas', [DelegasiTugasDosen::class, 'tugas'])->name('d.tugas');
    Route::get('d/perkembangan-tugas/{id_tugas}/update', [DelegasiTugasDosen::class, 'updatePerkembangan'])->name('d.updatePerkembangan');
    Route::post('d/update-perkembangan-tugas/{id_tugas}/tambah', [DelegasiTugasDosen::class, 'addTodoList'])->name('d.addTodoList');
    Route::post('d/update-status/{id_tugas}', [DelegasiTugasDosen::class, 'updateStatus'])->name('d.updateStatus');
    Route::get('d/getTask/{id_tugas}', [DelegasiTugasDosen::class, 'getTask'])->name('d.getTask');
    Route::get('d/getAllUser', [DelegasiTugasDosen::class, 'getAllUser'])->name('d.getAllUser');

    Route::post('d/perkembangan-tugas/{id_perkembangan}/update', [DelegasiTugasDosen::class, 'updateStatusPerkembangan'])->name('d.updateStatusPerkembangan');
    Route::post('d/perkembangan-tugas-lampiran/{id_tugas}', [DelegasiTugasDosen::class, 'updateLampiranPerkembangan'])->name('d.updateLampiranPerkembangan');
    Route::post('d/perkembangan-tugas/{id_tugas}/updateStatusRiwayatPenerimaan', [DelegasiTugasDosen::class, 'updateStatusRiwayatPenerimaan'])->name('d.updateStatusRiwayatPenerimaan');

});

//Staf
Route::group(['middleware' => ['auth', 'web', 'role:Staf']], function () {
    Route::get('st/tugas-masuk', [DelegasiTugasStaf::class, 'tugasMasuk']);
    Route::get('st/tugas-masuk/{tugas}', [DelegasiTugasStaf::class, 'show'])->name('st.show');
    Route::post('st/tugas-masuk/{id_tugas}/accept', [DelegasiTugasStaf::class, 'accept'])->name('st.accept');
    Route::post('st/tugas-masuk/{id_tugas}/reject', [DelegasiTugasStaf::class, 'reject'])->name('st.reject');
    Route::get('st/download/{tugas}', [DelegasiTugasStaf::class, 'download'])->name('st.download');

    Route::get('st/tugas', [DelegasiTugasStaf::class, 'tugas'])->name('st.tugas');
    Route::get('st/perkembangan-tugas/{id_tugas}/update', [DelegasiTugasStaf::class, 'updatePerkembangan'])->name('st.updatePerkembangan');
    Route::post('st/update-perkembangan-tugas/{id_tugas}/tambah', [DelegasiTugasStaf::class, 'addTodoList'])->name('st.addTodoList');
    Route::post('st/update-status/{id_tugas}', [DelegasiTugasStaf::class, 'updateStatus'])->name('st.updateStatus');
    Route::get('st/getTask/{id_tugas}', [DelegasiTugasStaf::class, 'getTask'])->name('st.getTask');
    Route::get('st/getAllUser', [DelegasiTugasStaf::class, 'getAllUser'])->name('st.getAllUser');

    Route::post('st/perkembangan-tugas/{id_perkembangan}/update', [DelegasiTugasStaf::class, 'updateStatusPerkembangan'])->name('st.updateStatusPerkembangan');
    Route::post('st/perkembangan-tugas-lampiran/{id_tugas}', [DelegasiTugasStaf::class, 'updateLampiranPerkembangan'])->name('st.updateLampiranPerkembangan');
    Route::post('st/perkembangan-tugas/{id_tugas}/updateStatusRiwayatPenerimaan', [DelegasiTugasStaf::class, 'updateStatusRiwayatPenerimaan'])->name('st.updateStatusRiwayatPenerimaan');

});

//Admin
Route::group(['middleware' => ['auth', 'web', 'role:Admin']], function () {
    Route::resource('admin', AdminController::class);
    Route::get('admin/pengaturan/{id}/edit', [AdminController::class, 'edit'])->name('ad.edit');
    Route::post('admin/pengaturan/{id}', [AdminController::class, 'update'])->name('ad.update');
    Route::get('admin/getAllUser', [AdminController::class, 'getAllUser'])->name('admin.getAllUser');
});