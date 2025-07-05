<?php

namespace App\Http\Controllers;

use App\Models\CustomerOrders;
use App\Models\Product;
use App\Models\Visits;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // --- الخطوة 1: إعداد النطاق الزمني لآخر 30 يومًا ---
        $endDate = Carbon::today();
        $startDate = Carbon::today()->subDays(29);
        $period = CarbonPeriod::create($startDate, $endDate);

        // تحويل الفترة إلى مصفوفة من التواريخ بصيغة 'Y-m-d'
        $dateRange = array_map(function ($date) {
            return $date->format('Y-m-d');
        }, $period->toArray());


        // --- الخطوة 2: جلب البيانات وتجهيزها ---

        // إعداد بيانات المبيعات (حسب تاريخ إنشاء الطلب)
        $salesData = CustomerOrders::where('created_at', '>=', $startDate->startOfDay())
            ->select(
                DB::raw("SUM(total_price) - SUM(delivery_price) as revenue"),
                DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as date")
            )
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))
            ->get()
            ->keyBy('date');

        // إعداد بيانات الطلبات المسلمة (حسب تاريخ التسليم)
        $ordersData = CustomerOrders::where('status', 'delivered')
            ->where('delivered_at', '>=', $startDate->startOfDay())
            ->select(
                DB::raw("COUNT(*) as orders_count"),
                DB::raw("DATE_FORMAT(delivered_at, '%Y-%m-%d') as date")
            )
            ->groupBy(DB::raw("DATE_FORMAT(delivered_at, '%Y-%m-%d')"))
            ->get()
            ->keyBy('date');

        // إعداد بيانات زيارات الموقع (حسب تاريخ الزيارة)
        $visitsData = Visits::where('visited_at', '>=', $startDate->startOfDay())
            ->select(
                DB::raw("COUNT(*) as visits_count"),
                DB::raw("DATE_FORMAT(visited_at, '%Y-%m-%d') as date")
            )
            ->groupBy(DB::raw("DATE_FORMAT(visited_at, '%Y-%m-%d')"))
            ->get()
            ->keyBy('date');


        // --- الخطوة 3: ملء مصفوفات البيانات بناءً على النطاق الزمني الموحد ---
        $revenues = [];
        $ordersCounts = [];
        $visitsCounts = [];

        foreach ($dateRange as $date) {
            $revenues[] = $salesData[$date]->revenue ?? 0;
            $ordersCounts[] = $ordersData[$date]->orders_count ?? 0;
            $visitsCounts[] = $visitsData[$date]->visits_count ?? 0;
        }

        // --- الخطوة 4: إرسال البيانات الموحدة إلى الـ view ---
        return view('reports.index', [
            'dates' => $dateRange,
            'revenues' => $revenues,
            'ordersCounts' => $ordersCounts,
            'visitsCounts' => $visitsCounts,
        ]);
    }
}