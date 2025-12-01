<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Permission extends Model
{
    use HasFactory;
    protected $table = 'permissions';
    protected $primaryKey = "permissionId";
    protected $fillable = [
        "tglSurat",
        "santriId",
        "nik",
        "npa",
        "ttl",
        "alamat",
        "jenjang",
        "jabatan",
        "tglMulai",
        "tglAkhir",
        "lamaCuti",
        "alasan",
        "isComback",
    ];

    public function santri(): BelongsTo
    {
        return $this->belongsTo(Santri::class, 'santriId', 'santriId');
    }
}
