<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Product;
use App\Models\Comment;
use App\Models\Role;
use App\Models\Permission;
use App\Models\ActiveCode;
use App\Models\Order;
use App\Models\Discount;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'image',
        'is_staff',
        'is_superuser',
        'phone',
        'address',
        'bio',
        'two_factor_auth_type'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function products(){
        return $this->hasMany(Product::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function permissions(){
        return $this->belongsToMany(Permission::class);
    }

    public function roles(){
        return $this->belongsToMany(Role::class);
    }

    // check if the user has this permission or not
    public function hasPermission($permission){
        
        return $this->permissions->contains('name', $permission->name) || $this->hasRole($permission->roles);
    }

    public function hasRole($role){
        return !! $role->intersect($this->roles)->all();
    }

    public function activeCodes(){
        return $this->hasMany(ActiveCode::class);
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }

    public function discounts()
    {
        return $this->belongsToMany(Discount::class);
    }
}
