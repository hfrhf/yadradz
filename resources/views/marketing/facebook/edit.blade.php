@extends('dashboard.dashboard')

@section('title', 'تعديل بيكسل فيسبوك')

@include('dashboard.sidebar')

@section('content')

<div class="container-fluid px-3 px-md-4">
    <div class="card card-custom">
        <div class="card-header">
            <h4 class="card-title">تعديل بيكسل فيسبوك</h4>
        </div>
        <div class="card-body p-4">

            {{-- Session Messages for success/error can be added here if needed --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- The form for editing the Facebook Pixel --}}
            <form action="{{ route('facebook.update', $facebook) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Pixel Name --}}
                <div class="mb-3">
                    <label for="name" class="form-label">اسم البيكسل:</label>
                    <input type="text" name="name" id="name" class="form_control_custom" value="{{ old('name', $facebook->name) }}" required>
                </div>

                {{-- Pixel Identifier --}}
                <div class="mb-3">
                    <label for="identifier" class="form-label">معرّف البيكسل:</label>
                    <input type="text" name="identifier" id="identifier" class="form_control_custom" value="{{ old('identifier', $facebook->identifier) }}" required>
                </div>

                {{-- Conversion API Token (Optional) --}}
                <div class="mb-3">
                    <label for="token" class="form-label">Conversion API Token (اختياري):</label>
                    <input type="text" name="token" id="token" class="form_control_custom" value="{{ old('token', $facebook->token) }}">
                </div>

                {{-- Is Active Status --}}
                <div class="mb-3">
                    <label for="is_active" class="form-label">هل مفعل؟</label>
                    <select name="is_active" id="is_active" class="form_control_custom">
                        <option value="1" {{ old('is_active', $facebook->is_active) == 1 ? 'selected' : '' }}>نعم</option>
                        <option value="0" {{ old('is_active', $facebook->is_active) == 0 ? 'selected' : '' }}>لا</option>
                    </select>
                </div>

                {{-- Action Buttons --}}
                <div class="d-flex justify-content-start gap-2 mt-4">
                    <button type="submit" class="btn btn-lg" style="background-color: #6f42c1; color: white; font-weight: bold;">تحديث البيكسل</button>
                    <a href="{{ route('facebook.index') }}" class="btn btn-lg btn-secondary">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection