<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataInduk extends Model
{
    use HasFactory;

    protected $table = "data_induk";
    protected $primaryKey = "id";

    protected $fillable = [
        'nama',
        'nik',
        'npa',
        'jabatan',
        'gol',
        'jenjang',
        'mulai_bertugas',
        // DATA PRIBADI
        'ttl',
        'no_hp',
        'status_perkawinan',
        'suami_istri',
        'alamat',
        'email',
        'keterangan',
        // STATUS
        'status_pegawai',
    ];

    public function resign()
    {
        return $this->hasOne(Resign::class, 'data_induk_id');
    }
}
