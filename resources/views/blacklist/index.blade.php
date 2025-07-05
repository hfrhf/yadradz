@extends('dashboard.dashboard')
@section('title','القائمة السوداء')

@include('dashboard.sidebar')
@section('content')

<a class="btn-create" href="{{ route('blacklist.create') }}">إضافة إلى القائمة السوداء</a>

<div class="table-responsive mt-3">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>رقم الهاتف</th>
                <th>IP Address</th>
                <th>السبب</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($blacklists as $entry)
                <tr>
                    <td style="background-color: #303036; color:white; text-align:center">{{ $loop->iteration }}</td>
                    <td>{{ $entry->phone ?? '-' }}</td>
                    <td>{{ $entry->ip_address ?? '-' }}</td>
                    <td>{{ $entry->reason ?? '-' }}</td>
                    <td>
                        <div class="d-flex justify-content-center align-items-center gap-2">
                            <a href="{{ route('blacklist.edit', $entry->id) }}" class="btn btn-primary">تعديل</a>
                            <form action="{{ route('blacklist.destroy', $entry->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" onclick="return confirm('هل أنت متأكد؟')">حذف</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">لا توجد بيانات</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
