<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use Illuminate\Http\Request;

class AttributeController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:add-attribute')->only(['create', 'store']);
        $this->middleware('can:delete-attribute')->only(['destroy']);
        $this->middleware('can:show-attributes')->only(['index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attributes = Attribute::paginate(10);
        return view('admin.attributes.all', compact('attributes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.attributes.create');
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
            'name' => 'required',
        ]);

        $attribute = Attribute::create($data);

        return redirect()->back()->with('message', 'ویژه گی با موفقیت اضافه شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $attr = Attribute::find($id);
        $attr->delete();
        return redirect()->back()->with('message', 'ویژه گی با موفقیت پاک شد');
    }
}
