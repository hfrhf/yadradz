@extends('dashboard.dashboard')

@section('title', 'إضافة دور جديد')

@include('dashboard.sidebar')

@section('content')

<style>
    /* Custom Checkbox Styles */
   
</style>

<div class="container-fluid px-3 px-md-4">
    <div class="card card-custom">
        <div class="card-header">
            <h4 class="card-title">إضافة دور جديد</h4>
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

            <form action="{{ route('roles.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label" for="name">اسم الدور:</label>
                    <input class="form_control_custom" type="text" id="name" name="name" value="{{ old('name') }}" required>
                </div>

                <div class="mb-4">
                    <label class="form-label">الصلاحيات:</label>
                    <div class="p-3 border rounded-3" style="background-color: #f8f9fa;">
                        <div class="row">
                            @foreach($permissions as $permission)
                                <div class="col-md-4 col-sm-6">
                                    <div class="form-check form-check-custom">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->name }}" id="perm_{{ $permission->id }}">
                                        <label class="form-check-label" for="perm_{{ $permission->id }}">
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-lg" style="background-color: #6f42c1; color: white; font-weight: bold;">إنشاء الدور</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
