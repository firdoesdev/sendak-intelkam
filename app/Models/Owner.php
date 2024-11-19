<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OwnerType;
use App\Models\Weapon;

class Owner extends Model
{
    /** @use HasFactory<\Database\Factories\OwnerFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'address'
    ];

    public function ownerType()
    {
        return $this->belongsTo(OwnerType::class);
    }

    public function weapons()
    {
        return $this->belongsToMany(Weapon::class,'owner_weapons');
                        
    }
}
