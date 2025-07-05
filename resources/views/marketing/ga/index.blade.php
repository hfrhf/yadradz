@extends('dashboard.dashboard')

@section('title', 'إدارة Google Analytics')

@include('dashboard.sidebar')

@section('content')

<div class="container-fluid px-3 px-md-4">
    <div class="card card-custom">
        <div class="card-header">
            <h4 class="card-title">إدارة Google Analytics</h4>
        </div>
        <div class="card-body p-4">

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

            @if ($tracker)
                <form action="{{ route('ga.update', $tracker) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="identifier" class="form-label">Tracking ID</label>
                        <input type="text" id="identifier" name="identifier" value="{{ old('identifier', $tracker->identifier) }}" class="form_control_custom" required>
                    </div>

                    <div class="mb-3">
                        <label for="is_active" class="form-label">الحالة</label>
                        <select name="is_active" id="is_active" class="form_control_custom">
                            <option value="1" {{ old('is_active', $tracker->is_active) == 1 ? 'selected' : '' }}>مفعل</option>
                            <option value="0" {{ old('is_active', $tracker->is_active) == 0 ? 'selected' : '' }}>غير مفعل</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-start gap-2 mt-4">
                        <button type="submit" class="btn btn-lg" style="background-color: #6f42c1; color: white; font-weight: bold;">تحديث</button>
                    </div>
                </form>
            @else
                <div class="text-center">
                    <p>لم يتم إضافة معرف تتبع Google Analytics بعد.</p>
                    <a href="{{ route('ga.create') }}" class="btn btn-lg" style="background-color: #6f42c1; color: white; font-weight: bold;">إضافة Tracking ID</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection