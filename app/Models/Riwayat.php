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
        'riwayat_jabatan',     
        'status',    
        'keterangan',     
    ];
    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staffId', 'staffId');
    }
    public function riwayatGolongan()
    {
        return $this->hasMany(RiwayatGolongan::class, 'riwayatId', 'riwayatId');
    }
}
