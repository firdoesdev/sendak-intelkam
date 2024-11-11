<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BulletType extends Model
{
    /** @use HasFactory<\Database\Factories\BulletTypeFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
    ];
}
