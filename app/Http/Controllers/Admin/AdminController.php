<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Product;

class AdminController extends Controller
{
    public function index(){
        if(Gate::allows('show-dashboard')){
            $users = User::all();
            $products = Product::all();
            $recievedOrders = Order::whereNot('status', ['unpaid', 'canceled'])->get();
            return view('admin.index', compact(['users', 'products', 'recievedOrders']));
        }

        return abort(403);
       
    }
}
