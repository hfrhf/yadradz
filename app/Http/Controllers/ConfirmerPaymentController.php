<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\ConfirmerPayment;
use App\Http\Requests\StorePaymentRequest;
use App\Notifications\PaymentReceivedNotification;

class ConfirmerPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StorePaymentRequest $request, User $user)
{
    $validated = $request->validated();

    // 1. إنشاء الدفعة وحفظها في متغير
    $payment = $user->payments()->create($validated);

    // ==========================================================
    // ==           بداية الجزء المضاف لإرسال الإشعار           ==
    // ==========================================================

    // 2. إرسال إشعار للمستخدم (المؤكد) الذي استلم الدفعة
    $user->notify(new PaymentReceivedNotification($payment->amount));

    // ==========================================================
    // ==            نهاية الجزء المضاف لإرسال الإشعار           ==
    // ==========================================================

    return back()->with('success', 'تم تسجيل الدفعة بنجاح.');
}

    /**
     * Display the specified resource.
     */
    public function show(ConfirmerPayment $confirmerPayment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ConfirmerPayment $confirmerPayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ConfirmerPayment $confirmerPayment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ConfirmerPayment $confirmerPayment)
    {
        //
    }
}
