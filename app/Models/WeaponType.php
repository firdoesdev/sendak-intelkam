<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Weapon;

class WeaponType extends Model
{
    /** @use HasFactory<\Database\Factories\WeaponTypeFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function weapons(){
        return $this->hasMany(Weapon::class);
    }
}
