<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_tugas';
    public $incrementing = false;

    protected $fillable = [
        'id_tugas',
        'user_id',
        'nama_pengirim',
        'role_pengirim',
        'perihal',
        'tenggat_waktu_jam',
        'tenggat_waktu_tanggal',
        'url',
        'lampiran',
        'tujuan',
        'role_tujuan',
        'ket_tujuan'
    ];

    // protected $hidden = [
    //     'user_id',
    // ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function riwayatPenerimaan()
    {
        return $this->hasOne(RiwayatPenerimaan::class, 'id_tugas', 'id_tugas');
    }

    public function riwayatPenolakan()
    {
        return $this->hasMany(RiwayatPenolakan::class, 'id_tugas');
    }

    public function riwayatTeruskan()
    {
        return $this->hasMany(RiwayatTeruskan::class, 'id_tugas');
    }

    public function perkembangan()
    {
        return $this->hasMany(Perkembangan::class, 'id_tugas');
    }
}
