<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatTeruskan extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_teruskan';
    public $incrementing = false;

    protected $fillable = [
        'id_teruskan',
        'id_tugas',
        'nama_pengirim',
        'role_pengirim',
        'nama_tujuan',
        'role_tujuan',
        'ket_tujuan',
    ];

    public function riwayatTeruskan()
    {
        return $this->hasOne(RiwayatTeruskan::class, 'id_tugas');
    }
}
