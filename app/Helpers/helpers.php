<?php

use Illuminate\Support\Facades\Route;

if(! function_exists('isActive')){
    function isActive ($key, $class = 'active'){
        if(is_array($key)){
            return in_array(Route::currentRouteName(), $key) ? $class : '';
        }

        return Route::currentRouteName() == $key ? $class : '';
    }  
}


if(! function_exists('isOpen')){
    function isOpen ($key, $class = 'display:block'){
        if(is_array($key)){
            return in_array(Route::currentRouteName(), $key) ? $class : '';
        }

        return Route::currentRouteName() == $key ? $class : '';
    }  
}

if(! function_exists('unCompleteProfile')){
    function unCompleteProfile($user){
        if($user->phone == null || $user->address == null || $user->bio == null || $user->image == null){
            return false;
        }
        return true;
    }
}

if(! function_exists('isUrl')){
    function isUrl($url, $activeClass = 'active'){
        return \request()->fullUrlIs($url) ? $activeClass : '';
    }
}