<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resign extends Model
{
    protected $table = 'resign';

    protected $fillable = [
        'data_induk_id',
        'no',
        'mulai_bertugas',
        'npa',
        'nama',
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
        'tgl',
        'bln',
        'thn',
        'no_sk'
    ];

    protected $casts = [
        'mulai_bertugas' => 'date',
        'tanggal_resign' => 'date'
    ];

    // Relasi ke Data Induk
    public function dataInduk()
    {
        return $this->belongsTo(DataInduk::class);
    }
}