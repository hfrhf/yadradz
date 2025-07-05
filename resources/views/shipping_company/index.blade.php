@extends('dashboard.dashboard') {{-- افترضت وجود ملف layout رئيسي --}}
@section('title', 'إدارة شركات الشحن')
@include('dashboard.sidebar')
@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title">شركات الشحن المتوفرة</h4>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>اسم الشركة</th>
                        <th>الحالة</th>
                        <th>الإعدادات</th>
                        <th class="text-center">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($companies as $index => $company)
                        <tr>
                            <td style="background-color: #303036;color:white;text-align:center">{{$index+1}}</td>
                            <td>{{ $company->name }}
                                @if ($company->slug == 'ecotrack')
                               <span class="text-success fw-bold">( {{ \Illuminate\Support\Str::before(str_replace('https://', '', $company->settings['platform_url']), '.ecotrack.dz') }}
                                )</span>



                                @endif

                            </td>
                            <td>
                                @if($company->is_active)
                                    <span class="badge bg-success">مفعل</span>
                                @else
                                    <span class="badge bg-secondary">غير مفعل</span>
                                @endif
                            </td>
                            <td>
                                @if(!empty($company->settings))
                                    <span class="badge bg-primary">تم التعيين</span>
                                @else
                                    <span class="badge bg-warning">فارغ</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('shippingcompany.edit', $company->id) }}" class="btn btn-sm btn-info">تعديل الإعدادات</a>

                                {{-- --- التعديل الجديد: إظهار زر التفعيل أو إلغاء التفعيل --- --}}
                                @if($company->is_active)
                                    <form action="{{ route('shippingcompany.deactivate', $company->id) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من إلغاء تفعيل هذه الشركة؟')">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-warning">إلغاء التفعيل</button>
                                    </form>
                                @else
                                    <form action="{{ route('shippingcompany.activate', $company->id) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من تفعيل هذه الشركة؟')">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">تفعيل</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
