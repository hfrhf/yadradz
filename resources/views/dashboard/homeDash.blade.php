@extends('dashboard.dashboard')
@include('dashboard.sidebar')
<style>
    /* Google Fonts - Tajawal */
@import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700&display=swap');

:root {
    --primary-color: #4e73df;
    --secondary-color: #858796;
    --success-color: #1cc88a;
    --info-color: #36b9cc;
    --warning-color: #f6c23e;
    --danger-color: #e74a3b;
    --light-color: #f8f9fc;
    --dark-color: #5a5c69;
}
.th-home-dash{
    background-color: white !important ;
    color: #FAFAFA;
}


.card-header-homedash {
    background-color: #fff;
    border-bottom: 1px solid #e3e6f0;
    padding: 1rem 1.25rem;
    font-weight: 700;
}

.card-body-homedash {
    padding: 1.25rem;
}



/* Tables */
.table {
    margin-bottom: 0;
}

.table thead th {
    border-top: none;
    border-bottom: 2px solid #e3e6f0;
    font-weight: 700;
    font-size: 0.8rem;
    text-transform: uppercase;
    color: #4e73df;
    padding: 1rem;
}

.table td {
    padding: 1rem;
    vertical-align: middle;
    border-top: 1px solid #e3e6f0;
}

/* Badges */
.badge {
    font-weight: 500;
    padding: 0.35em 0.65em;
    font-size: 0.75em;
}

/* Buttons */
.btn {
    border-radius: 0.35rem;
    font-weight: 500;
    padding: 0.5rem 1rem;
    font-size: 0.85rem;
}

.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
}





</style>
@section('title', Auth::user()->name)

@php
    use App\Models\Visits;
    use App\Models\CustomerOrders;
    use App\Models\Product;
    use Carbon\Carbon;

    $currentMonth = Carbon::now()->month;
    $currentYear = Carbon::now()->year;

    $totalOrders = CustomerOrders::count();

    $totalOrdersToday = CustomerOrders::whereDate('created_at', Carbon::today())->count();
    $totalProducts = Product::count();
    $totalRevenue =CustomerOrders::whereYear('created_at', now()->year)
                          ->whereMonth('created_at', now()->month)
                          ->selectRaw('SUM(total_price) - SUM(delivery_price) as net_revenue')
                          ->first()
                          ->net_revenue;
    $totalRevenueToday = CustomerOrders::whereDate('created_at', Carbon::today())->sum('total_price') -CustomerOrders::whereDate('created_at', Carbon::today())->sum('delivery_price');
    $totalVisits = Visits::whereMonth('created_at', $currentMonth)->whereYear('created_at', $currentYear)->count();
    $recentOrders = CustomerOrders::latest()
        ->take(5)
        ->get();
@endphp

@section('content')
<div class="container">
    <div class="row justify-content-center">
        {{-- إجمالي المبيعات --}}
        <div class="col-12 col-lg-4 col-md-6 mb-4">
            <div class="stat-card bg-primary-custom text-white p-3 text-center d-flex flex-column">
                @can('order_access')
                    <h1>إجمالي الطلبيات:</h1>
                    <h2 class="extrabold">{{ $totalOrders }}</h2>
                @endcan
            </div>
        </div>

        {{-- إجمالي مبيعات اليوم --}}
        <div class="col-12 col-lg-4 col-md-6 mb-4">
            <div class="stat-card bg-success-custom text-white p-3 text-center d-flex flex-column">
                @can('order_access')
                    <h1>إجمالي طلبات اليوم:</h1>
                    <h2 class="extrabold">{{ $totalOrdersToday }}</h2>
                @endcan
            </div>
        </div>

        {{-- إجمالي المنتجات --}}
        <div class="col-12 col-lg-4 col-md-6 mb-4">
            <div class="stat-card bg-warning-custom text-white p-3 text-center d-flex flex-column">
                @can('product_access')
                    <h1>إجمالي المنتوجات المضافة:</h1>
                    <h2 class="extrabold">{{ $totalProducts }}</h2>
                @endcan
            </div>
        </div>

        {{-- إجمالي الإيرادات --}}
        <div class="col-12 col-lg-4 col-md-6 mb-4">
            <div class="stat-card bg-cyan-custom text-white p-3 text-center d-flex flex-column">
                @can('report_access')
                    <h1>إجمالي الإيرادات:</h1>
                    <h2 class="extrabold">{{ number_format($totalRevenue, 2) }} دج</h2>
                @endcan
            </div>
        </div>

        {{-- إيرادات اليوم --}}
        <div class="col-12 col-lg-4 col-md-6 mb-4">
            <div class="stat-card bg-danger-custom text-white p-3 text-center d-flex flex-column">
                @can('report_access')
                    <h1>إجمالي إيرادات اليوم:</h1>
                    <h2 class="extrabold">{{ number_format($totalRevenueToday, 2) }} دج</h2>
                @endcan
            </div>
        </div>

        {{-- الزيارات الشهرية --}}
        <div class="col-12 col-lg-4 col-md-6 mb-4">
            <div class="stat-card bg-dark text-white p-3 text-center d-flex flex-column">
                @can('report_access')
                    <h1>إجمالي الزيارات الشهرية:</h1>
                    <h2 class="extrabold">{{ $totalVisits }}</h2>
                @endcan
            </div>
        </div>
    </div>
      <!-- Recent Orders -->
      <div class="card mb-4">
        <div class="card-header-homedash d-flex justify-content-between align-items-center">
            <h6 class="card-title mb-0">أحدث الطلبات</h6>
            <a href='{{route("customer-orders.index")}}' class="btn btn-sm btn-outline-primary">عرض الكل</a>
        </div>
        <div class="card-body-homedash">
            <div class="table-responsive ">
                <table class="table table-hover ">
                    <thead>
                        <tr>
                            <th class="th-home-dash">رقم الطلب</th>
                            <th class="th-home-dash">العميل</th>
                            <th class="th-home-dash">التاريخ</th>
                            <th class="th-home-dash">المجموع</th>
                            <th class="th-home-dash">الحالة</th>
                            <th class="th-home-dash">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recentOrders as $order)
                            <tr>
                                <td>{{ $order->order_code }}</td>
                                <td>{{ $order->fullname}}</td>
                                <td>{{ $order->created_at->format('d M Y') }}</td>
                                <td>{{ number_format($order->total_price, 2) }} دج</td>
                                <td>
                                    @php
                                        $status = $order->status;
                                        $badgeClass = match($status) {
                                            'delivered' => 'bg-success-custom',
                                            'processing' => 'bg-info',
                                            'shipping' => 'bg-warning-custom',
                                            'cancelled', 'returned' => 'bg-danger-custom',
                                            default => 'bg-secondary'
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">
                                        {{ $status}}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('customer-orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">عرض</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">لا توجد طلبات حتى الآن.</td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>

@endsection
