@extends('dashboard.dashboard')

@section('title', 'إعداد Google Sheets')

@include('dashboard.sidebar')

@section('content')

<div class="container-fluid px-3 px-md-4">
    <div class="card card-custom">
        <div class="card-header">
            <h4 class="card-title">إعداد Google Sheets لأول مرة</h4>
        </div>
        <div class="card-body p-4">

            {{-- Session Messages --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('google-sheets.store') }}" enctype="multipart/form-data">
                @csrf

                {{-- Google JSON File Input --}}
                <div class="mb-3">
                    <label for="json" class="form-label">ملف Google JSON:</label>
                    <input type="file" name="json" id="json" class="form_control_custom" required>
                </div>

                {{-- Spreadsheet ID Input --}}
                <div class="mb-3">
                    <label for="spreadsheet_id" class="form-label">Spreadsheet ID:</label>
                    <input type="text" name="spreadsheet_id" id="spreadsheet_id" class="form_control_custom" required>
                </div>

                {{-- Sheet Name Input --}}
                <div class="mb-3">
                    <label for="sheet_name" class="form-label">Sheet Name:</label>
                    <input type="text" name="sheet_name" id="sheet_name" class="form_control_custom" value="Orders" required>
                </div>

                {{-- Action Buttons --}}
                <div class="d-flex justify-content-start gap-2 mt-4">
                    <button type="submit" class="btn btn-lg" style="background-color: #6f42c1; color: white; font-weight: bold;">حفظ الإعداد</button>
                    <a href="{{ route('google-sheets.index') }}" class="btn btn-lg btn-secondary">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection