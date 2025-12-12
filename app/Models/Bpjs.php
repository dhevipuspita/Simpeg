<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bpjs extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'bpjs';
    protected $primaryKey = 'bpjsId';

    // Kolom yang boleh di-mass assign
    protected $fillable = [
        'staffId',
        'name',
        'noBpjs',
        'kjp_2p',
        'kjp_3p',
        'keterangan',
    ];

    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'staffId', 'staffId');
    }
    
}

