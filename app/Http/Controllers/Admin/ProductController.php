<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Attribute;
use App\Models\Product;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:add-product')->only(['create', 'store']);
        $this->middleware('can:edit-product')->only(['edit', 'update']);
        $this->middleware('can:delete-product')->only('destroy');
        $this->middleware('can:show-products')->only('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::query();

        $products = $products->paginate(10);

        return view('admin.products.all', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // return $request;
        $data = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'categories' => 'required',
            'inventory' => 'required',
            'image' => 'required',
            'attribute' => ['required', 'array'],
        ]);

        $data['slug'] = Str::slug($data['name']);

        $data['image'] = $request->file('image')->store('public/products');

        $product = $request->user()->products()->create($data);

        $attributes = collect($data['attribute']);

        $product->categories()->sync($data['categories']);

        $attributes->each(function ($attribute) use ($product) {
            if(!isset($attribute['value']) || !isset($attribute['name'])) return;
            
            $attribute['name'] = Attribute::find($attribute['name'])->name;

            $attr = Attribute::firstOrCreate([
                'name' => $attribute['name']
            ]);

            $attrValue = $attr->attributeValues()->firstOrCreate(['value' => $attribute['value']]);

            $product->attributes()->attach($attr->id, ['value_id' => $attrValue->id]);

        });

        return redirect()->back()->with('message', 'محصول با موفقیت ساخته شد');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Product $product)
    {
        $data = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'categories' => 'required',
            'inventory' => 'required',
            'image' => 'nullable',
            'attribute' => ['required', 'array'],
        ]);

        return $data;

        $data['slug'] = Str::slug($data['name']);

        $data['image'] = $product->image;

        if($request->file('image')){
            if(File::exists(public_path(Storage::url($product->image)))){
                File::delete(public_path(Storage::url($product->image)));
            }
            $data['image'] = $request->file('image')->store('public/products');
        }
        

        $data['updated_at'] = now();

        $product->update($data);

        $attributes = collect($data['attribute']);

        $product->attributes()->detach();

        $product->categories()->sync($data['categories']);

        $attributes->each(function ($attribute) use ($product) {
            if(!isset($attribute['value']) || !isset($attribute['name'])) return;
            
            $attribute['name'] = Attribute::find($attribute['name'])->name;

            $attr = Attribute::firstOrCreate([
                'name' => $attribute['name']
            ]);

            $attrValue = $attr->attributeValues()->firstOrCreate(['value' => $attribute['value']]);

            
            $product->attributes()->attach($attr->id, ['value_id' => $attrValue->id]);

        });

        return redirect()->route('admin.products.index')->with('message', 'محصول با موفقیت تغییر یافت');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if(File::exists(public_path(Storage::url($product->image)))){
            File::delete(public_path(Storage::url($product->image)));
        }
        $product->delete();
        return redirect()->route('admin.products.index')->with('message', 'محصول با موفقیت حذف شد');
    }
}
