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
        'caliber',
        'qty',
        'unit',
        'brand'
    ];

    public function owners(){
        return $this->belongsToMany(Owner::class,'owner_weapons')
        ->withPivot('status','description','assigned_at','previous_owner_id');
    }

    public function weaponType(){
        return $this->belongsTo(WeaponType::class);
    }

    public function warehouse(){
        return $this->belongsTo(Warehouse::class);
    }

    public function rekom(){
        return $this->belongsTo(Rekom::class);
    }
}

