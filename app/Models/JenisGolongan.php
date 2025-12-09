<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JenisGolongan extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'jenis_golongan';
    protected $primaryKey = 'jenisId';
    protected $fillable = [
        'jenis',
    ];
}
