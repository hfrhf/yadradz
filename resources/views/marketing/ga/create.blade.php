@extends('dashboard.dashboard')

@section('title', 'إضافة Google Analytics ID')

@include('dashboard.sidebar')

@section('content')

<div class="container-fluid px-3 px-md-4">
    <div class="card card-custom">
        <div class="card-header">
            <h4 class="card-title">إضافة Google Analytics ID</h4>
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

            <form action="{{ route('ga.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="identifier" class="form-label">Tracking ID</label>
                    <input type="text" id="identifier" name="identifier" class="form_control_custom @error('identifier') is-invalid @enderror" value="{{ old('identifier') }}" required placeholder="UA-XXXXXXXXX-X">
                    @error('identifier') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="d-flex justify-content-start gap-2 mt-4">
                    <button type="submit" class="btn btn-lg" style="background-color: #6f42c1; color: white; font-weight: bold;">حفظ</button>
                    <a href="{{ route('ga.index') }}" class="btn btn-lg btn-outline-secondary">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
