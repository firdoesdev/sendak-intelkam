<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OwnerType;
use App\Models\Weapon;
use App\Models\Rekom;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Services\RekomServices\CommonRekomService;
use App\Enums\RoleEnum;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Observers\OwnerObserver;

#[ObservedBy([OwnerObserver::class])]
class Owner extends Model
{
    /** @use HasFactory<\Database\Factories\OwnerFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'no_ktp',
        'gender',
        'address',
        'phone',
        'job',
        'file_ktp',
        'file_npwp',
        'file_ksk',
        'file_skep_jabatan',
        'file_kta',
        'file_surat_ijin_impor',
        'file_tes_kesehatan',
        'file_tes_psikologi',
        'file_tes_menembak',
        'parent_id',
        'owner_type_id'
    ];

    // //TODO Create Default Owner Type 
    // protected static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($model) {
    //         $rekom = new CommonRekomService();

    //         // Set default Owner Type except polsus
    //         if (!auth()->user()->hasRole(RoleEnum::POLSUS->value())) {
    //             $model->owner_type_id = $rekom->getOwnerTypeIdByRole();   // Set default Owner Type if not Polsus
    //         }
    //     });
    // }

    public function ownerType()
    {
        return $this->belongsTo(OwnerType::class);
    }

    public function weapons()
    {
        return $this->belongsToMany(Weapon::class, 'owner_weapons')->withPivot(
            'status',
            'description',
            'assigned_at',
            'previous_owner_id'
        );
    }

    public function rekoms(): HasMany
    {
        return $this->hasMany(Rekom::class);
    }

    public function members(): HasMany
    {
        return $this->hasMany(self::class,'parent_id');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(self::class,'parent_id');
    }
}
