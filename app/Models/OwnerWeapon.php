<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\Pivot;

class OwnerWeapon extends Pivot
{
    /** @use HasFactory<\Database\Factories\OwnerWeaponFactory> */
    // use HasFactory;
    protected $table = 'owner_weapon';
    protected $fillable = ['owner_id', 'weapon_id'];

}
