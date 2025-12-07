<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mengikuti extends Model
{
    use HasFactory;
    protected $table = 'mengikutis';
    protected $primaryKey = 'mengikutiId';
    protected $fillable = [
        'santriId', 
        'matpelId',
        "created_at",
        "updated_at",
    ];

    public function santri(): BelongsTo
    {
        return $this->belongsTo(Santri::class, 'santriId', 'santriId');
    }
}
