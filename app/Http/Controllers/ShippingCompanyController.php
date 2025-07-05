<?php

namespace App\Http\Controllers;

use App\Models\ShippingCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShippingCompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = ShippingCompany::all();
        return view('shipping_company.index', compact('companies'));
    }

    public function edit(ShippingCompany $shippingCompany)
    {
        return view('shipping_company.edit', compact('shippingCompany'));
    }

    public function update(Request $request, ShippingCompany $shippingCompany)
    {
        // استخراج الإعدادات من الطلب
        // قمنا بعمل `filter` لإزالة أي حقول فارغة يرسلها الفورم
        $settings = array_filter($request->input('settings', []));

        $shippingCompany->update([
            'settings' => $settings,
        ]);

        return redirect()->route('shippingcompany.index')->with('success', 'تم تحديث إعدادات الشركة بنجاح.');
    }

    public function activate(ShippingCompany $shippingCompany)
    {
        DB::transaction(function () use ($shippingCompany) {
            // جعل كل الشركات غير مفعلة
            ShippingCompany::where('is_active', true)->update(['is_active' => false]);

            // تفعيل الشركة المحددة
            $shippingCompany->update(['is_active' => true]);
        });

        return redirect()->route('shippingcompany.index')->with('success', "تم تفعيل شركة {$shippingCompany->name} بنجاح.");
    }
    public function deactivate(ShippingCompany $shippingCompany)
    {
        $shippingCompany->update(['is_active' => false]);

        return redirect()->route('shippingcompany.index')->with('success', "تم إلغاء تفعيل شركة {$shippingCompany->name}.");
    }
}
