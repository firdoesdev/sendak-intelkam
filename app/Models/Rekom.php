<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;
use App\Models\Owner;
use App\Models\RekomType;

use App\Enums\RoleEnum;

class Rekom extends Model
{
    /** @use HasFactory<\Database\Factories\RekomFactory> */
    use HasFactory;



    protected $fillable = [
        'no_rekom',
        'activated_at',
        'expired_at',  
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
           
            $user = auth()->user();
            

            // Set role_id berdasarkan role yang dimiliki pengguna
            if($user->hasRole(RoleEnum::BELADIRI->value())){                
                $model->role_id = Role::where('name', RoleEnum::BELADIRI->value())->first()->id;
            }
    
            if($user->hasRole(RoleEnum::HANDAK->value())){                
                $model->role_id = Role::where('name', RoleEnum::HANDAK->value())->first()->id;
            }
    
            if($user->hasRole(RoleEnum::POLSUS->value())){                
                $model->role_id = Role::where('name', RoleEnum::POLSUS->value())->first()->id;
            }
    
            if($user->hasRole(RoleEnum::OLAHRAGA->value())){                
                $model->role_id = Role::where('name', RoleEnum::OLAHRAGA->value())->first()->id;
            }

            $model->activated_at = now(); // Set nilai saat model dibuat
            //Expired setelah 1 tahun
            $model->expired_at = now()->addYear();
        });
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
}
