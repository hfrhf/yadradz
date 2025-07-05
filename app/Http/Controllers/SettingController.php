<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use App\Traits\PermissionMiddlewareTrait;
use App\Http\Requests\UpdateSettingRequest;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use PermissionMiddlewareTrait;
    public function __construct()
    {

        $this->applyPermissionMiddleware('setting'); // أو 'order' أو 'category' حسب الحاجة
    }
    public function index()
    {
        $setting=Cache::remember('setting', 86400, function () {
            return Setting::first();
        });

        return view('settings.index',compact('setting'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


    }


    /**
     * Display the specified resource.
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Setting $setting)
    {

        return view('settings.edit',compact('setting'));
    }


    /**
     * Update the specified resource in storage.
     */
      public function update(UpdateSettingRequest $request)
    {
        $validated = $request->validated();

        // الحصول على الإعدادات أو إنشاء سجل جديد إذا لم يكن موجودًا
        $setting = Setting::firstOrNew();

        // معالجة رفع صورة الهيدر
        if ($request->hasFile('header_image')) {
            // حذف الصورة القديمة إذا كانت موجودة
            if ($setting->header_image && Storage::disk('public')->exists($setting->header_image)) {
                Storage::disk('public')->delete($setting->header_image);
            }
            $validated['header_image'] = $request->file('header_image')->store('settings', 'public');
        }

        // معالجة رفع الشعار
        if ($request->hasFile('logo')) {
            // حذف الشعار القديم إذا كان موجودًا
            if ($setting->logo && Storage::disk('public')->exists($setting->logo)) {
                Storage::disk('public')->delete($setting->logo);
            }
            $validated['logo'] = $request->file('logo')->store('settings', 'public');
        }

        // تحديث البيانات أو إنشاء السجل
        $setting->fill($validated)->save();

        // مسح الكاش لتطبيق التغييرات
        Cache::forget('setting');
        Cache::forget('site_settings');
        Cache::forget('store_language');

        return redirect()->route('settings.index')->with('success', 'تم تحديث الإعدادات بنجاح!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
