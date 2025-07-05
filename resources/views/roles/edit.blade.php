@extends('dashboard.dashboard')

@section('title', 'تعديل الدور')

@include('dashboard.sidebar')

@section('content')

<div class="container-fluid px-3 px-md-4">
    <div class="card card-custom">
        <div class="card-header">
            <h4 class="card-title">تعديل الدور: {{ $role->name }}</h4>
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

            <form action="{{ route('roles.update', $role->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label" for="name">اسم الدور:</label>
                    <input class="form_control_custom" type="text" id="name" name="name" value="{{ $role->name }}" disabled>
                </div>

                <div class="mb-4">
                    <label class="form-label">الصلاحيات:</label>
                    <div class="p-3 border rounded-3" style="background-color: #f8f9fa;">
                        <div class="row">
                            @foreach($permissions as $permission)
                                <div class="col-md-4 col-sm-6">
                                    <div class="form-check form-check-custom">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->name }}" id="perm_{{ $permission->id }}" {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
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
                    <button type="submit" class="btn btn-lg" style="background-color: #6f42c1; color: white; font-weight: bold;">تحديث الدور</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
