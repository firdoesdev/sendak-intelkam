<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OwnerType;
use App\Models\Weapon;
use App\Models\Rekom;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Owner extends Model
{
    /** @use HasFactory<\Database\Factories\OwnerFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'no_ktp',
        'address',
        'phone'
    ];

    public function ownerType()
    {
        return $this->belongsTo(OwnerType::class);
    }

    public function weapons()
    {
        return $this->belongsToMany(Weapon::class,'owner_weapon');                   
    }

    public function rekoms():HasMany
    {
        return $this->hasMany(Rekom::class);
    }
}
