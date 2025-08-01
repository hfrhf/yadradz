@extends('dashboard.dashboard')

@section('title', 'إضافة توليفة جديدة')

@include('dashboard.sidebar')

@section('content')

<div class="container-fluid px-3 px-md-4">
    <div class="card card-custom">
        <div class="card-header">
            <h4 class="card-title">إضافة توليفة جديدة</h4>
        </div>
        <div class="card-body p-4">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('product-variations.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="product_id" class="form-label">المنتج:</label>
                    <select name="product_id" id="product_id" class="form_control_custom" required>
                        <option value="" disabled selected>-- اختر المنتج --</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label" for="sku">SKU (رمز التخزين التعريفي):</label>
                            <input class="form_control_custom" type="text" id="sku" name="sku" value="{{ old('sku') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label" for="price">السعر:</label>
                            <input class="form_control_custom" type="number" step="0.01" id="price" name="price" value="{{ old('price') }}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                         <div class="mb-3">
                            <label class="form-label" for="quantity">الكمية:</label>
                            <input class="form_control_custom" type="number" id="quantity" name="quantity" value="{{ old('quantity') }}" required>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">قيم السمات:</label>
                    <div class="p-3 border rounded-3" style="background-color: #f8f9fa;">
                        <div class="row">
                            @foreach ($attributeValues as $val)
                                <div class="col-md-4 col-sm-6">
                                    <div class="form-check form-check-custom">
                                        <input class="form-check-input" type="checkbox" name="attribute_values[]" value="{{ $val->id }}" id="attr_val_{{ $val->id }}"
                                        {{ (is_array(old('attribute_values')) && in_array($val->id, old('attribute_values'))) ? 'checked' : '' }}>

                                        <label class="form-check-label" for="attr_val_{{ $val->id }}">
                                            <div class="d-flex align-items-center">
                                                <span>{{ $val->attribute->localized_name }}:&nbsp;</span>
                                                @if ($val->attribute->name === 'اللون')
                                                    <span style="display: inline-block; width: 20px; height: 20px; border-radius: 4px; background-color: {{ $val->value }}; border: 1px solid #dee2e6; margin-right: 8px;"></span>
                                                    <span style="font-family: monospace;">{{ $val->value }}</span>
                                                @else
                                                    <span>{{ $val->value }}</span>
                                                @endif
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-lg" style="background-color: #6f42c1; color: white; font-weight: bold;">
                        إنشاء التوليفة
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection