@extends('dashboard.dashboard')
@section('title', 'الطلبات')



@include('dashboard.sidebar')
@section('content')

<div class="table-responsive">
    <table class="table table-bordered table-striped mt-4">
        <thead>
            <tr>
                <th>معرف</th>
                <th>المنتج</th>
                <th>رقم الطلب</th>
                <th>السعر</th>
            <th>يوم الطلب</th>
                <th>طريقة الدفع</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $index => $order)
                <tr>
                    <td style="background-color: #303036;color:white;text-align:center">{{ $orders->firstItem() + $index }}</td>
                    <td>
                        @if ($order->product)
                            <a href="{{ route('store.show', $order->product->id) }}">{{ $order->name_product }}</a>
                        @else
                            <a>{{ $order->name_product }}</a>
                        @endif
                    </td>
                    <td>{{ $order->order_number }}</td>
                    <td class="text-center price-color ">{{ $order->total_amount }}$</td>
                    <td>{{ $order->created_at->format('Y-m-d') }}</td>
                    <td class="text-center text-danger font-weight-bolder">{{ $order->method_payment }}</td>
                </tr>
            @empty
                <tr>
                    <td class="text-center" colspan="6">لا توجد طلبات</td>
                </tr>
            @endforelse
        </tbody>
        
    </table>
</div>

{{ $orders->links() }}

@endsection
