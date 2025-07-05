<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Models\AttributeValue;
use App\Http\Requests\StoreAttributeValueRequest;
use App\Http\Requests\UpdateAttributeValueRequest;

class AttributeValueController extends Controller
{
    public function index()
    {
        $values = AttributeValue::with('attribute')->get();
        return view('attribute_values.index', compact('values'));
    }

    public function create()
    {
        $attributes = Attribute::all();
        return view('attribute_values.create', compact('attributes'));
    }

    public function store(StoreAttributeValueRequest $request)
    {
        // تم التحقق من صحة الطلب تلقائيًا
        AttributeValue::create($request->validated());
        return redirect()->route('attribute-values.index')->with('success', 'تمت إضافة القيمة بنجاح.');
    }

    public function edit(AttributeValue $attributeValue)
    {
        $attributes = Attribute::all();
        return view('attribute_values.edit', compact('attributeValue', 'attributes'));
    }

    public function update(UpdateAttributeValueRequest $request, AttributeValue $attributeValue)
    {
        // تم التحقق من صحة الطلب تلقائيًا
        $attributeValue->update($request->validated());
        return redirect()->route('attribute-values.index')->with('success', 'تم تحديث القيمة بنجاح.');
    }

    public function destroy(AttributeValue $attributeValue)
    {
        $attributeValue->delete();
        return back()->with('success', 'تم الحذف');
    }
}
