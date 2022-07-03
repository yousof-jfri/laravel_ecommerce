<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Discount;
use Illuminate\Validation\Rule;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $discounts = Discount::paginate(20);

        return view('admin.discounts.all', compact('discounts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.discounts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => ['required', 'unique:discounts,code'],
            'percent' => ['required', 'between:1,99'],
            'users' => ['nullable', 'array', 'exists:users,id'],
            'products' => ['nullable', 'array', 'exists:products,id'],
            'categories' => ['nullable', 'array', 'exists:categories,id'],
            'expired_at' => 'required',
        ]);

        // return $data;

        // add discount to the database
        $discount = Discount::create($data);

        // create products and discount
        $discount->products()->attach($data['products']);

        // create categories and discount
        $discount->categories()->attach($data['categories']);

        // create user and discount
        $discount->users()->attach($data['users']);

        return redirect()->back()->with('message', 'کد تخفیف به درستی ذخیره شد');
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
    public function edit(Discount $discount)
    {
        return view('admin.discounts.edit', compact('discount'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Discount $discount)
    {

        $data = $request->validate([
            'code' => ['required', Rule::unique('discounts', 'code')->ignore($discount->id)],
            'percent' => ['required', 'between:1,99'],
            'users' => ['nullable', 'array', 'exists:users,id'],
            'products' => ['nullable', 'array', 'exists:products,id'],
            'categories' => ['nullable', 'array', 'exists:categories,id'],
            'expired_at' => 'required',
        ]);

        // update discount
        $discount->update($data);

        // update products
        $discount->products()->sync($data['products']);

        // update categories
        $discount->categories()->sync($data['categories']);

        // update users
        $discount->users()->sync($data['users']);

        return redirect(route('admin.discounts.index'))->with('message', 'کد تخفیف با موفقیت تغییر یافت');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Discount $discount)
    {
        $discount->delete();
        return redirect()->back()->with('message', 'کد تخفیف با موفقیت حذف شد');
    }
}
