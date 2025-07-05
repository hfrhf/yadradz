<?php

namespace App\Http\Controllers\Marketing;

use Illuminate\Http\Request;
use App\Models\MarketingTracker;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGoogleTagManagerRequest;
use App\Http\Requests\UpdateGoogleTagManagerRequest;

class GoogleTagManagerController extends Controller
{
    public function index()
    {
        $tracker = MarketingTracker::where('type', 'gtm')->first();
        return view('marketing.gtm.index', compact('tracker'));
    }

    public function create()
    {
        return view('marketing.gtm.create');
    }

    public function store(StoreGoogleTagManagerRequest $request)
    {
        if (MarketingTracker::where('type', 'gtm')->exists()) {
            return redirect()->route('gtm.index')->with('error', 'إعدادات Google Tag Manager موجودة بالفعل.');
        }

        MarketingTracker::create([
            'identifier' => $request->validated()['identifier'],
            'type'       => 'gtm',
            'is_active'  => true,
        ]);

        return redirect()->route('gtm.index')->with('success', 'تمت إضافة إعدادات Google Tag Manager بنجاح.');
    }

    public function update(UpdateGoogleTagManagerRequest $request, MarketingTracker $gtm)
    {
        $gtm->update($request->validated());

        return redirect()->route('gtm.index')->with('success', 'تم تحديث إعدادات Google Tag Manager بنجاح.');
    }
}
