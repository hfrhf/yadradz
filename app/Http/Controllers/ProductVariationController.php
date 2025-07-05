<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\AttributeValue;
use App\Models\ProductVariation;
use App\Http\Requests\StoreProductVariationRequest;
use App\Http\Requests\UpdateProductVariationRequest;

class ProductVariationController extends Controller
{
    public function index()
    {
        $variations = ProductVariation::with(['product', 'attributeValues.attribute'])->get();

        return view('product_variations.index', compact('variations'));
    }

    public function create()
    {
        $products = Product::all();

        $attributeValues = AttributeValue::with('attribute')->get();
        return view('product_variations.create', compact('products', 'attributeValues'));
    }

    public function store(StoreProductVariationRequest $request)
    {
        $validated = $request->validated();

        $variation = ProductVariation::create([
            'product_id' => $validated['product_id'],
            'sku'        => $validated['sku'],
            'price'      => $validated['price'],
            'quantity'   => $validated['quantity'],
        ]);

        $variation->attributeValues()->attach($validated['attribute_values']);

        return redirect()->route('product-variations.index')->with('success', 'تم إنشاء توليفة المنتج بنجاح.');
    }

    public function edit(ProductVariation $productVariation)
    {
        $products = Product::all();
        $attributeValues = AttributeValue::with('attribute')->get();
        // تحميل قيم الخصائص المرتبطة مسبقًا لتجنب استعلام إضافي
        $productVariation->load('attributeValues');
        $selected = $productVariation->attributeValues->pluck('id')->toArray();

        return view('product_variations.edit', compact('productVariation', 'products', 'attributeValues', 'selected'));
    }

    public function update(UpdateProductVariationRequest $request, ProductVariation $productVariation)
    {
        $validated = $request->validated();

        $productVariation->update([
            'product_id' => $validated['product_id'],
            'sku'        => $validated['sku'],
            'price'      => $validated['price'],
            'quantity'   => $validated['quantity'],
        ]);

        $productVariation->attributeValues()->sync($validated['attribute_values']);

        return redirect()->route('product-variations.index')->with('success', 'تم تحديث توليفة المنتج بنجاح.');
    }

    public function destroy(ProductVariation $productVariation)
    {
        $productVariation->attributeValues()->detach();
        $productVariation->delete();
        return back()->with('success', 'تم حذف التوليفة');
    }
}
