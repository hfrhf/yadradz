@extends('dashboard.dashboard')

@section('title', 'تعديل إعدادات: ' . $shippingCompany->name)

@include('dashboard.sidebar')

@section('content')
<div class="container-fluid px-3 px-md-4">
    <div class="card card-custom">
        <div class="card-header">
            <h4 class="card-title">إعدادات منصة: {{ $shippingCompany->name }}</h4>
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

            <form action="{{ route('shippingcompany.update', $shippingCompany->id) }}" method="POST">
                @csrf
                @method('PUT')

                @switch($shippingCompany->slug)
                    @case('yalidine')
                        <p class="text-muted mb-3">إعدادات خاصة بمنصة Yalidine.</p>
                        <div class="mb-3">
                            <label for="api_key" class="form-label">API Key</label>
                            <input type="text" class="form_control_custom" id="api_key" name="settings[api_key]" value="{{ $shippingCompany->settings['api_key'] ?? '' }}">
                        </div>
                        <div class="mb-3">
                            <label for="api_token" class="form-label">API Token</label>
                            <input type="text" class="form_control_custom" id="api_token" name="settings[api_token]" value="{{ $shippingCompany->settings['api_token'] ?? '' }}">
                        </div>
                        @break

                    @case('zr-express')
                        <p class="text-muted mb-3">إعدادات خاصة بمنصة ZR Express.</p>
                        <div class="mb-3">
                            <label for="api_id" class="form-label">API ID (Clé)</label>
                            <input type="text" class="form_control_custom" id="api_id" name="settings[api_id]" value="{{ $shippingCompany->settings['api_id'] ?? '' }}">
                        </div>
                        <div class="mb-3">
                            <label for="api_token" class="form-label">API Token</label>
                            <input type="text" class="form_control_custom" id="api_token" name="settings[api_token]" value="{{ $shippingCompany->settings['api_token'] ?? '' }}">
                        </div>
                        @break

                    @case('ecotrack')
                        <p class="text-muted mb-3">هنا يمكنك إدخال بيانات أي شركة تعمل بنظام Ecotrack (مثل World Express, DHD, etc.).</p>
                        <div class="mb-3">
                            <label for="platform_url" class="form-label">Platform URL</label>
                            <input type="text" class="form_control_custom" id="platform_url" name="settings[platform_url]" value="{{ $shippingCompany->settings['platform_url'] ?? '' }}" placeholder="https://company.ecotrack.dz">
                            <div class="form-text">مثال: https://world-express.ecotrack.dz</div>
                        </div>
                        <div class="mb-3">
                            <label for="api_token" class="form-label">Ecotrack API Token</label>
                            <input type="text" class="form_control_custom" id="api_token" name="settings[api_token]" value="{{ $shippingCompany->settings['api_token'] ?? '' }}">
                        </div>
                        @break

                    @case('maystro')
                        <p class="text-muted mb-3">إعدادات خاصة بمنصة Maystro Delivery.</p>
                        <div class="mb-3">
                            <label for="api_token" class="form-label">Mayestro API Token</label>
                            <input type="text" class="form_control_custom" id="api_token" name="settings[api_token]" value="{{ $shippingCompany->settings['api_token'] ?? '' }}">
                        </div>
                        @break

                    @default
                        <div class="alert alert-info">لا توجد إعدادات خاصة لهذه المنصة.</div>
                @endswitch

                <div class="d-flex justify-content-start gap-2 mt-4">
                    <button type="submit" class="btn btn-lg" style="background-color: #6f42c1; color: white; font-weight: bold;">حفظ التغييرات</button>
                    <a href="{{ route('shippingcompany.index') }}" class="btn btn-lg btn-outline-secondary">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection