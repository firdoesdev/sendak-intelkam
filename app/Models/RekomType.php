<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekomType extends Model
{
    /** @use HasFactory<\Database\Factories\RekomTypeFactory> */
    use HasFactory;

    public function rekoms()
    {
        return $this->hasMany(Rekom::class);
    }
}
