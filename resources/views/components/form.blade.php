@props(['method', 'METHOD', 'product' => null, 'update', 'categories','allAttributes'])

@php
    $route = $update ? route('product.update', $product->id) : route('product.store');
@endphp

{{--
    ملاحظة: يفضل نقل هذه المكتبات إلى ملف الـ layout الرئيسي
    باستخدام @push('styles') و @push('scripts') لضمان تحميلها مرة واحدة فقط.
--}}

    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>



{{-- Custom Styles for this component --}}
<style>
    /* Loading Overlay Styles */
    .loading-overlay {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background-color: rgba(0, 0, 0, 0.6); z-index: 9999;
        display: none; justify-content: center; align-items: center;
    }
    .loading-box {
        background-color: white; padding: 40px 60px; border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.2); text-align: center;
        display: flex; flex-direction: column; align-items: center; gap: 20px;
    }
    .loading-box p { margin: 0; font-size: 1.2rem; font-weight: 500; color: #333; }
    .spinner {
        width: 60px; height: 60px; border: 7px solid #f3f3f3;
        border-top: 7px solid #6f42c1; border-radius: 50%;
        animation: spin 1.2s linear infinite;
    }
    @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }

    /* Quill Editor Styling */
    .ql-toolbar.ql-snow {
        border-top-left-radius: .375rem;
        border-top-right-radius: .375rem;
        border-color: #ced4da;
    }
    .ql-container.ql-snow {
        border-bottom-left-radius: .375rem;
        border-bottom-right-radius: .375rem;
        border-color: #ced4da;
        min-height: 150px;
    }

    /* Image Preview Styling */
    .images-preview-container { display: flex; flex-wrap: wrap; gap: 1rem; margin-top: 1rem; }
    .images-preview-item { position: relative; }
    .images-preview-item img {
        width: 100px; height: 100px; object-fit: cover;
        border-radius: .375rem; border: 1px solid #dee2e6;
    }
    .custom-file-upload {
        border: 2px dashed #6f42c1;
        border-radius: .375rem;
        padding: 1rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        background-color: #f8f9fa;
        text-align: center;
        transition: background-color .15s ease-in-out, border-color .15s ease-in-out;
    }
    .custom-file-upload:hover {
        background-color: #f1eef7;
        border-color: #5a359a;
    }
    .custom-file-upload .file-upload-label {
        font-weight: bold;
        color: #6f42c1;
    }
    .custom-file-upload .file-name {
        font-size: 0.875rem;
        color: #6c757d;
        margin-top: 0.5rem;
    }
    .image-preview-container {
        margin-top: 1rem;
        text-align: center;
    }
    .image-preview {
        max-width: 200px;
        max-height: 150px;
        border-radius: .375rem;
        border: 1px solid #dee2e6;
        padding: 0.25rem;
    }
</style>

<!-- Loading Screen -->
<div id="loading-overlay" class="loading-overlay">
    <div class="loading-box">
        <div class="spinner"></div>
        <p>جارٍ المعالجة... يرجى الانتظار</p>
    </div>
</div>

<div class="container-fluid px-3 px-md-4">
    <div class="card card-custom">
        <div class="card-header">
            <h4 class="card-title">{{ $update ? 'تعديل المنتج' : 'إضافة منتج جديد' }}</h4>
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

            <form id="product-form" action="{{ $route }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method($METHOD)

                <div class="row">
                    <!-- Product Name -->
                    <div class="col-12">
                        <div class="mb-3">
                            <label class="form-label" for="name">اسم المنتج:</label>
                            <input class="form_control_custom" type="text" id="name" name="name" value="{{ old('name', $product->name ?? '') }}">
                        </div>
                    </div>

                    <!-- Product Description -->
                    <div class="col-12">
                        <div class="mb-3">
                            <label class="form-label">وصف المنتج:</label>
                            <div id="editor">{!! old('description', $product->description ?? '') !!}</div>
                            <input type="hidden" name="description" id="description">
                        </div>
                    </div>

                    <!-- Price and Quantity -->
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label" for="price">سعر المنتج:</label>
                            <input class="form_control_custom" type="number" id="price" value="{{ old('price', $product->price ?? '')}}" name="price">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label" for="quantity">الكمية المتاحة:</label>
                            <input class="form_control_custom" type="number" id="quantity" value="{{ old('quantity', $product->quantity ?? '')}}" name="quantity">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label" for="compare_price">سعر المقارنة (اختياري):</label>
                            <input class="form_control_custom" type="number" id="compare_price" value="{{ old('compare_price', $product->compare_price ?? '')}}" name="compare_price">
                        </div>
                    </div>

                    <!-- Category -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="category_id">القسم:</label>
                            <select class="form_control_custom" name="category_id" id="category_id">
                                <option value="" disabled selected>اختر الفئة</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id ?? '') == $category->id)>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Status and Shipping Options -->
                    <div class="col-md-6 d-flex align-items-center">
                        <div class="d-flex gap-4">
                             <div class="form-check form-check-custom">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', optional($product)->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">نشط</label>
                            </div>
                            <div class="form-check form-check-custom">
                                <input class="form-check-input" type="checkbox" value="1" id="free_shipping_office" name="free_shipping_office" {{ old('free_shipping_office', $product->free_shipping_office ?? false) ? 'checked' : '' }}>
                                <label class="form-check-label" for="free_shipping_office">توصيل للمكتب</label>
                            </div>
                            <div class="form-check form-check-custom">
                                <input class="form-check-input" type="checkbox" value="1" id="free_shipping_home" name="free_shipping_home" {{ old('free_shipping_home', $product->free_shipping_home ?? false) ? 'checked' : '' }}>
                                <label class="form-check-label" for="free_shipping_home">توصيل للمنزل</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-12"><hr class="my-4"></div>

                    <!-- Attributes -->
                    <div class="col-12">
                        <div class="mb-4">
                            <label class="form-label">الخصائص (اختياري):</label>
                            <div class="p-3 border rounded-3" style="background-color: #f8f9fa;">
                                <div class="row">
                                    @foreach ($allAttributes as $attribute)
                                        <div class="col-md-4 col-sm-6">
                                            <div class="form-check form-check-custom">
                                                <input class="form-check-input" type="checkbox" name="attributes[]" value="{{ $attribute->id }}" id="attr_{{ $attribute->id }}"
                                                    {{ (isset($product) && $product->attributes->contains($attribute->id)) || (is_array(old('attributes')) && in_array($attribute->id, old('attributes'))) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="attr_{{ $attribute->id }}">{{ $attribute->name }}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Main Image Upload -->
                    <div class="col-md-6">
                        <label class="form-label">الصورة الرئيسية للمنتج:</label>
                        <label for="mainImage" class="custom-file-upload">
                            <span class="file-upload-label">اختر صورة</span>
                            <span class="file-name" id="file-name-main">لم يتم اختيار ملف</span>
                        </label>
                        <input id="mainImage" class="d-none" type="file" name="image">
                        @isset($product->image)
                        <div class="image-preview-container">
                            <img class="image-preview" src="{{ asset('storage/'.$product->image) }}" alt="Main Image Preview">
                        </div>
                        @endisset
                    </div>

                    <!-- Additional Images Upload -->
                    <div class="col-md-6">
                        <label class="form-label">صور إضافية للمنتج:</label>
                        <label for="additionalImages" class="custom-file-upload">
                            <span class="file-upload-label">اختر صور</span>
                            <span class="file-name" id="file-name-additional">لم يتم اختيار ملفات</span>
                        </label>
                        <input id="additionalImages" class="d-none" type="file" name="images[]" multiple>
                        @isset($product->images)
                        <div class="images-preview-container">
                            @foreach ($product->images as $image)
                                <div class="images-preview-item">
                                    <img src="{{ asset('storage/'.$image->image_path) }}" alt="Product Image">
                                </div>
                            @endforeach
                        </div>
                        @endisset
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-lg" style="background-color: #6f42c1; color: white; font-weight: bold;">
                        {{ $update ? 'حفظ التعديلات' : 'إنشاء المنتج' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    // Initialize Quill Editor
    var quill = new Quill('#editor', {
        theme: 'snow',
        placeholder: 'اكتب وصف المنتج هنا...',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, false] }], ['bold', 'italic', 'underline'],
                ['link', 'blockquote'], [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'align': [] }], [{ 'direction': 'rtl' }], ['clean']
            ]
        }
    });

    const productForm = document.getElementById('product-form');
    const loadingOverlay = document.getElementById('loading-overlay');

    // Handle form submission
    productForm.addEventListener('submit', function() {
        // Copy Quill content to hidden input
        document.querySelector('#description').value = quill.root.innerHTML;
        // Show loading overlay
        if(loadingOverlay) {
            loadingOverlay.style.display = 'flex';
        }
    });

    // Function to handle file input text display
    function setupFileInput(inputId, spanId, isMultiple = false) {
        const input = document.getElementById(inputId);
        const fileNameSpan = document.getElementById(spanId);
        if (input) {
            input.addEventListener('change', function() {
                if (this.files && this.files.length > 0) {
                    if (isMultiple) {
                        fileNameSpan.textContent = `${this.files.length} ملفات تم اختيارها`;
                    } else {
                        fileNameSpan.textContent = this.files[0].name;
                    }
                } else {
                    fileNameSpan.textContent = isMultiple ? 'لم يتم اختيار ملفات' : 'لم يتم اختيار ملف';
                }
            });
        }
    }

    setupFileInput('mainImage', 'file-name-main');
    setupFileInput('additionalImages', 'file-name-additional', true);
});
</script>
