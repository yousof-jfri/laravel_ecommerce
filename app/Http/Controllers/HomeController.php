<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Comment;
use Illuminate\Support\Arr;
use Ramsey\Uuid\Converter\NumberConverterInterface;

use function GuzzleHttp\Promise\each;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products = Product::query();

        $products = $products->inRandomOrder()->latest()->limit(8)->get();

        return view('index', compact(['products']));
    }

    public function productDetails(Product $product){

        $product->views += 1;
        $product->update();        

        $attributes = [];
        $categoryId = [];
        $similarProduct = [];


        foreach($product->attributes as $attr){
            $attrValue = [];

            foreach($attr->attributeValues as $value){
                array_push($attrValue, $value->value);
            }

            $attributes[$attr->name] = [
                'name' => $attr->name,
                'value' =>  $attrValue,
            ];

        }

        foreach($product->categories as $category){
            array_push($categoryId, $category->id);
        }

        $allProduct = Product::all();

        foreach($allProduct as $productItem){
            foreach($productItem->categories as $cate){
                if(in_array($cate->id, $categoryId)){
                    array_push($similarProduct, $productItem);
                }
            }
        }

        $similarProduct = array_unique($similarProduct);

        $attributes = collect($attributes);
        return view('frontend.productDetails', compact(['product', 'similarProduct', 'attributes']));
    }

    public function newComment(Request $request){

        $data = [
            'parent_id' => $request->parent_id,
            'product_id' => $request->product_id,
            'comment' => $request->comment,
        ];

        if(!isset($request->parent_id)){
            $data['parent_id'] = 0;
        }

        $request->user()->comments()->create($data);

        return redirect()->back()->with('message', 'نظر با موفقیت ارسال شد، لطفا منتظر تایید شدن باشید');
    }

    public function shoppingCart(){
        return view('frontend.shoppingBasket');
    }

    public function AllProducts(){
        $products = Product::query();

        // search
        if($key = request('search')){
            $products->where('name', 'LIKE', "%{$key}%")->orWhere('slug', 'LIKE', "%{$key}%")->orWhereHas('categories', function($query) use ($key) {
                $query->where('name', 'LIKE', "%{$key}%");
            })->get();
        }
      
        // return the products which has the selected category
        if(isset(request('data')['category'])){
            $key = request('data')['category'];
            $products->whereHas('categories', function ($query) use ($key) {
                $query->whereIn('name', $key);
            })->get();
        }

        // return the price between the high price and low price
        if(isset(request('data')['highPrice']) || isset(request('data')['lowPrice'])){
            $higtPrice = request('data')['highPrice'];
            $lowPrice = request('data')['lowPrice'];
            $products->whereBetween('price', [(int)$lowPrice, (int)$higtPrice])->get();
        }



        $products = $products->inRandomOrder()->paginate(20);

        return view('frontend.allProducts', compact('products'));
    }



}
