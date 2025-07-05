@props(['method', 'METHOD', 'product' => null, 'update', 'categories','allAttributes'])

@php
    $route = $update ? route('product.update', $product->id) : route('product.store');
@endphp

<div class="form">
    <!-- تضمين مكتبة Dropzone -->
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    @if ($errors->any())
        <div class="alert alert-danger">
            <h2 class="">الأخطاء:</h2>
            @foreach ($errors->all() as $error)
                <ul class="list-group">
                    <li class="">{{ $error }}</li>
                </ul>
            @endforeach
        </div>
    @endif

    <!-- الفورم الرئيسي -->
    <form id="product-form" action="{{ $route }}" method="{{ $method }}" enctype="multipart/form-data">
        @csrf
        @method($METHOD)

        <!-- اسم المنتج -->
        <div class="form-group">
            <label class="form-label" for="name">اسم المنتج:</label>
            <input class="form-control" type="text" name="name" value="{{ old('name', $product->name ?? '') }}">
        </div>

        <!-- وصف المنتج -->
        <div class="form-group">
            <label class="form-label">وصف المنتج:</label>
            <div id="editor" class="form-control">
                {!! old('description', $product->description ?? '') !!}
            </div>
            <input type="hidden" name="description" id="description">
        </div>
        <div class="form-group mb-3">
            <label for="is_active" class="form-label">نشط؟</label>
            <input
                type="checkbox"
                id="is_active"
                name="is_active"
                value="1"
                {{ old('is_active', $product->is_active) ? 'checked' : '' }}
            >
        </div>


        <!-- سعر المنتج -->
        <div class="form-group">
            <label class="form-label">سعر المنتج:</label>
            <input class="form-control" type="number" value="{{ old('price', $product->price ?? '')}}" name="price">
        </div>
        <!-- سعر المنتج -->
        <div class="form-group">
            <label class="form-label"> الكمية المتاحة :</label>
            <input class="form-control" type="number" value="{{ old('quantity', $product->quantity ?? '')}}" name="quantity">
        </div>
        <div class="form-group">
            <label class="form-label">سعر المقارنة:</label>
            <input class="form-control" type="number" value="{{ old('compare_price', $product->compare_price ?? '')}}" name="compare_price">
        </div>
        <div class="form-group">
            <label class="form-label d-block">التوصيل :</label>
            <div class="d-block mb-2">
                <label for="free_shipping_office">التوصيل الى المكتب</label>
            <input class="" type="checkbox" value="1" name="free_shipping_office"  {{ old('free_shipping_office', $product->free_shipping_office ?? false) ? 'checked' : '' }}>
            </div>
            <div class="d-block">
                <label for="free_shipping_home">التوصيل الى المنزل</label>
            <input class="" type="checkbox" value="1" name="free_shipping_home" {{old('free_shipping_home',$product->free_shipping_home ?? false) ?'checked' : ''}}>
            </div>
        </div>


        <!-- اختيار الفئة -->
       <div class="form-group">
        <label class="form-label">القسم:</label>
        <select class="form-control mb-3" name="category_id" id="">
            <option value="" disabled>اختر الفئة</option>
            @foreach ($categories as $category)
                @php
                    $selected = $update
                        ? old('category_id', $product->category_id) === $category->id
                        : old('category_id') === $category->id;
                @endphp
                <option @selected($selected) value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
       </div>
       <div class="form-group">
        <label>اختر الخصائص المناسبة لهذا المنتج:</label>
        @foreach ($allAttributes as $attribute)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="attributes[]"
                       value="{{ $attribute->id }}"
                       {{ isset($product) && $product->attributes->contains($attribute->id) ? 'checked' : '' }}>
                <label class="form-check-label">{{ $attribute->name }}</label>
            </div>
        @endforeach


       </div>


        <!-- عرض الصورة الحالية إن وجدت -->
        <div class="form-group  file-images-upload">
            <label for="fileImage" class="label-image">رفع الصورة</label>
            <span class="file-name" id="file-name">لم يتم اختيار ملف</span>
            <input class="form-control" id="fileImage" type="file" name="image" style="display: none;">
        </div>
            @isset($product)
            <div class="mt-3 image-preview-container">
                <img class="image-preview" src="{{ asset('storage/'.$product->image) }}" alt="Product Image">
            </div>

        @endisset



        <div class="form-group file-images-upload my-3">
            <label for="images" class="label-images">رفع الصور</label>
            <span class="file-name" id="file-length">لم يتم اختيار ملف</span>
            <input class="form-control " id="images" type="file" name="images[]" multiple>
        </div>
        @isset($product->images)
        <div id="images-preview-container" class="images-preview-container mb-3">
            @foreach ($product->images as $image)
            <div class="images-preview-cont">
                <img class="" src="{{ asset('storage/'.$image->image_path) }}" alt="Product Image">
            </div>
            @endforeach
        </div>
        @endisset




        <button class="btn btn-create mt-4">
            {{$update ? 'تعديل' : 'ارسال'}}
        </button>

    </form>
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script>

        document.querySelector('form').onsubmit = function() {
    document.querySelector('#description').value = quill.root.innerHTML;
};


        var quill = new Quill('#editor', {
        theme: 'snow',
        placeholder: 'اكتب وصف المنتج هنا...',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, false] }],
                ['bold', 'italic', 'underline'],
                ['link', 'blockquote'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'direction': 'rtl' }],  // دعم الكتابة من اليمين إلى اليسار
            ]
        }
    });

            // الحصول على مراجع العناصر
            const fileInput = document.getElementById('fileImage');
        const fileNameDisplay = document.getElementById('file-name');
        const label = document.querySelector('.label-image');



        fileInput.addEventListener('change', function() {
            if (this.files && this.files.length > 0) {
                fileNameDisplay.textContent = this.files[0].name;
            } else {
                fileNameDisplay.textContent = 'لم يتم اختيار ملف';
            }
        });



          // الحصول على مراجع العناصر
          const fileInputs = document.getElementById('images');
        const fileLength = document.getElementById('file-length');
        const labelImages = document.querySelector('.label-images');



        fileInputs.addEventListener('change', function() {
            if (this.files && this.files.length > 0) {
                fileLength.textContent = `${this.files.length } صور`;
            } else {
                fileLength.textContent = 'لم يتم اختيار ملف';
            }
        });
    </script>
</div>
