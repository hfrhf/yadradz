@extends('dashboard.dashboard')
@section('title', 'سجل مدفوعات ' . $user->name)

@include('dashboard.sidebar')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>سجل المدفوعات لـ: {{ $user->name }}</h3>
    <a href="{{ route('confirmers.index') }}" class="btn btn-secondary">العودة إلى القائمة</a>
</div>

<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>المبلغ المدفوع</th>
                <th>تاريخ الدفع</th>
                <th>ملاحظات</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($payments as $payment)
            <tr>
                <td style="background-color: #303036;color:white;text-align:center">{{ $loop->iteration }}</td>
                <td>{{ number_format($payment->amount, 2) }} د.ج</td>
                <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('Y-m-d') }}</td>
                <td>{{ $payment->notes ?? '—' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">لا توجد سجلات دفع لهذا المستخدم.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- روابط التنقل بين الصفحات --}}
{{ $payments->links() }}

@endsection