<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OwnerType;
use App\Models\Weapon;
use App\Models\Rekom;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Services\RekomServices\CommonRekomService;
use App\Enums\RoleEnum;

class Owner extends Model
{
    /** @use HasFactory<\Database\Factories\OwnerFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'no_ktp',
        'address',
        'phone'
    ];

    //TODO Create Default Owner Type 
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $rekom = new CommonRekomService();
            if (!auth()->user()->hasRole(RoleEnum::POLSUS->value())) {
                $model->owner_type_id = $rekom->getOwnerTypeIdByRole();   // Set default Owner Type if not Polsus
            }
        });
    }

    public function ownerType()
    {
        return $this->belongsTo(OwnerType::class);
    }

    public function weapons()
    {
        return $this->belongsToMany(Weapon::class, 'owner_weapons');
    }

    public function rekoms(): HasMany
    {
        return $this->hasMany(Rekom::class);
    }
}
