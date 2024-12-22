<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perkembangan extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_perkembangan';
    public $incrementing = false;
    
    protected $fillable = [
        'id_perkembangan',
        'id_tugas',
        'todo_list',
        'keterangan',        
        'pihak_terlibat',
        'url',
        'lampiran',
        'nama_pengguna',
        'alasan_revisi'
    ];
}
