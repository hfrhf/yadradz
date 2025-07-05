@extends('dashboard.dashboard')

@section('title', 'إضافة Google Tag Manager ID')

@include('dashboard.sidebar')

@section('content')

<div class="container-fluid px-3 px-md-4">
    <div class="card card-custom">
        <div class="card-header">
            <h4 class="card-title">إضافة Google Tag Manager ID</h4>
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

            {{-- The form for adding a GTM ID --}}
            <form action="{{ route('gtm.store') }}" method="POST">
                @csrf

                {{-- Container ID --}}
                <div class="mb-3">
                    <label for="identifier" class="form-label">Container ID:</label>
                    <input type="text" id="identifier" name="identifier" class="form_control_custom" value="{{ old('identifier') }}" required>
                </div>

                {{-- Action Buttons --}}
                <div class="d-flex justify-content-start gap-2 mt-4">
                    <button type="submit" class="btn btn-lg" style="background-color: #6f42c1; color: white; font-weight: bold;">حفظ</button>
                    <a href="{{ route('gtm.index') }}" class="btn btn-lg btn-secondary">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection