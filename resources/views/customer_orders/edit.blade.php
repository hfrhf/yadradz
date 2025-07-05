@extends('dashboard.dashboard')

@section('title', 'تعديل حالة الطلب')

@include('dashboard.sidebar')

@section('content')

<div class="container-fluid px-3 px-md-4">
    <div class="card card-custom">
        <div class="card-header">
            <h4 class="card-title">تعديل حالة الطلب</h4>
        </div>
        <div class="card-body p-4">

            <form action="{{ route('customer-orders.update', $customer_order->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="status" class="form-label">حالة الطلب:</label>
                    <select name="status" id="status" class="form_control_custom" required>
                        <option value="pending" {{ $customer_order->status == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                        <option value="confirmed" {{ $customer_order->status == 'confirmed' ? 'selected' : '' }}>تم التأكيد</option>
                        <option value="unconfirmed" {{ $customer_order->status == 'unconfirmed' ? 'selected' : '' }}>فشل التأكيد</option>
                        <option value="processing" {{ $customer_order->status == 'processing' ? 'selected' : '' }}>قيد التجهيز</option>
                        <option value="shipped" {{ $customer_order->status == 'shipped' ? 'selected' : '' }}>تم الشحن</option>
                        <option value="out_for_delivered" {{ $customer_order->status == 'out_for_delivered' ? 'selected' : '' }}>في طريقه الى الزبون</option>
                        <option value="delivered" {{ $customer_order->status == 'delivered' ? 'selected' : '' }}>تم التسليم</option>
                        <option value="cancelled_store" {{ $customer_order->status == 'cancelled_store' ? 'selected' : '' }}>ملغي من قبل المتجر</option>
                        <option value="cancelled_customer" {{ $customer_order->status == 'cancelled_customer' ? 'selected' : '' }}>ملغي من قبل الزبون</option>
                        <option value="returned" {{ $customer_order->status == 'returned' ? 'selected' : '' }}>مرتجعة</option>
                    </select>
                </div>

                @if($customer_order->product->quantity < $customer_order->quantity)
                    <div class="alert alert-warning mt-3">
                        <strong>تنبيه:</strong> الكمية المتوفرة من المنتج غير كافية لتلبية هذا الطلب. يرجى تحديث كمية المنتج قبل تغيير الحالة إلى "تم التسليم".
                    </div>
                @endif

                <div class="d-flex justify-content-start gap-2 mt-4">
                    <button type="submit" class="btn btn-lg" style="background-color: #6f42c1; color: white; font-weight: bold;">تحديث الحالة</button>
                    <a href="{{ route('customer-orders.index') }}" class="btn btn-lg btn-outline-secondary">رجوع</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection