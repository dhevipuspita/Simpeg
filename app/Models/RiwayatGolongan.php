<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatGolongan extends Model
{
    use HasFactory;

    protected $table = 'riwayat_golongan';
    protected $primaryKey = 'riwayat_gol_id';

    protected $fillable = [
        'riwayatId',
        'jenis_golongan',
        'tanggal',
    ];

    public function riwayat()
    {
        return $this->belongsTo(Riwayat::class, 'riwayatId', 'riwayatId');
    }
}
