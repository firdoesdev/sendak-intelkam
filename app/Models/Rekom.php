<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;
use App\Models\Owner;
use App\Models\RekomType;

use App\Services\RekomServices\CommonRekomService;

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
           
            $model->role_id = $rekom->getRekomRoleId();   // Set Rekom Division berdasarkan user login
            
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
