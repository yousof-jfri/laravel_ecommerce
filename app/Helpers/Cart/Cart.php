<?php

namespace App\Helpers\Cart;

use Illuminate\Support\Facades\Facade;

use Illuminate\Support\Collection;


/** 
 * @package App\Helpers\Cart
 * 
 * @method static bool has($id)
 * 
 * @method static array get($id)
 * 
 * @method static Collection all()
 * 
 * @method static Cart put(array $value, Model $obj = null)
 * */ 

class Cart extends Facade
{
    public static function getFacadeAccessor(){
        return 'cart';
    }
}