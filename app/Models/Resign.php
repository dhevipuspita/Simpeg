<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resign extends Model
{
    protected $table = 'resign';
    protected $primaryKey = 'resignId';

    protected $fillable = [
        'data_induk_id',
        'tanggal_resign',
        'alasan_resign',
        'no_sk',
        'isComback'
    ];

    // Relasi ke Data Induk
    public function dataInduk()
    {
        return $this->belongsTo(DataInduk::class, 'data_induk_id', 'id');
    }
    public function riwayat()
    {
        return $this->hasOne(Riwayat::class, 'data_induk_id', 'data_induk_id')->latestOfMany('tmt_awal');
    }
}
