<?php

namespace App\Http\Controllers;

use App\Helpers\Cart\Cart;

use Illuminate\Http\Request;

use App\Models\Product;

class CartController extends Controller
{

    // add to cart
    public function addToCart(Product $product){
        if(Cart::has($product)){
            Cart::update($product, 1);
        }else{
            Cart::put(
                [
                    'quantity' => 1,
                    'price' => $product->price,
                ],
                $product
            );
        }
        return redirect()->back()->with('message', 'محصول با موفقیت به سبد خرید اضافه شد');
    }


    // add new quantity
    public function updateCard($quantity, $id){
        $data = [
            'quantity' => $quantity,
            'id' => $id,
        ];


        if(Cart::has($data['id'])){
            $product = Cart::get($data['id'])['product'];
            if($product->inventory >= $data['quantity']){
                Cart::update($data['id'], [
                    'quantity' => $data['quantity'],
                ]);
                return response(['status' => 'success']);
            }   

        }
        return response(['status' => 'error'], 404);
    }

    public function deleteCart($id){
        Cart::delete($id);

        return response(['status' => 'success']);
    }

}