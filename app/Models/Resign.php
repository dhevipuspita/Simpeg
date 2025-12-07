<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resign extends Model
{
    use HasFactory;

    protected $table = 'resigns';
    protected $primaryKey = 'resignId';

    protected $fillable = [
        'npa',
        'name',
        'jabatan',
        'gol',
        'jenjang',
        'ttl',
        'alamat',
        'pendidikan',
        'tanggal_resign',
        'alasan_resign',
        'nik',
        'status_kepegawaian',
        'tahun',
        'no_sk',
    ];
}
