<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatJabatan extends Model
{
    use HasFactory;

    protected $table = 'riwayat_jabatan';
    protected $primaryKey = 'riwayat_jabatan_id';

    protected $fillable = [
        'riwayatId',
        'nama_jabatan',
        'tanggal',
    ];

    public function riwayat()
    {
        return $this->belongsTo(Riwayat::class, 'riwayatId', 'riwayatId');
    }
}
