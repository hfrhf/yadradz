@extends('dashboard.dashboard')

@section('title', 'إضافة إلى القائمة السوداء')

@include('dashboard.sidebar')

@section('content')

<div class="container-fluid px-3 px-md-4">
    <div class="card card-custom">
        <div class="card-header">
            <h4 class="card-title">إضافة إلى القائمة السوداء</h4>
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

            <form action="{{ route('blacklist.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="phone" class="form-label">رقم الهاتف:</label>
                    <input type="text" class="form_control_custom" id="phone" name="phone" value="{{ old('phone') }}">
                </div>

                <div class="mb-3">
                    <label for="ip_address" class="form-label">عنوان IP:</label>
                    <input type="text" class="form_control_custom" id="ip_address" name="ip_address" value="{{ old('ip_address') }}">
                </div>

                <div class="mb-3">
                    <label for="reason" class="form-label">السبب:</label>
                    <input type="text" class="form_control_custom" id="reason" name="reason" value="{{ old('reason') }}">
                </div>

                <div class="d-flex justify-content-start gap-2 mt-4">
                    <button type="submit" class="btn btn-lg" style="background-color: #6f42c1; color: white; font-weight: bold;">إضافة للقائمة</button>
                    <a href="{{ route('blacklist.index') }}" class="btn btn-lg btn-outline-secondary">رجوع</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection