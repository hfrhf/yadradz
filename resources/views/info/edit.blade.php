@extends('dashboard.dashboard')

@section('title', 'تعديل معلومات الإدارة')

@include('dashboard.sidebar')

@section('content')
<div class="container-fluid px-3 px-md-4">
    <div class="card card-custom">
        <div class="card-header">
            <h4 class="card-title">تعديل معلومات الإدارة</h4>
        </div>
        <div class="card-body p-4">

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
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

            <form action="{{ route('info.update', $info->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="facebook" class="form-label">فيسبوك:</label>
                            <input class="form_control_custom" type="text" id="facebook" name="facebook" value="{{ old('facebook', $info->facebook) }}">
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email" class="form-label">البريد الإلكتروني:</label>
                            <input class="form_control_custom" type="email" id="email" name="email" value="{{ old('email', $info->email) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="phone" class="form-label">رقم الهاتف:</label>
                            <input class="form_control_custom" type="text" id="phone" name="phone" value="{{ old('phone', $info->phone) }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="twitter" class="form-label">تويتر:</label>
                            <input class="form_control_custom" type="text" id="twitter" name="twitter" value="{{ old('twitter', $info->twitter) }}">
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="whatsapp" class="form-label">رقم الواتساب:</label>
                    <input class="form_control_custom" type="text" id="whatsapp" name="whatsapp" value="{{ old('whatsapp', $info->whatsapp) }}">
                </div>

                <div class="d-flex justify-content-start gap-2 mt-4">
                    <button type="submit" class="btn btn-lg" style="background-color: #6f42c1; color: white; font-weight: bold;">تحديث المعلومات</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
