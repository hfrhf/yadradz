@extends('dashboard.dashboard')
@section('title','الأدوار')

@include('dashboard.sidebar')
@section('content')
<a class="btn-create" href="{{ route('roles.create') }}">إضافة دور</a>

<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>اسم الدور</th>
                <th>الصلاحيات</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($roles as $index => $role)
                <tr>
                    <td style="background-color: #303036;color:white;text-align:center">{{ $index + 1 }}</td>
                    <td>{{ $role->name }}</td>
                    <td>
                        @foreach($role->permissions as $perm)
                            <span class="badge bg-info">{{ $perm->name }}</span>
                        @endforeach
                    </td>
                    <td>
                        <div class="d-flex justify-content-center align-items-center gap-2">
                            <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-primary">تعديل</a>
                            <form action="{{ route('roles.destroy', $role->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit">حذف</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">لا توجد أدوار</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
