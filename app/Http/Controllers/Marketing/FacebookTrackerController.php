<?php

namespace App\Http\Controllers\Marketing;

use Illuminate\Http\Request;
use App\Models\MarketingTracker;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFacebookTrackerRequest;
use App\Http\Requests\UpdateFacebookTrackerRequest;

class FacebookTrackerController extends Controller
{
    public function index()
    {
        $trackers = MarketingTracker::where('type', 'facebook')->get();
        return view('marketing.facebook.index', compact('trackers'));
    }

    public function create()
    {
        return view('marketing.facebook.create');
    }

    public function store(StoreFacebookTrackerRequest $request)
    {
        $validated = $request->validated();

        MarketingTracker::create([
            'name'       => $validated['name'],
            'identifier' => $validated['identifier'],
            'token'      => $validated['token'],
            'type'       => 'facebook',
            'is_active'  => true,
        ]);

        return redirect()->route('facebook.index')->with('success', 'تمت إضافة متتبع فيسبوك بنجاح.');
    }

    public function edit(MarketingTracker $facebook)
    {
        return view('marketing.facebook.edit', compact('facebook'));
    }

    public function update(UpdateFacebookTrackerRequest $request, MarketingTracker $facebook)
    {
        $facebook->update($request->validated());

        return redirect()->route('facebook.index')->with('success', 'تم تحديث متتبع فيسبوك بنجاح.');
    }

    public function destroy(MarketingTracker $facebook)
    {
        $facebook->delete();
        return redirect()->route('facebook.index')->with('success', 'تم الحذف');
    }
}
