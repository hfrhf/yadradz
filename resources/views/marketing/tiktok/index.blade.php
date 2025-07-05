@extends('dashboard.dashboard')
@section('content')
@include('dashboard.sidebar')
<div class="container p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>بيكسلات تيك توك</h4>
        {{-- تصحيح: تم تعديل اسم المسار ليتوافق مع Route::resource --}}
        <a href="{{ route('tiktok.create') }}" class="btn btn-primary">إضافة بيكسل جديد</a>
    </div>

     @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>الاسم</th>
                <th>معرّف البيكسل (Identifier)</th>
                <th>Token الوصول</th>
                <th>الحالة</th>
                <th>إجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($trackers as $tracker)
                <tr>
                    <td>{{ $tracker->name }}</td>
                    {{-- تصحيح: اسم الحقل في قاعدة البيانات هو identifier --}}
                    <td>{{ $tracker->identifier }}</td>
                     {{-- تصحيح: اسم الحقل في قاعدة البيانات هو token --}}
                    <td>{{ $tracker->token ?? '---' }}</td>
                    <td>{{ $tracker->is_active ? 'مفعل' : 'غير مفعل' }}</td>
                    <td>
                        {{-- تصحيح: تم تعديل اسم المسار ليتوافق مع Route::resource --}}
                        <a href="{{ route('tiktok.edit', $tracker) }}" class="btn btn-sm btn-warning">تعديل</a>
                        <form action="{{ route('tiktok.destroy', $tracker) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد؟')">حذف</button>
                        </form>
                    </td>
                </tr>
            @empty
                 <tr>
                    <td colspan="5" class="text-center">لا توجد بيكسلات مضافة حالياً.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection