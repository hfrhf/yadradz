<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod; // ✨ --- إضافة مهمة --- ✨

class ConfirmerController extends Controller
{
    public function index()
    {
        $confirmers = User::role('confirmer')
            ->withSum('payments', 'amount')
            ->paginate(15);

        foreach ($confirmers as $confirmer) {

            // يتم حساب عدد الطلبات لكل الموظفين بغض النظر عن نظام الدفع
            $confirmer->loadCount([
                'handledOrders as confirmed_orders_count' => fn($q) => $q->where('status', 'confirmed'),
                'handledOrders as canceled_orders_count' => fn($q) => $q->whereIn('status', ['cancelled_store', 'cancelled_customer']),
            ]);

            if ($confirmer->confirmer_payment_type === 'monthly_salary') {

                // تحقق من وجود يوم دفع وراتب محددين
                if (is_null($confirmer->salary_payout_day) || is_null($confirmer->confirmer_payment_rate)) {
                    $confirmer->net_due_amount = 0;
                    continue;
                }

                $creationDate = Carbon::parse($confirmer->created_at);
                $endDate = now();

                // ✨ --- سطر مؤقت للاختبار --- ✨
                // لإختبار تراكم الديون، قم بإزالة التعليق من السطر التالي لتضيف شهراً واحداً إلى التاريخ الحالي
                // $endDate = now()->addMonth()->addDays(90);

                $period = CarbonPeriod::create($creationDate, '1 month', $endDate);

                $totalSalaryDue = 0;

                foreach ($period as $dt) {
                    // 1. حساب تاريخ الاستحقاق المحتمل لهذا الشهر
                    $payoutDateForMonth = $dt->copy()->day($confirmer->salary_payout_day);

                    // 2. التحقق من الشروط
                    $payoutDayHasPassed = $endDate->gte($payoutDateForMonth);
                    $payoutDayIsAfterHiring = $payoutDateForMonth->gte($creationDate);

                    // 3. إذا تحققت كل الشروط، أضف الراتب للمستحقات
                    if ($payoutDayHasPassed && $payoutDayIsAfterHiring) {
                        $totalSalaryDue += $confirmer->confirmer_payment_rate;
                    }
                }

                $totalPaymentsMade = $confirmer->payments_sum_amount ?? 0;
                $confirmer->net_due_amount = $totalSalaryDue - $totalPaymentsMade;

            } elseif ($confirmer->confirmer_payment_type === 'per_order') {

                $confirmed_earnings = $confirmer->confirmed_orders_count * ($confirmer->confirmer_payment_rate ?? 0);
                $canceled_earnings = $confirmer->canceled_orders_count * ($confirmer->confirmer_cancellation_rate ?? 0);
                $total_earnings = $confirmed_earnings + $canceled_earnings;

                $confirmer->net_due_amount = $total_earnings - ($confirmer->payments_sum_amount ?? 0);

            } else {
                $confirmer->net_due_amount = 0;
            }
        }

        return view('confirmers.index', compact('confirmers'));
    }

    public function history(User $user)
    {
        $payments = $user->payments()->latest('payment_date')->paginate(15);
        return view('confirmers.history', compact('user', 'payments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
