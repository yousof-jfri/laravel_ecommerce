<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\AttrValue;

class Attribute extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function products(){
        return $this->belongsToMany(Product::class);
    }

    public function attributeValues(){
        return $this->hasMany(AttrValue::class);
    }
}
