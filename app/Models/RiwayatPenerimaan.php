<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPenerimaan extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_penerimaan';
    public $incrementing = false;

    protected $fillable = [
        'id_penerimaan',
        'id_tugas',
        'nama_pengguna',
        'keterangan',
    ];

    public function tugas()
    {
        return $this->belongsTo(Tugas::class, 'id_tugas', 'id_tugas');
    }
}
