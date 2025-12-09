<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Riwayat extends Model
{
    use HasFactory;

    protected $table = 'riwayat';
    protected $primaryKey = 'riwayatId';

    protected $fillable = [
        'staffId',
        'pendidikan',
        'instansi',
        'tmt_awal',
        'golongan',         
        'tmt_kini',
        'riwayat_gol',
        'riwayat_jabatan',
        'status',
        'keterangan',
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staffId', 'staffId');
    }

    public function jenisGolongan()
    {
        return $this->belongsTo(JenisGolongan::class, 'golongan', 'jenisId');
    }

    public function riwayatGolongan()
    {
        return $this->hasMany(RiwayatGolongan::class, 'riwayatId', 'riwayatId');
    }

    public function latestRiwayatGolongan()
    {
        return $this->hasOne(RiwayatGolongan::class, 'riwayatId', 'riwayatId')
                    ->latestOfMany('tanggal'); 
    }

    public function riwayatJabatan()
    {
        return $this->hasMany(RiwayatJabatan::class, 'riwayatId', 'riwayatId');
    }
}
