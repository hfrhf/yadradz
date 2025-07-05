<?php

namespace App\Http\Controllers;

use App\Models\Blacklist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBlacklistRequest;
use App\Http\Requests\UpdateBlacklistRequest;

class BlacklistController extends Controller
{
    public function index()
    {
        $blacklists = Blacklist::latest()->get();
        return view('blacklist.index', compact('blacklists'));
    }

    public function create()
    {
        return view('blacklist.create');
    }

    public function store(StoreBlacklistRequest $request)
    {
        // التحقق من الصحة يتم تلقائيًا
        Blacklist::create($request->validated());
        return to_route('blacklist.index')->with('success', 'تمت الإضافة إلى القائمة السوداء بنجاح.');
    }

    public function edit(Blacklist $blacklist)
    {
        return view('blacklist.edit', compact('blacklist'));
    }

    public function update(UpdateBlacklistRequest $request, Blacklist $blacklist)
    {
        // التحقق من الصحة يتم تلقائيًا
        $blacklist->update($request->validated());
        return to_route('blacklist.index')->with('success', 'تم تحديث بيانات القائمة السوداء بنجاح.');
    }

    public function destroy(Blacklist $blacklist)
    {
        $blacklist->delete();
        return back();
    }
}
