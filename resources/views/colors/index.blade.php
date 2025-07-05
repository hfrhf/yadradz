@extends('dashboard.dashboard')

@include('dashboard.sidebar')
@section('content')



    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>اللون الأساسي</th>
                <th>لون العنوان</th>
                <th>لون النص</th>
                <th>لون الزر</th>
                <th>لون السعر</th>
                <th>لون التذييل</th>
                <th>لون شريط التنقل</th>
                <th>العمليات</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $siteColor->primary_color }}</td>
                <td>{{ $siteColor->title_color }}</td>
                <td>{{ $siteColor->text_color }}</td>
                <td>{{ $siteColor->button_color }}</td>
                <td>{{ $siteColor->price_color }}</td>
                <td>{{ $siteColor->footer_color }}</td>
                <td>{{ $siteColor->navbar_color }}</td>
                <td>
                    <a href="{{ route('colors.edit', $siteColor->id) }}" class="btn btn-warning">تعديل</a>
                </td>
            </tr>
            <tr>
                <td style="background-color: {{ $siteColor->primary_color }};"></td>
                <td style="background-color: {{ $siteColor->title_color }};"></td>
                <td style="background-color: {{ $siteColor->text_color }};"></td>
                <td style="background-color: {{ $siteColor->button_color }};"></td>
                <td style="background-color: {{ $siteColor->price_color }};"></td>
                <td style="background-color: {{ $siteColor->footer_color }};"></td>
                <td style="background-color: {{ $siteColor->navbar_color }};"></td>
                <td>
                    
                </td>
            </tr>
            
        </tbody>
    </table>
   </div>

@endsection
