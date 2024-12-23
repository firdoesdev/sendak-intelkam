<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Spatie\Permission\Models\Role;
use App\Models\Owner;
use App\Models\RekomType;
use Illuminate\Database\Eloquent\Casts\Attribute;

use App\Services\RekomServices\CommonRekomService;

use TomatoPHP\FilamentDocs\Facades\FilamentDocs;
use TomatoPHP\FilamentDocs\Services\Contracts\DocsVar;

class Rekom extends Model
{
    /** @use HasFactory<\Database\Factories\RekomFactory> */
    use HasFactory;

    private $getRoleIdByUser;

    

    protected $fillable = [
        'no_rekom',
        'activated_at',
        'expired_at',  
        'status',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $rekom = new CommonRekomService();
           
            // Set Rekom Division berdasarkan user login
            $model->role_id = $rekom->getRekomRoleId();   
            
        });

        FilamentDocs::register([
            DocsVar::make('$OWNER_NAME')
                ->label('Owner')
                ->model(Owner::class)
                ->column('Pemilik'),
           
        ]);
        
    }

    public function role(){
        return $this->belongsTo(Role::class);
    }

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

    public function rekomType(){
        return $this->belongsTo(RekomType::class);
    }

    public function explosives(): HasMany
    {
        return $this->hasMany(Weapon::class);
    }
}
