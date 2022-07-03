<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Attribute;

class AttrValue extends Model
{
    use HasFactory;

    protected $table = 'attr_value';

    protected $fillable = ['value', 'attribute_id'];

    public function attribute(){
        return $this->belongsTo(Attribute::class);
    }
}
