@extends('dashboard.dashboard')

@section('title', 'إضافة قيمة جديدة')

@include('dashboard.sidebar')

@section('content')

<div class="container-fluid px-3 px-md-4">
    <div class="card card-custom">
        <div class="card-header">
            <h4 class="card-title">إضافة قيمة جديدة لخاصية</h4>
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

            <form action="{{ route('attribute-values.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="attribute_id" class="form-label">اختر الخاصية:</label>
                    <select name="attribute_id" id="attribute_id" class="form_control_custom" required>
                        <option value="" disabled selected>-- اختر --</option>
                        @foreach($attributes as $attribute)
                            {{-- نستخدم data-name لتمرير اسم الخاصية إلى JavaScript --}}
                            <option value="{{ $attribute->id }}" data-name="{{ $attribute->name }}">{{ $attribute->localized_name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- حاوية ديناميكية لحقل القيمة --}}
                <div class="mb-3">
                    {{-- حقل النص العادي (يظهر افتراضيًا) --}}
                    <div id="text-input-wrapper">
                        <label class="form-label" for="value_text">القيمة:</label>
                        <input class="form_control_custom" type="text" id="value_text" name="value" value="{{ old('value') }}">
                    </div>

                    {{-- حاوية مكون الألوان (مخفية افتراضيًا) --}}
                    <div id="color-input-wrapper" style="display: none;">
                        {{--
                            هنا نستخدم المكون الجاهز الذي أنشأناه!
                            لاحظ أننا لا نحتاج لتمرير label لأن المكون يعرضه بنفسه.
                            قمنا بتعطيل الحقل في البداية عبر JavaScript.
                        --}}
                        <x-color-input name="value" label="اختر اللون" value="#000000" />
                    </div>
                </div>

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-lg" style="background-color: #6f42c1; color: white; font-weight: bold;">حفظ القيمة</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const attributeSelect = document.getElementById('attribute_id');
        const textWrapper = document.getElementById('text-input-wrapper');
        const colorWrapper = document.getElementById('color-input-wrapper');
        const textInput = document.getElementById('value_text');
        // نصل إلى حقل الإدخال داخل مكون اللون
        const colorInput = colorWrapper.querySelector('input[type="text"]');
        const colorAttributeName = 'اللون'; // الاسم الأساسي للخاصية

        function toggleValueInput() {
            const selectedOption = attributeSelect.options[attributeSelect.selectedIndex];
            // في حال لم يتم اختيار شيء، لا تفعل شيئًا
            if (!selectedOption || !selectedOption.dataset.name) {
                textWrapper.style.display = 'block';
                textInput.disabled = false;
                colorWrapper.style.display = 'none';
                if(colorInput) colorInput.disabled = true;
                return;
            }

            const attributeName = selectedOption.dataset.name;

            if (attributeName === colorAttributeName) {
                // إذا كانت الخاصية هي "اللون"
                colorWrapper.style.display = 'block';
                if(colorInput) colorInput.disabled = false; // تفعيل حقل مكون اللون

                textWrapper.style.display = 'none';
                textInput.disabled = true; // تعطيل حقل النص العادي
            } else {
                // لأي خاصية أخرى
                textWrapper.style.display = 'block';
                textInput.disabled = false; // تفعيل حقل النص العادي

                colorWrapper.style.display = 'none';
                if(colorInput) colorInput.disabled = true; // تعطيل حقل مكون اللون
            }
        }

        // استدعاء الدالة عند تغيير الاختيار في القائمة
        attributeSelect.addEventListener('change', toggleValueInput);

        // استدعاء الدالة عند تحميل الصفحة للتأكد من الحالة الصحيحة
        toggleValueInput();
    });
    </script>
@endsection

@push('scripts')

@endpush