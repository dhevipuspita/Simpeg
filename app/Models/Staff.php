<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "staff";
    protected $primaryKey = "staffId";
    protected $fillable = [
        "name",
        "birthPlace",
        "birthDate",
        "nik",
        "noHp",
        "statusPerkawinan",
        "suami_istri",
        "alamat",
        "email",
        "created_at",
        "updated_at",
    ];

    public function permissions(): HasMany
    {
        return $this->hasMany(Permission::class, "staffId", "staffId");
    }

}
