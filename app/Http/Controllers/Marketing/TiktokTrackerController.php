<?php

namespace App\Http\Controllers\Marketing;

use Illuminate\Http\Request;
use App\Models\MarketingTracker;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTiktokTrackerRequest;
use App\Http\Requests\UpdateTiktokTrackerRequest;

class TiktokTrackerController extends Controller
{
    public function index()
    {
        $trackers = MarketingTracker::where('type', 'tiktok')->get();
        return view('marketing.tiktok.index', compact('trackers'));
    }

    public function create()
    {
        return view('marketing.tiktok.create');
    }

    public function store(StoreTiktokTrackerRequest $request)
    {
        $validated = $request->validated();

        MarketingTracker::create([
            'name'       => $validated['name'],
            'identifier' => $validated['identifier'],
            'token'      => $validated['token'],
            'type'       => 'tiktok',
            'is_active'  => true,
        ]);

        return redirect()->route('tiktok.index')->with('success', 'تمت إضافة متتبع تيك توك بنجاح.');
    }

    public function edit(MarketingTracker $tiktok)
    {
        return view('marketing.tiktok.edit', compact('tiktok'));
    }

    public function update(UpdateTiktokTrackerRequest $request, MarketingTracker $tiktok)
    {
        $tiktok->update($request->validated());

        return redirect()->route('tiktok.index')->with('success', 'تم تحديث متتبع تيك توك بنجاح.');
    }

    public function destroy(MarketingTracker $tiktok)
    {
        $tiktok->delete();
        return redirect()->route('tiktok.index')->with('success', 'تم الحذف');
    }
}
