<?php

namespace App\Http\Controllers;

use App\Models\MarketingTracker;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MarketingTrackerController extends Controller
{
    // قائمة بجميع البيكسلات لنوع معين
    public function index(string $type)
    {
        $trackers = MarketingTracker::where('type', $type)->get();
        $tracker = MarketingTracker::where('type', $type)->first(); // فقط أول واحد
        return view("marketing.$type.index", compact('trackers', 'type','tracker'));
    }

    // عرض نموذج الإضافة
    public function create(string $type)
    {
        return view("marketing.$type.create", compact('type'));
    }

    // حفظ البيكسل
    public function store(Request $request, string $type)
    {
        $validated = $request->validate([
            'name' => $type === 'facebook' || $type === 'tiktok' ? 'required|string|max:255' : 'nullable',
            'identifier' => 'required|string|max:255',
            'token' => 'nullable|string|max:255',
        ]);

        $validated['type'] = $type;
        $validated['is_active'] = true;

        MarketingTracker::create($validated);

        return redirect()->route('marketing.index', $type)->with('success', 'تمت الإضافة بنجاح');
    }

    // تعديل البيكسل
    public function edit(string $type, MarketingTracker $marketingTracker)
    {
        return view("marketing.$type.edit", compact('marketingTracker', 'type'));
    }

    // تحديث البيكسل
    public function update(Request $request, string $type, MarketingTracker $marketingTracker)
    {
        $validated = $request->validate([
            'name' => $type === 'facebook' || $type === 'tiktok' ? 'required|string|max:255' : 'nullable',
            'identifier' => 'required|string|max:255',
            'token' => 'nullable|string|max:255',
            'is_active' => 'required|boolean',
        ]);

        $marketingTracker->update($validated);

        return redirect()->route('marketing.index', $type)->with('success', 'تم التحديث بنجاح');
    }

    // حذف البيكسل
    public function destroy(string $type, MarketingTracker $marketingTracker)
    {
        $marketingTracker->delete();
        return redirect()->route('marketing.index', $type)->with('success', 'تم الحذف بنجاح');
    }
}
