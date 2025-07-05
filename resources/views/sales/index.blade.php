@extends('dashboard.dashboard')
@section('title', 'المبيعات')

<style>
    .table th, .table td {
        vertical-align: middle;
    }
    .table img {
        display: block;
        margin: auto;
        max-width: 100px;
        max-height: 100px;
    }
    .table-container {
        margin-top: 50px;
    }
    .table-description {
        max-width: 300px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>

@include('dashboard.sidebar')
@section('content')

<div class="table-responsive">
    <table class="table table-bordered table-striped mt-4">
        <thead>
            <tr>
                <th>#</th>
                <th> رقم الطلب</th>
                <th>اسم المستخدم</th>
                <th>البريد الالكتروني</th>
                <th>المنتج</th>
                <th>السعر</th>
                <th>طريقة الدفع</th>
                <th>يوم البيع</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $index => $order)
                
                    <tr>
                        <td style="background-color: #303036;color:white;text-align:center" >{{$orders->firstItem() + $loop->index}}</td>
                        <td>{{ $order->order_number }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td>{{ $order->user->email }}</td>
                        <td>
                            @if ($order->product)
                            <a href="{{ route('store.show', $order->product->id) }}">{{ $order->name_product }}</a>
                        @else
                            <a>{{ $order->name_product }}</a>
                        @endif
                        </td>
                        <td class="price-color">${{ number_format($order->total_amount) }}</td>
                        <td class="text-center text-danger font-weight-bolder">{{ $order->method_payment }}</td>
                        <td>{{ $order->created_at->format('Y-m-d') }}</td>
                    </tr>
                    
                
            @endforeach
            <tr style="height: 20px !important;" >
                <td class="bg-success text-white" colspan="6" >اجمالي المبيعات</td>
                <td class="bg-success text-white" colspan="6" > {{$totalSales}}$</td>
            </tr>

        </tbody>
    </table>
</div>
<div>
    {{$orders->links()}}
</div>




@endsection
