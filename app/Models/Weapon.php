<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Owner;
use App\Models\WeaponType;
use App\Models\Warehouse;

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
        return $this->belongsToMany(Owner::class,'owner_weapon');
    }

    public function weaponType(){
        return $this->belongsTo(WeaponType::class);
    }

    public function warehouse(){
        return $this->belongsTo(Warehouse::class);
    }
}

