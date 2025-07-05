@extends('dashboard.dashboard')

@section('title', 'إدارة Google Tag Manager')

@include('dashboard.sidebar')

@section('content')

<div class="container-fluid px-3 px-md-4">
    <div class="card card-custom">
        <div class="card-header">
            <h4 class="card-title">Google Tag Manager</h4>
        </div>
        <div class="card-body p-4">

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if ($tracker)
                {{-- Form to update existing GTM tracker --}}
                <form action="{{ route('gtm.update', $tracker) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Container ID --}}
                    <div class="mb-3">
                        <label for="identifier" class="form-label">Container ID:</label>
                        <input type="text" id="identifier" name="identifier" value="{{ old('identifier', $tracker->identifier) }}" class="form_control_custom" required>
                    </div>

                    {{-- Status --}}
                    <div class="mb-3">
                        <label for="is_active" class="form-label">الحالة:</label>
                        <select name="is_active" id="is_active" class="form_control_custom">
                            <option value="1" {{ old('is_active', $tracker->is_active) == 1 ? 'selected' : '' }}>مفعل</option>
                            <option value="0" {{ old('is_active', $tracker->is_active) == 0 ? 'selected' : '' }}>غير مفعل</option>
                        </select>
                    </div>

                    {{-- Submit Button --}}
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-lg" style="background-color: #6f42c1; color: white; font-weight: bold;">تحديث</button>
                    </div>
                </form>
            @else
                {{-- Message and button to add a new GTM ID --}}
                <div class="text-center">
                    <p class="mb-3">لم يتم إضافة معرف Google Tag Manager بعد.</p>
                    <a href="{{ route('gtm.create') }}" class="btn btn-lg" style="background-color: #6f42c1; color: white; font-weight: bold;">إضافة Container ID</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection