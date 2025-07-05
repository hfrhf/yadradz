<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Traits\PermissionMiddlewareTrait;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use PermissionMiddlewareTrait;
    public function __construct()
    {

        $this->applyPermissionMiddleware('category'); // أو 'order' أو 'category' حسب الحاجة
    }
    public function index()
    {
        $categories=Category::query()->paginate(10);
        return view('category.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {


        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $form=$request->validate([
            'name'=>'required|min:3|max:15',
        ],[
            'name.required' => 'اسم القسم مطلوب.',
            'name.min' => 'اسم القسم لا يمكن أن يقل عن :min حرفاً.',
            'name.max' => 'اسم القسم لا يمكن أن يتجاوز :max حرفاً.',
        ]);
        Category::create($form);
        Cache::forget("categories_with_products");
        return to_route('category.index')->with('success','your category has added');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return view("category.show",compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('category.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $form=$request->validate([
            'name'=>'required|min:3|max:15',
        ],[
            'name.required' => 'اسم القسم مطلوب.',
            'name.min' => 'اسم القسم لا يمكن أن يقل عن :min حرفاً.',
            'name.max' => 'اسم القسم لا يمكن أن يتجاوز :max حرفاً.',
        ]);

        $category->fill($form)->save();
        Cache::forget("categories_with_products");
        return to_route('category.index')->with('success','your category has updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        Cache::forget("products_index");
        Cache::forget("top_selling_products");
        Cache::forget("categories_with_products");
        return to_route('category.index')->with('success','your product has deleted');
    }
}
