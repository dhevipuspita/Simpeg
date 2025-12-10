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
        
        "mulai_bertugas",
        "npa",
        "nama",
        "jenjang",
        "jabatan",
        "gol",
        "status",
        "status_pegawai", // WAJIB! Agar bisa berubah jadi 'resign'
    ];

    public function staff()
    {
        return $this->hasOne(Staff::class, 'dataIndukId', 'id');
    }
    public function perizinan()
    {
        return $this->hasMany(Perizinan::class, 'data_induk_id', 'id');
    }
    public function resign()
    {
        return $this->hasOne(Resign::class, 'data_induk_id');
    }

}
