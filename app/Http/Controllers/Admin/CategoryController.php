<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:add-category')->only(['create', 'store', 'addChild']);
        $this->middleware('can:edit-category')->only(['edit', 'update']);
        $this->middleware('can:delete-category')->only('destroy');
        $this->middleware('can:show-categories')->only('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::query();

        $categories = $categories->where('parent_id', 0)->paginate(10);

        return view('admin.categories.all', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categories.create');
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
            'parent_id' => 'nullable'
        ]);


        $data['slug'] = Str::slug($data['name']);

        if(!! !$request->parent_id){
            $data['parent_id'] = 0;
        }   

        $category = Category::create($data);
        return redirect()->back()->with('message', 'دسته یندی با موفیت ساخته شد');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {   
        // 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => 'required',
            'parent_id' => ['nullable']
        ]);


        // return $request;
        $data['updated_at'] = now();

        $data['slug'] = Str::slug($data['name']);

        if(!! !$request->parent_id){
            $data['parent_id'] = 0;
        }   

        $category->update($data);

        return redirect()->route('admin.categories.index')->with('message', 'دسته یندی با موفیت تغییر یافت');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $subCategory = $category->childs()->pluck('id');


        if(count($subCategory) > 0){
            // delete subCategories
            Category::whereIn('id', $subCategory)->get();
        }

        // delete the category
        $category->delete();

        return redirect()->route('admin.categories.index')->with('message', 'دسته بندی با موفیت حذف شد');        
    }

    
    public function addChild(Category $category){

        return view('admin.categories.createChild', compact('category'));
    }

}
