<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

class Payment extends Model
{
    use HasFactory;

    protected $filable = ['resnumber', 'status'];

    public function orders(){
        return $this->belongsTo(Order::class);
    }
}
