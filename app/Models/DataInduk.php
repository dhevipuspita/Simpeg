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
        "no",
        "mulai_bertugas",
        "npa",
        "nama",
        "jenjang_jabatan",
        "gol",
        "status",
        "status_pegawai", // WAJIB! Agar bisa berubah jadi 'resign'
    ];

    public function resign()
    {
        return $this->hasOne(Resign::class, 'data_induk_id');
    }
}
