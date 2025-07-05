@extends('dashboard.dashboard')

@section('title', 'إضافة سعر توصيل جديد')

@include('dashboard.sidebar')

@section('content')

<div class="container-fluid px-3 px-md-4">
    <div class="card card-custom">
        <div class="card-header">
            <h4 class="card-title">إضافة سعر توصيل جديد</h4>
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

            <form action="{{ route('shippings.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label" for="state">الولاية:</label>
                            <input class="form_control_custom" type="text" name="state" id="state" value="{{ old('state') }}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label" for="to_office_price">سعر التوصيل إلى المكتب:</label>
                            <input class="form_control_custom" type="number" step="0.01" id="to_office_price" name="to_office_price" value="{{ old('to_office_price') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label" for="to_home_price">سعر التوصيل إلى المنزل:</label>
                            <input class="form_control_custom" type="number" step="0.01" id="to_home_price" name="to_home_price" value="{{ old('to_home_price') }}">
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-start gap-2 mt-4">
                    <button type="submit" class="btn btn-lg" style="background-color: #6f42c1; color: white; font-weight: bold;">إنشاء السعر</button>
                    <a href="{{ route('shippings.index') }}" class="btn btn-lg btn-outline-secondary">رجوع</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection