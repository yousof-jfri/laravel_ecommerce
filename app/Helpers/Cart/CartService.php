<?php


namespace App\Helpers\Cart;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class CartService
{

    public $cart;

    public function __construct(){
        $this->cart = session()->get('cart') ?? collect([]);
    }


    // add product into the cart
    public function put(array $value, $obj = null)
    {

        if(!is_null($obj) && $obj instanceof Model){

            $value = array_merge($value, [
                'id' => Str::random(10),
                'subject_id' => $obj->id,
                'subject_type' => get_class($obj),
            ]);   
            
        }elseif(!isset($value['id'])){

            $value = array_merge($item, [
                'id' => Str::random(10),
            ]);

        }

        $this->cart->put($value['id'] , $value);

        session()->put('cart', $this->cart);

        return $this;
    }

    // check if the product has already been added or not
    public function has($key)
    {
        if($key instanceof Model){
            return ! is_null(
                $this->cart->where('subject_id', $key->id)->where('subject_type', get_class($key))->first()
            );
        }

        return ! is_null(
            $this->cart->firstWhere('id', $key)
        );
    }   

    // get all the products from the basket
    public function get($key, $withRelationship = true){
        $item = $key instanceof Model 
            ? $this->cart->where('subject_id', $key->id)->where('subject_type', get_class($key))->first() 
            : $this->cart->firstWhere('id', $key);

        return $withRelationship ? $this->withRelationshipIfExists($item) : $item;
    }

    // get all the 
    public function all(){
        $cart = $this->cart;

        $cart = $cart->map(function($item) {
            return $this->withRelationshipIfExists($item);
        });

        return $cart;
    }


    // make relation ship between cart items and products basket
    protected function withRelationshipIfExists($item){
        if(isset($item['subject_id']) && isset($item['subject_type'])){
            $class = $item['subject_type'];

            $subject = (new $class())->find($item['subject_id']);
            
            $item[strtolower(class_basename($class))] = $subject;

            unset($item['subject_id']);
            unset($item['subject_type']);

            return $item;
        }

        return $item;
    }


    // update cart
    public function update($key, $options){
        $item = collect($this->get($key, false));

        if(is_array($options)){
            $item = $item->merge($options);
        }

        if(is_numeric($options)){
            $item = $item->merge([
                'quantity' => $item['quantity'] + $options,
            ]);
        }

        $this->put($item->toArray());

        return $this;
    }

    
    public function count($key){
        if(! $this->has($key)) return 0;

        return $this->get($key)['quantity'];
    }

    public function delete($key){
        if(!is_null($this->cart->firstWhere('subject_id', $key))){
            $this->cart = $this->cart->filter(function ($item) use ($key) {

                if($key instanceof Model){
                    return ($item['subject_id'] != $key->id) && ($item['subject_type'] != get_class($key) );
                }

                return $key != $item['subject_id'];
            });

            session()->put('cart', $this->cart);

            return true;
        }

        

        return false;
    }
}