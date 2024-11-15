<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Owner;

class OwnerType extends Model
{
    /** @use HasFactory<\Database\Factories\OwnerTypeFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function owners()
    {
        return $this->hasMany(Owner::class);
    }
}
