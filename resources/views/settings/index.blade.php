@extends('dashboard.dashboard')
@section('title','الإعدادات')
@include('dashboard.sidebar')

@section('content')
<div class="settings-wrapper">
    <div class="settings-header">
        <h2><i class="fas fa-sliders-h me-2"></i> إعدادات المتجر</h2>
        <a href="{{ route('settings.edit', $setting->id) }}" class="btn-edit">تعديل الإعدادات</a>
    </div>

    @isset($setting)
    <div class="settings-grid">

        <div class="setting-card">
            <div class="label">📛 اسم الموقع:</div>
            <div class="value">{{ $setting->site_name }}</div>
        </div>

        <div class="setting-card">
            <div class="label">🌐 لغة المتجر:</div>
            <div class="value">{{ $setting->language }}</div>
        </div>

        <div class="setting-card">
            <div class="label">🖼️ صورة الرأس:</div>
            <div class="value">
                @if($setting->header_image)
                    <img src="{{ asset('storage/' . $setting->header_image) }}" alt="Header Image">
                @else
                    <span class="text-muted">لا توجد صورة</span>
                @endif
            </div>
        </div>

        <div class="setting-card">
            <div class="label">🎨 لون الخلفية وشفافيتها:</div>
            <div class="value">
                <div class="bg-box" style="background-color: {{ $setting->background_opacity }}; opacity: {{ $setting->opacity }};"></div>
                <small>{{ $setting->background_opacity }} بنسبة {{ $setting->opacity }}</small>
            </div>
        </div>

        <div class="setting-card">
            <div class="label">🧩 اللوغو:</div>
            <div class="value">
                @if($setting->logo)
                    <img src="{{ asset('storage/' . $setting->logo) }}" alt="Logo">
                @else
                    <span class="text-muted">لا توجد صورة</span>
                @endif
            </div>
        </div>

        <div class="setting-card">
            <div class="label">📦 لون الشريط الجانبي:</div>
            <div class="value">
                <div class="color-box" style="background-color: {{ $setting->sidebar_color }}"></div>
                <span>{{ $setting->sidebar_color }}</span>
            </div>
        </div>

        <div class="setting-card full-width">
            <div class="label">📝 محتوى الصفحة:</div>
            <div class="value">{{ $setting->content }}</div>
        </div>

    </div>
    @endisset
</div>

{{-- CSS داخل الصفحة --}}
<style>
    @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap');

    * {
        font-family: 'Tajawal', sans-serif;
        box-sizing: border-box;
    }

    .settings-wrapper {
        padding: 24px;
        background-color: #f5f7fa;
    }

    .settings-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .settings-header h2 {
        color: #343a40;
        font-weight: 700;
    }

    .btn-edit {
        background: linear-gradient(45deg, #4e73df, #1cc88a);
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 500;
        transition: 0.3s;
    }

    .btn-edit:hover {
        opacity: 0.9;
    }

    .settings-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
    }

    .setting-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        transition: transform 0.3s ease;
    }

    .setting-card:hover {
        transform: translateY(-3px);
    }

    .setting-card.full-width {
        grid-column: span 2;
    }

    .label {
        font-weight: bold;
        color: #6c757d;
        margin-bottom: 8px;
        font-size: 15px;
    }

    .value {
        font-size: 16px;
        color: #212529;
    }

    .value img {
        max-width: 80px;
        border-radius: 6px;
    }

    .color-box, .bg-box {
        display: inline-block;
        width: 30px;
        height: 30px;
        border-radius: 6px;
        margin-right: 8px;
        vertical-align: middle;
        border: 1px solid #ccc;
    }

    .text-muted {
        color: #aaa;
    }

    @media (max-width: 768px) {
        .setting-card.full-width {
            grid-column: span 1;
        }
    }
</style>
@endsection
