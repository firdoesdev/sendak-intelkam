<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\Pivot;
// use Illuminate\Database\Eloquent\Model;

class OwnerWeapon extends Pivot
{
    /** @use HasFactory<\Database\Factories\OwnerWeaponFactory> */
    // use HasFactory;
    protected $table = 'owner_weapons';
    protected $fillable = ['owner_id', 'weapon_id','status','description','previous_owner_id','assigned_at'];

}
