<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\User;
use App\Models\Comment;
use App\Models\Order;
use App\Models\Discount;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'price', 'inventory', 'image', 'views'];

    public function attributes(){
        return $this->belongsToMany(Attribute::class)->withPivot(['value_id']);
    }

    public function categories(){
        return $this->belongsToMany(Category::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }

    public function discounts()
    {
        return $this->belongsToMany(Discount::class);
    }
}
