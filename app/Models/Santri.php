<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Santri extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "santris";
    protected $primaryKey = "santriId";
    protected $fillable = [
        "pengurusId",
        "waliId",
        "name",
        "age",
        "address",
        "birthPlace",
        "birthDate",
        "created_at",
        "updated_at",
    ];

    public function pengurus(): BelongsTo
    {
        return $this->belongsTo(Pengurus::class, "pengurusId", "pengurusId");
    }

    public function wali(): BelongsTo
    {
        return $this->belongsTo(Wali::class, "waliId", "waliId");
    }

    public function permissions(): HasMany
    {
        return $this->hasMany(Permission::class, "santriId", "santriId");
    }
}
