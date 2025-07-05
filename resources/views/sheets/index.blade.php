@extends('dashboard.dashboard')
@section('title','جوجل شيت')

@include('dashboard.sidebar')
@section('content')
<h2 class="mb-4">إعداد Google Sheets</h2>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

@if($sheet)
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Spreadsheet ID</th>
                <th>Sheet Name</th>
                <th>تاريخ التحديث</th>
                <th>الإجراء</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $sheet->spreadsheet_id }}</td>
                <td>{{ $sheet->sheet_name }}</td>
                <td>{{ $sheet->updated_at->format('Y-m-d H:i') }}</td>
                <td>
                    <a href="{{ route('google-sheets.edit') }}" class="btn btn-sm btn-warning">تعديل</a>
                    <form action="{{route('google-sheets.destroy',$sheet->id)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" >حذف</button>
                    </form>
                </td>
            </tr>
        </tbody>
    </table>
@else
    <div class="alert alert-info">
        لم يتم إعداد Google Sheets بعد.
        <a href="{{ route('google-sheets.create') }}" class="btn btn-primary btn-sm ms-2">إضافة إعداد</a>
    </div>
@endif
@endsection