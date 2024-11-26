<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Owner;
use Illuminate\Database\Eloquent\Casts\Attribute;

class OwnerType extends Model
{
    /** @use HasFactory<\Database\Factories\OwnerTypeFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    protected function name(): attribute
    {
        return Attribute::make(
            get: fn (string $value) => ucfirst($value),
            set: fn (string $value) => strtolower($value),
        );
    }

    public function owners()
    {
        return $this->hasMany(Owner::class);
    }
}
