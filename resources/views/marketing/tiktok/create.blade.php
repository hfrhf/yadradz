@extends('dashboard.dashboard')

@section('title', 'إضافة بيكسل TikTok جديد')

@include('dashboard.sidebar')

@section('content')

<div class="container-fluid px-3 px-md-4">
    <div class="card card-custom">
        <div class="card-header">
            <h4 class="card-title">إضافة بيكسل TikTok جديد</h4>
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

            <form action="{{ route('tiktok.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">اسم البيكسل</label>
                    <input type="text" id="name" name="name" class="form_control_custom @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="identifier" class="form-label">معرّف البيكسل (Pixel ID)</label>
                    <input type="text" id="identifier" name="identifier" class="form_control_custom @error('identifier') is-invalid @enderror" value="{{ old('identifier') }}" required>
                    @error('identifier') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="token" class="form-label">Token الوصول (Access Token - اختياري)</label>
                    <input type="text" id="token" name="token" class="form_control_custom @error('token') is-invalid @enderror" value="{{ old('token') }}">
                    @error('token') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="d-flex justify-content-start gap-2 mt-4">
                    <button type="submit" class="btn btn-lg" style="background-color: #6f42c1; color: white; font-weight: bold;">حفظ البيكسل</button>
                    <a href="{{ route('tiktok.index') }}" class="btn btn-lg btn-outline-secondary">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
