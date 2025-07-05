@extends('dashboard.dashboard')

@section('title', 'تعديل سعر التوصيل')

@include('dashboard.sidebar')

@section('content')

<div class="container-fluid px-3 px-md-4">
    <div class="card card-custom">
        <div class="card-header">
            <h4 class="card-title">تعديل سعر التوصيل لولاية: {{ $shipping->state }}</h4>
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

            <form action="{{ route('shippings.update', $shipping->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label" for="state">الولاية:</label>
                            <input class="form_control_custom" type="text" name="state" id="state" value="{{ old('state', $shipping->state) }}" required>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="to_office_price">سعر التوصيل إلى المكتب:</label>
                            <input class="form_control_custom" type="number" step="0.01" id="to_office_price" name="to_office_price" value="{{ old('to_office_price', $shipping->to_office_price) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="to_home_price">سعر التوصيل إلى المنزل:</label>
                            <input class="form_control_custom" type="number" step="0.01" id="to_home_price" name="to_home_price" value="{{ old('to_home_price', $shipping->to_home_price) }}">
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">البلديات التي يتوفر فيها التوصيل:</label>
                    <div class="p-3 border rounded-3" style="background-color: #f8f9fa;">
                        <div class="row">
                            @foreach ($shipping->municipalities as $municipality)
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-check form-check-custom">
                                        <input class="form-check-input" type="checkbox" name="municipalities[{{ $municipality->id }}]" id="municipality_{{ $municipality->id }}" value="1" {{ $municipality->is_delivery ? 'checked' : '' }}>
                                        <label class="form-check-label" for="municipality_{{ $municipality->id }}">
                                            {{ $municipality->name }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-start gap-2 mt-4">
                    <button type="submit" class="btn btn-lg" style="background-color: #6f42c1; color: white; font-weight: bold;">تحديث السعر</button>
                    <a href="{{ route('shippings.index') }}" class="btn btn-lg btn-outline-secondary">رجوع</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
