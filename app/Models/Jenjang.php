<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jenjang extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'jenjang';
    protected $primaryKey = 'jenjangId';
    protected $fillable = [
        'nama_jenjang',
    ];
}

