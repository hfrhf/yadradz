@extends('dashboard.dashboard')
@include('dashboard.sidebar')
@section('title', 'تفاصيل المنتج: ' . $product->name)

@section('content')
<style>
    body {
        background-color: #f4f7f6;
    }
    .main-panel {
        direction: rtl;
    }
    .product-header {
        background: white;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        margin-bottom: 2rem;
        text-align: center;
    }
    .product-header h1 {
        color: #333;
        font-weight: bold;
    }
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    .stat-card {
        background-color: #fff;
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }
    .stat-card .icon {
        font-size: 2.5rem;
        margin-bottom: 1rem;
    }
    .stat-card .icon-delivered { color: #28a745; }
    .stat-card .icon-returned { color: #dc3545; }
    .stat-card .icon-pending { color: #ffc107; }
    .stat-card .icon-total { color: #17a2b8; }

    .stat-card h3 {
        margin: 0;
        font-size: 1.2rem;
        color: #555;
    }
    .stat-card .stat-number {
        font-size: 2rem;
        font-weight: bold;
        color: #333;
        margin: 0.5rem 0;
    }
    .stat-card .stat-percentage {
        font-size: 1rem;
        color: #777;
    }

    .chart-section {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 2rem;
        align-items: flex-start;
    }
    @media (max-width: 992px) {
        .chart-section {
            grid-template-columns: 1fr;
        }
    }
    .chart-container {
        background: white;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        height: 450px;
    }
    .doughnut-chart-container {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
</style>

<div class="container-fluid py-4">
    <div class="product-header">
        <h1>{{ $product->name }}</h1>
        <p class="text-muted">SKU: {{ $product->sku ?? 'N/A' }}</p>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="icon icon-total"><i class="fas fa-box-open"></i></div>
            <h3>إجمالي الطلبات</h3>
            <p class="stat-number">{{ $stats['totalOrders'] }}</p>
        </div>
        <div class="stat-card">
            <div class="icon icon-delivered"><i class="fas fa-check-circle"></i></div>
            <h3>طلبات مسلمة</h3>
            <p class="stat-number">{{ $stats['deliveredCount'] }}</p>
            <p class="stat-percentage">{{ number_format($stats['deliveredPercentage'], 1) }}%</p>
        </div>
        <div class="stat-card">
            <div class="icon icon-returned"><i class="fas fa-undo"></i></div>
            <h3>طلبات مرتجعة</h3>
            <p class="stat-number">{{ $stats['returnedCount'] }}</p>
            <p class="stat-percentage">{{ number_format($stats['returnedPercentage'], 1) }}%</p>
        </div>
        <div class="stat-card">
            <div class="icon icon-pending"><i class="fas fa-clock"></i></div>
            <h3>قيد الانتظار</h3>
            <p class="stat-number">{{ $stats['pendingCount'] }}</p>
            <p class="stat-percentage">{{ number_format($stats['pendingPercentage'], 1) }}%</p>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="chart-section">
        <div class="chart-container doughnut-chart-container">
             <h4 class="mb-4 text-center">نسبة حالات الطلبات</h4>
            <canvas id="productStatusChart"></canvas>
        </div>
        <div class="chart-container">
            <h4 class="mb-4 text-center">أداء المبيعات (آخر 30 يومًا)</h4>
            <canvas id="productSalesTrendChart"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
{{-- Font Awesome for icons --}}
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Doughnut Chart for Order Statuses
    const doughnutCtx = document.getElementById('productStatusChart').getContext('2d');
    new Chart(doughnutCtx, {
        type: 'doughnut',
        data: {
            labels: ['مسلمة', 'مرتجعة', 'قيد الانتظار'],
            datasets: [{
                data: [
                    {{ $stats['deliveredCount'] }},
                    {{ $stats['returnedCount'] }},
                    {{ $stats['pendingCount'] }}
                ],
                backgroundColor: [
                    'rgba(40, 167, 69, 0.8)',  // Delivered - Green
                    'rgba(220, 53, 69, 0.8)',   // Returned - Red
                    'rgba(255, 193, 7, 0.8)'    // Pending - Yellow
                ],
                borderColor: '#fff',
                borderWidth: 3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        font: {
                            size: 14
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.label || '';
                            if (label) {
                                label += ': ';
                            }
                            const value = context.raw;
                            const total = context.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                            const percentage = total > 0 ? ((value / total) * 100).toFixed(1) + '%' : '0%';
                            return `${label} ${value} (${percentage})`;
                        }
                    }
                }
            }
        }
    });

    // 2. Line Chart for Sales Trend
    const lineCtx = document.getElementById('productSalesTrendChart').getContext('2d');
    new Chart(lineCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartData['labels']) !!},
            datasets: [{
                label: 'الطلبات المسلمة',
                data: {!! json_encode($chartData['values']) !!},
                backgroundColor: 'rgba(40, 167, 69, 0.1)',
                borderColor: 'rgba(40, 167, 69, 1)',
                borderWidth: 2,
                fill: true,
                tension: 0.3,
                pointBackgroundColor: 'rgba(40, 167, 69, 1)',
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'عدد الطلبات'
                    }
                },
                x: {
                   title: {
                        display: true,
                        text: 'التاريخ'
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
});
</script>
@endsection