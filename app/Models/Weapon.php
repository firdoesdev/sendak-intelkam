<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Owner;

class Weapon extends Model
{
    /** @use HasFactory<\Database\Factories\WeaponFactory> */
    use HasFactory;

    protected $fillable = [
        'serial',
        'name',
        'caliber'
    ];

    public function owners(){
        return $this->belongsToMany(Owner::class,'owner_weapons');
    }
}

