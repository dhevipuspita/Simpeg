<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Perizinan extends Model
{
    use HasFactory;

    protected $table = 'perizinan';
    protected $primaryKey = "perizinanId";

     protected $fillable = [
        'staffId',
        'data_induk_id',
        'tglSurat',
        'mulai_tanggal',
        'akhir_tanggal',
        'lamaCuti',
        'alasan',
        'isComback',
    ];
    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class, "staffId", "staffId");
    }
    public function dataInduk()
    {
        return $this->belongsTo(DataInduk::class, 'data_induk_id', 'id');
    }
}
