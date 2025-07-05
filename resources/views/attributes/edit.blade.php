@extends('dashboard.dashboard')

@section('title', 'تعديل خاصية')

@include('dashboard.sidebar')

@section('content')

<div class="container-fluid px-3 px-md-4">
    <div class="card card-custom">
        <div class="card-header">
            <h4 class="card-title">تعديل خاصية</h4>
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

            <form action="{{ route('attributes.update', $attribute->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label" for="name">اسم الخاصية:</label>
                    <input class="form_control_custom" type="text" id="name" name="name" value="{{ old('name', $attribute->name) }}" required @if($attribute->is_locked) readonly @endif>
                </div>
                <div class="mb-3">
                    <label for="name_fr" class="form-label">الاسم (بالفرنسية):</label>
                    <input type="text" name="name_fr" class="form_control_custom" value="{{ $attribute->name_fr }}" @if($attribute->is_locked) readonly @endif>
                </div>

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-lg" style="background-color: #6f42c1; color: white; font-weight: bold;">تعديل الخاصية</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection