<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::query();


        if($key = request('status')){
            $orders->whereStatus($key)->get();
        }

        $orders = $orders->paginate(10);

        return view('admin.orders.all', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {

        return view('admin.orders.details', compact('order'));
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        return view('admin.orders.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(['unpaid', 'paid', 'recieved', 'posted', 'canceled', 'preparation'])],
            'tracking-serial' => ['required']
        ]);

        $order->update([
            'status' => $data['status'],
            'tracking_serial' => $data['tracking-serial'],
        ]);

        return redirect(route('admin.orders.index'))->with('message', 'سفارش با موفقیت تغییر یافت');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect(route('admin.orders.index'))->with('message', 'سفارش با موفقیت حذف شد');
    }

    public function pay(Order $order){
        $order->status = 'paid';
        $order->update();

        return redirect()->back()->with('message', 'سفارش با موفقیت پرداخت شد ، بعد از چند روز محصول به دست شما میرسد');
    }
}
