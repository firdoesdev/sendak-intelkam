<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Weapon;

class Warehouse extends Model
{
    //

    protected $fillable = [
        'name',
        'location'
    ];

    public function weapons(){
        return $this->hasMany(Weapon::class);
    }

}
