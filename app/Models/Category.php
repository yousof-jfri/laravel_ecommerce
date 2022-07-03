<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Discount;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'parent_id', 'slug'];

    public function childs(){
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function parent(){
        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }

    public function descounts()
    {
        return $this->belongsToMany(Discount::class);
    }
}
