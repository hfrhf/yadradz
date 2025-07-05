<?php

namespace App\Http\Controllers\Marketing;

use Illuminate\Http\Request;
use App\Models\MarketingTracker;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGoogleAnalyticsTrackerRequest;
use App\Http\Requests\UpdateGoogleAnalyticsTrackerRequest;

class GoogleAnalyticsController extends Controller
{
    public function index()
    {
        $tracker = MarketingTracker::where('type', 'ga')->first();
        return view('marketing.ga.index', compact('tracker'));
    }

    public function create()
    {
        return view('marketing.ga.create');
    }

    public function store(StoreGoogleAnalyticsTrackerRequest $request)
    {
        // منع إنشاء إعداد جديد إذا كان هناك واحد بالفعل
        if (MarketingTracker::where('type', 'ga')->exists()) {
            return redirect()->route('ga.index')->with('error', 'إعدادات Google Analytics موجودة بالفعل.');
        }

        MarketingTracker::create([
            'identifier' => $request->validated()['identifier'],
            'type'       => 'ga',
            'is_active'  => true,
        ]);

        return redirect()->route('ga.index')->with('success', 'تمت إضافة إعدادات Google Analytics بنجاح.');
    }

    public function update(UpdateGoogleAnalyticsTrackerRequest $request, MarketingTracker $ga)
    {
        $ga->update($request->validated());

        return redirect()->route('ga.index')->with('success', 'تم تحديث إعدادات Google Analytics بنجاح.');
    }
}
