@extends('dashboard.dashboard')
@section('title','تفاصيل الطلب')
@include('dashboard.sidebar')

@section('content')

{{-- Custom Styles for the new Order Details Page --}}
<style>
    body {
        background-color: #f8f9fa; /* A light background for better contrast */
    }
    .order-details-container {
        max-width: 900px;
        margin: auto;
    }
    .details-card {
        border: none;
        border-radius: 0.75rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        margin-bottom: 1.5rem;
        overflow: hidden; /* Ensures rounded corners are applied to children */
    }
    .card-header-custom {
        background-color: #fff;
        border-bottom: 1px solid #e9ecef;
        padding: 1rem 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .card-header-custom h5 {
        margin-bottom: 0;
        font-weight: 600;
        color: #343a40;
    }
    .order-id {
        font-family: monospace;
        font-weight: bold;
        color: #6f42c1;
    }
    .status-badge {
        font-size: 0.9rem;
        padding: 0.5em 1em;
        border-radius: 50px;
    }
    .product-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .product-image {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 0.5rem;
        border: 1px solid #e9ecef;
    }
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }
    .info-item {
        background-color: #f8f9fa;
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
    }
    .info-item .label {
        font-size: 0.8rem;
        color: #6c757d;
        margin-bottom: 0.25rem;
        display: block;
    }
    .info-item .value {
        font-weight: 600;
        color: #212529;
        word-wrap: break-word; /* For long user agents */
    }
    .attribute-display {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .color-swatch {
        width: 22px;
        height: 22px;
        border-radius: 50%;
        border: 2px solid white;
        box-shadow: 0 0 0 1px #ccc;
    }
    .size-badge {
        font-size: 0.9rem;
        font-weight: 500;
        padding: 0.2em 0.6em;
    }
    .price-summary .list-group-item {
        border-color: #e9ecef;
    }
</style>

<div class="container-fluid py-4 order-details-container">

    {{-- Order Header --}}
    <div class="card details-card">
        <div class="card-header-custom">
            <div>
                <h5 class="mb-1">تفاصيل الطلب</h5>
                <p class="text-muted small mb-0">تاريخ الطلب: {{ $customer_order->created_at->format('d M Y, H:i') }}</p>
            </div>
            <div class="text-end">
                <span class="order-id">#{{ $customer_order->order_code }}</span>
                <div><span class="badge status-badge bg-gradient-warning">{{ $customer_order->status }}</span></div>
            </div>
        </div>
    </div>

    {{-- Product & Attributes Card --}}
    <div class="card details-card">
        <div class="card-body p-4">
            <div class="product-info mb-4">
                <img src="{{ asset('storage/'.($customer_order->product->image ?? '')) }}" alt="{{ $customer_order->product->name ?? '' }}" class="product-image" onerror="this.onerror=null;this.src='https://placehold.co/80x80/6f42c1/white?text=Image';">
                <div>
                    <h6 class="mb-1 fw-bold">{{ $customer_order->product->name ?? 'منتج غير معروف' }}</h6>
                    <p class="mb-0 text-muted">الكمية: {{ $customer_order->quantity }}</p>
                </div>
            </div>

            @if($customer_order->attribute_combination)
            <h6 class="small text-uppercase text-muted mb-3">الخصائص المختارة</h6>
            <div class="info-grid">
                @foreach(json_decode($customer_order->attribute_combination, true) as $combination)
                    @php
                        $attribute = \App\Models\Attribute::find($combination['attribute_id']);
                        $attributeValue = \App\Models\AttributeValue::find($combination['value_id']);
                    @endphp
                    @if($attribute && $attributeValue)
                    <div class="info-item">
                        <span class="label">{{ $attribute->localized_name }}</span>
                        <div class="value attribute-display">
                            @if ($attribute->name === 'اللون')
                                <span class="color-swatch" style="background-color: {{ $attributeValue->value }};"></span>
                                <span style="font-family: monospace;">{{ $attributeValue->value }}</span>
                            @elseif ($attribute->name === 'الحجم')
                                <span class="badge size-badge bg-secondary">{{ $attributeValue->value }}</span>
                            @else
                                <span>{{ $attributeValue->value }}</span>
                            @endif
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
            @endif
        </div>
    </div>

    {{-- Customer & Shipping Card --}}
    <div class="card details-card">
        <div class="card-body p-4">
            <div class="row">
                <div class="col-md-6 mb-4 mb-md-0">
                    <h6 class="small text-uppercase text-muted mb-3"><i class="fas fa-user me-2"></i>الزبون</h6>
                    <div class="info-item"><span class="label">الاسم الكامل</span><p class="value mb-0">{{ $customer_order->fullname }}</p></div>
                    <div class="info-item mt-2"><span class="label">رقم الهاتف</span><p class="value mb-0" dir="ltr">{{ $customer_order->phone }}</p></div>
                    <div class="info-item mt-2"><span class="label">البريد الإلكتروني</span><p class="value mb-0">{{ $customer_order->email ?? '-' }}</p></div>
                </div>
                <div class="col-md-6">
                    <h6 class="small text-uppercase text-muted mb-3"><i class="fas fa-shipping-fast me-2"></i>عنوان الشحن</h6>
                    <div class="info-item"><span class="label">الولاية والمدينة</span><p class="value mb-0">{{ $customer_order->state->state }}, {{ $customer_order->municipality->name }}</p></div>
                    <div class="info-item mt-2"><span class="label">العنوان الكامل</span><p class="value mb-0">{{ $customer_order->address }}</p></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Pricing Card --}}
    <div class="card details-card">
         <div class="card-body p-4 price-summary">
            <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between align-items-center px-0"><span class="text-muted">سعر المنتجات</span><span>{{ number_format($customer_order->total_price + $customer_order->discount_value - $customer_order->delivery_price, 2) }} دج</span></li>
                <li class="list-group-item d-flex justify-content-between align-items-center px-0"><span class="text-muted">سعر التوصيل</span><span>{{ number_format($customer_order->delivery_price, 2) }} دج</span></li>
                @if($customer_order->coupon_code)
                <li class="list-group-item d-flex justify-content-between align-items-center px-0 text-success"><span class="text-success">الخصم ({{$customer_order->coupon_code}})</span><span>-{{ number_format($customer_order->discount_value, 2) }} دج</span></li>
                @endif
                <li class="list-group-item d-flex justify-content-between align-items-center px-0 fw-bold fs-5 border-0"><span>الإجمالي</span><span class="text-primary">{{ number_format($customer_order->total_price, 2) }} دج</span></li>
            </ul>
        </div>
    </div>

    {{-- Technical Details Card --}}
    <div class="card details-card">
        <div class="card-body p-4">
            <h6 class="small text-uppercase text-muted mb-3"><i class="fas fa-laptop-code me-2"></i>تفاصيل تقنية</h6>
            <div class="info-grid">
                <div class="info-item"><span class="label">IP Address</span><p class="value mb-0">{{ $customer_order->ip_address }}</p></div>
                <div class="info-item"><span class="label">Device Type</span><p class="value mb-0">{{ $customer_order->device_type ?? '-' }}</p></div>
                <div class="info-item"><span class="label">User Agent</span><p class="value mb-0 ">{{ $customer_order->user_agent }}</p></div>

            </div>
        </div>
    </div>

    {{-- Actions --}}
    <div class="d-flex justify-content-end align-items-center gap-2 flex-wrap">
        <button class="btn btn-outline-dark"><i class="fas fa-print me-1"></i> طباعة</button>
        <button class="btn btn-danger"><i class="fas fa-times-circle me-1"></i> إلغاء الطلب</button>
        <button class="btn btn-primary"><i class="fas fa-check-circle me-1"></i> تأكيد الطلب</button>
        <a href="{{ route('customer-orders.index') }}" class="btn btn-secondary">الرجوع للقائمة</a>
    </div>

</div>
@endsection
