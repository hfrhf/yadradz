@extends('dashboard.dashboard')
@section('title','إحصائيات وأسعار التوصيل')

@include('dashboard.sidebar')
@section('content')

<a class="btn-create" href="{{ route('shippings.create') }}">إضافة سعر توصيل</a>

<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>الولاية</th>
                <th>إلى المكتب (دج)</th>
                <th>إلى المنزل (دج)</th>
                <th>إجمالي الطلبات</th>
                <th>متوسط التوصيل (يوم)</th>
                <th>نسبة الإرجاع (%)</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($shippings as $shipping)
                <tr>
                    <td style="background-color: #303036; color:white; text-align:center">
                        {{ $loop->iteration }}
                    </td>

                    <td>{{ $shipping->state }}</td>
                    <td>{{ $shipping->to_office_price }}</td>
                    <td>{{ $shipping->to_home_price }}</td>

                    {{-- عرض البيانات الإحصائية الجديدة --}}
                    <td>{{ $shipping->total_orders }}</td>
                    <td>{{ $shipping->avg_delivery_days }} يوم</td>
                    <td>% {{ $shipping->return_rate }}</td>

                    <td>
                        <div class="d-flex justify-content-center align-items-center gap-2">
                            <a href="{{ route('shippings.edit', $shipping->id) }}" class="btn btn-primary">تعديل</a>
                            <form action="{{ route('shippings.destroy', $shipping->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">حذف</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    {{-- تحديث عدد الأعمدة في حالة عدم وجود بيانات --}}
                    <td colspan="8" class="text-center">لا توجد أسعار توصيل مدخلة</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection