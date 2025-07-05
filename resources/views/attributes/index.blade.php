@extends('dashboard.dashboard')
@section('title','الخصائص')

@include('dashboard.sidebar')
@section('content')

<a class="btn-create" href="{{ route('attributes.create') }}">إضافة خاصية</a>

<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>معرف</th>
                <th>الاسم</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($attributes as $attribute)
                <tr>
                    <td style="background-color: #303036; color:white; text-align:center">
                        {{ $loop->iteration }}
                    </td>
                    <td>{{ $attribute->name }}</td>
                    <td>
                        <div class="d-flex justify-content-center align-items-center gap-2">
                            <a href="{{ route('attributes.edit', $attribute->id) }}" class="btn btn-primary">تحديث</a>
                            <form action="{{ route('attributes.destroy', $attribute->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">حذف</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">لا توجد خصائص</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
