<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPenolakan extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_penolakan';
    public $incrementing = false;

    protected $fillable = [
        'id_penolakan',
        'id_tugas',
        'nama_pengguna',
        'alasan_penolakan',
    ];
}
