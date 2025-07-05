@extends('dashboard.dashboard')
@section('title','إدارة مؤكدي الطلبيات')

@include('dashboard.sidebar')

@section('content')

{{-- رسائل النجاح والخطأ --}}
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="list-unstyled mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>اسم المؤكد</th>
                <th>طلبات مؤكدة</th>
                <th>طلبات ملغاة</th>
                <th>نظام الدفع</th>
                <th>إجمالي المدفوع</th>
                <th>صافي المستحق</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($confirmers as $confirmer)
            <tr>
                <td style="background-color: #303036;color:white;text-align:center">
                    {{ $confirmers->firstItem() + $loop->index }}
                </td>
                <td>{{ $confirmer->name }}</td>
                <td>{{ $confirmer->confirmed_orders_count }}</td>
                <td>{{ $confirmer->canceled_orders_count }}</td>
                <td>
                    @if($confirmer->confirmer_payment_type == 'per_order')
                        <span>تأكيد ({{ $confirmer->confirmer_payment_rate ?? 'N/A' }})</span><br>
                        <small class="text-success">إلغاء ({{ $confirmer->confirmer_cancellation_rate ?? 'N/A' }})</small>
                    @elseif($confirmer->confirmer_payment_type == 'monthly_salary')
                        <span>راتب شهري ({{ $confirmer->confirmer_payment_rate ?? 'N/A' }})</span>
                    @else
                        <span class="text-muted">غير محدد</span>
                    @endif
                </td>
                <td>{{ number_format($confirmer->payments_sum_amount ?? 0, 2) }} د.ج</td>
                <td><strong>{{ number_format($confirmer->net_due_amount ?? 0, 2) }} د.ج</strong></td>
                <td>
                    {{-- ✨ --- بداية التعديل هنا --- ✨ --}}
                    <div class="d-flex gap-2 justify-content-center">
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#paymentModal-{{ $confirmer->id }}">
                            تسجيل دفعة
                        </button>
                        <a href="{{ route('confirmers.history', $confirmer) }}" class="btn btn-info btn-sm">
                            عرض السجل
                        </a>
                    </div>
                     {{-- 🔚 --- نهاية التعديل --- 🔚 --}}
                </td>
            </tr>
            @empty
            <tr>
                <td class="text-center" colspan="8">لا يوجد موظفون بدور "مؤكد طلبيات".</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{ $confirmers->links() }}

{{-- مودال تسجيل الدفع --}}
@foreach ($confirmers as $confirmer)
<div class="modal fade" id="paymentModal-{{ $confirmer->id }}" tabindex="-1" aria-labelledby="paymentModalLabel-{{$confirmer->id}}" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="paymentModalLabel-{{$confirmer->id}}">تسجيل دفعة لـ {{ $confirmer->name }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('confirmers.pay', $confirmer) }}" method="POST">
          @csrf
          <div class="modal-body">
              <div class="mb-3">
                  <label for="amount-{{$confirmer->id}}" class="form-label">المبلغ المدفوع</label>
                  <input type="number" step="0.01" class="form-control" name="amount" id="amount-{{$confirmer->id}}" required>
              </div>
              <div class="mb-3">
                  <label for="payment_date-{{$confirmer->id}}" class="form-label">تاريخ الدفع</label>
                  <input type="date" class="form-control" name="payment_date" id="payment_date-{{$confirmer->id}}" value="{{ now()->toDateString() }}" required>
              </div>
               <div class="mb-3">
                  <label for="notes-{{$confirmer->id}}" class="form-label">ملاحظات</label>
                  <textarea class="form-control" name="notes" id="notes-{{$confirmer->id}}"></textarea>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
            <button type="submit" class="btn btn-primary">حفظ الدفعة</button>
          </div>
      </form>
    </div>
  </div>
</div>
@endforeach

@endsection