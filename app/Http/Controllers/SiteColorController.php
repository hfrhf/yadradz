<?php

namespace App\Http\Controllers;


use App\Models\SiteColor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Traits\PermissionMiddlewareTrait;
use App\Http\Requests\UpdateSiteColorRequest;

class SiteColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use PermissionMiddlewareTrait;
    public function __construct()
    {

        $this->applyPermissionMiddleware('colors'); // أو 'order' أو 'category' حسب الحاجة
    }
    public function index()
    {
        $siteColor = Cache::remember('colors', 86400, function () {
            return SiteColor::first();
        });

        return view('colors.index', compact('siteColor'));
    }
    public function edit(SiteColor $color)
    {

        return view('colors.edit',compact('color'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSiteColorRequest $request)
    {
        // التحقق من الصحة يتم تلقائيًا عبر UpdateSiteColorRequest
        $validated = $request->validated();

        // تحديث السجل الموجود أو إنشاء واحد جديد إذا لم يكن موجودًا
        SiteColor::updateOrCreate([], $validated);

        // مسح الكاش لتطبيق التغييرات فورًا
        Cache::forget('colors');
        Cache::forget('site_colors');

        return redirect()->route('colors.index')->with('success', 'تم تحديث الألوان بنجاح.');
    }

}
