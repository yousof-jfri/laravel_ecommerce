<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cart;

class PaymentController extends Controller
{
    public function payment()
    {
        $cartItem = Cart::all();

        if($cartItem->count()){
            // get the products total price
            $price = $cartItem->sum(function($cart){
                return $cart['product']->price * $cart['quantity'];
            });

            $orderItems = $cartItem->mapWithKeys(function($cart){
                return [$cart['product']->id => [
                    'quantity' => $cart['quantity']
                ]];
            });

            // register an order in the orders table
            $order = auth()->user()->orders()->create([
                'status' => 'unpaid',
                'price' => $price,
            ]);

            $order->products()->attach($orderItems);
            return 'ok';
        }

        return back()->with('message', 'سبد خرید شما خالی میباشد');
    }
}
