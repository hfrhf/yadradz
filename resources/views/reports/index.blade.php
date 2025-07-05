@extends('dashboard.dashboard')
@include('dashboard.sidebar')
@section('title', 'التقارير العامة')

@section('content')
<style>
    .chart-container {
        position: relative;
        margin: 2rem auto;
        height: 400px;
        width: 90%;
        max-width: 1000px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }
</style>

<div class="container-fluid" style="direction: rtl;">
    <h1 class="text-center mb-4">التقارير العامة (آخر 30 يومًا)</h1>

    {{-- تم وضع كل رسم بياني في حاوية منفصلة لتحسين التنسيق --}}
    <div class="chart-container">
        <canvas id="visitsChart"></canvas>
    </div>

    <div class="chart-container">
        <canvas id="salesChart"></canvas>
    </div>

    <div class="chart-container">
        <canvas id="ordersChart"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // استخدام الدالة لتجنب تكرار الكود
    function createChart(canvasId, chartType, label, data, labels, color, yAxisLabel) {
        const ctx = document.getElementById(canvasId).getContext('2d');
        const [bgColor, borderColor] = color;

        new Chart(ctx, {
            type: chartType,
            data: {
                labels: labels, // استخدام مصفوفة التواريخ الموحدة
                datasets: [{
                    label: label,
                    data: data,
                    backgroundColor: bgColor,
                    borderColor: borderColor,
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 3,
                    pointHoverRadius: 5,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'التاريخ',
                            font: { size: 14 }
                        },
                        grid: {
                            display: false,
                        },
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: yAxisLabel,
                            font: { size: 14 }
                        },
                        grid: {
                            color: 'rgba(200, 200, 200, 0.2)',
                        },
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            font: { size: 16, weight: 'bold' },
                            padding: 20,
                        }
                    },
                    tooltip: {
                        backgroundColor: '#333',
                        titleFont: { size: 14 },
                        bodyFont: { size: 12 },
                        padding: 10,
                        cornerRadius: 5,
                    }
                },
                animation: {
                    duration: 1000,
                    easing: 'easeInOutCubic',
                }
            }
        });
    }

    const sharedLabels = {!! json_encode($dates) !!};

    // 1. مخطط الزيارات
    createChart(
        'visitsChart',
        'line',
        'عدد زيارات الموقع اليومية',
        {!! json_encode($visitsCounts) !!},
        sharedLabels,
        ['rgba(54, 162, 235, 0.2)', 'rgba(54, 162, 235, 1)'],
        'عدد الزيارات'
    );

    // 2. مخطط الإيرادات
    createChart(
        'salesChart',
        'line',
        'إجمالي الإيرادات اليومية',
        {!! json_encode($revenues) !!},
        sharedLabels,
        ['rgba(75, 192, 192, 0.2)', 'rgba(75, 192, 192, 1)'],
        'الإيرادات'
    );

    // 3. مخطط الطلبات المسلمة
    createChart(
        'ordersChart',
        'bar',
        'عدد المبيعات المسلمة اليومية',
        {!! json_encode($ordersCounts) !!},
        sharedLabels,
        ['rgba(153, 102, 255, 0.2)', 'rgba(153, 102, 255, 1)'],
        'عدد المبيعات'
    );
</script>
@endsection
