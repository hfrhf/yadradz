<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerOrders;

class ThankYouController extends Controller
{
    // ThankYouController.php
public function index(Request $request)
{
    $orderCode = $request->order_code;

    if (!$orderCode) {
        return redirect('/');
    }

    $order = CustomerOrders::where('order_code', $orderCode)->first();

    if (!$order) {
        return redirect('/');
    }

    return view('thankyou.index', compact('order'));
}

}
