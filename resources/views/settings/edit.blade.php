@extends('dashboard.dashboard')
@section('title', 'تعديل الإعدادات العامة')

@include('dashboard.sidebar')

@section('content')

{{-- Custom styles for file upload and image preview --}}
<style>
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

<div class="container-fluid px-3 px-md-4">
    <div class="card card-custom">
        <div class="card-header">
            <h4 class="card-title">تعديل الإعدادات العامة</h4>
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

            <form action="{{ route('settings.update', $setting->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    {{-- Site Name --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="site_name">اسم الموقع:</label>
                            <input class="form_control_custom" type="text" id="site_name" name="site_name" value="{{ old('site_name', $setting->site_name) }}">
                        </div>
                    </div>

                    {{-- Language --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="language">لغة المتجر:</label>
                            <select name="language" id="language" class="form_control_custom">
                                <option value="ar" {{ old('language', $setting->language) == 'ar' ? 'selected' : '' }}>العربية</option>
                                <option value="fr" {{ old('language', $setting->language) == 'fr' ? 'selected' : '' }}>Français</option>
                            </select>
                        </div>
                    </div>

                    {{-- Header Image Upload --}}
                    <div class="col-md-6">
                        <label class="form-label">صورة الهيدر:</label>
                        <label for="headerImage" class="custom-file-upload">
                            <span class="file-upload-label">اختر صورة</span>
                            <span class="file-name" id="file-name-header">لم يتم اختيار ملف</span>
                        </label>
                        <input id="headerImage" class="d-none" type="file" name="header_image">
                        @isset($setting->header_image)
                        <div class="image-preview-container">
                            <img class="image-preview" src="{{ asset('storage/'.$setting->header_image) }}" alt="Header Image Preview">
                        </div>
                        @endisset
                    </div>

                    {{-- Logo Upload --}}
                    <div class="col-md-6">
                        <label class="form-label">اللوجو (الشعار):</label>
                        <label for="logoImage" class="custom-file-upload">
                            <span class="file-upload-label">اختر صورة</span>
                            <span class="file-name" id="file-name-logo">لم يتم اختيار ملف</span>
                        </label>
                        <input id="logoImage" class="d-none" type="file" name="logo">
                        @isset($setting->logo)
                        <div class="image-preview-container">
                            <img class="image-preview" src="{{ asset('storage/'.$setting->logo) }}" alt="Logo Preview">
                        </div>
                        @endisset
                    </div>

                    <div class="col-12"><hr class="my-4"></div>

                    {{-- Using the Blade Component for colors --}}
                    <x-color-input name="background_opacity" label="لون شفافية الخلفية" :value="$setting->background_opacity" />
                    <x-color-input name="sidebar_color" label="لون الشريط الجانبي" :value="$setting->sidebar_color" />

                    {{-- Opacity --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="opacity">الشفافية (من 0.1 إلى 1):</label>
                            <input class="form_control_custom" type="number" step="0.01" min="0" max="1" id="opacity" name="opacity" value="{{ old('opacity', $setting->opacity) }}">
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="col-12">
                        <div class="mb-3">
                            <label class="form-label" for="content">المحتوى:</label>
                            <textarea class="form_control_custom" id="content" name="content" rows="4">{{ old('content', $setting->content) }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Submit Button --}}
                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-lg" style="background-color: #6f42c1; color: white; font-weight: bold;">حفظ التعديلات</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        function setupFileInput(inputId, spanId) {
            const input = document.getElementById(inputId);
            const fileNameSpan = document.getElementById(spanId);

            if (input) {
                input.addEventListener('change', function() {
                    if (this.files && this.files.length > 0) {
                        fileNameSpan.textContent = this.files[0].name;
                    } else {
                        fileNameSpan.textContent = 'لم يتم اختيار ملف';
                    }
                });
            }
        }

        setupFileInput('headerImage', 'file-name-header');
        setupFileInput('logoImage', 'file-name-logo');
    });
</script>

@endsection



