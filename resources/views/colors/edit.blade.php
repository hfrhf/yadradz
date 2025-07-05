@extends('dashboard.dashboard')

@section('title', 'تعديل إعدادات الألوان')

@include('dashboard.sidebar')

@section('content')

<div class="container-fluid px-3 px-md-4">
    <div class="card card-custom">
        <div class="card-header">
            <h4 class="card-title">تعديل إعدادات الألوان</h4>
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

            <form action="{{ route('colors.update', $color->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    {{--
                        هنا نستدعي المكون الجديد!
                        لاحظ كيف أصبح الكود نظيفًا ومقروءًا.
                        - نمرر اسم الحقل كـ "name".
                        - نمرر العنوان كـ "label".
                        - نمرر القيمة الحالية من قاعدة البيانات كـ "value" مع استخدام ":" لربط البيانات.
                    --}}

                    <x-color-input name="primary_color" label="اللون الأساسي" :value="$color->primary_color" />
                    <x-color-input name="title_color" label="لون العنوان" :value="$color->title_color" />
                    <x-color-input name="text_color" label="لون النص" :value="$color->text_color" />
                    <x-color-input name="button_color" label="لون الزر" :value="$color->button_color" />
                    <x-color-input name="price_color" label="لون السعر" :value="$color->price_color" />
                    <x-color-input name="footer_color" label="لون التذييل" :value="$color->footer_color" />
                    <x-color-input name="navbar_color" label="لون شريط التنقل" :value="$color->navbar_color" />

                </div>

                {{-- Submit Button --}}
                <div class="d-grid mt-4">
                    <button class="btn btn-lg" type="submit" style="background-color: #6f42c1; color: white; font-weight: bold;">تحديث الألوان</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection