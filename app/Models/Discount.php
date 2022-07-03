<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'percent', 'expired_at'];

    public $timestamps = false;

    public function products(){
        return $this->belongsToMany(Product::class);
    }

    public function categories(){
        return $this->belongsToMany(Category::class);
    }

    public function users(){
        return $this->belongsToMany(User::class);
    }
}
