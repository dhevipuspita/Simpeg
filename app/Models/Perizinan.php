<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perizinan extends Model
{
    use HasFactory;

    protected $table = 'perizinan';
    protected $primaryKey = 'perizinanId';

    protected $fillable = [
        'data_induk_id',
        'tglSurat',
        'mulai_tanggal',
        'akhir_tanggal',
        'lamaCuti',
        'alasan',
        'isComback',
    ];

    public function dataInduk()
    {
        return $this->belongsTo(DataInduk::class, 'data_induk_id', 'id');
    }
}
