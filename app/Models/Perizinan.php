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
        "tglSurat",
        "staffId",
        "name",
        "nik",
        "npa",
        "birthPlace",
        "birthDate",
        "alamat",
        "jenjang",
        "jabatan",
        "tglMulai",
        "tglAkhir",
        "lamaCuti",
        "alasan",
        "isComback",
    ];
    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class, "staffId", "staffId");
    }
}
