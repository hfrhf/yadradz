<?php

namespace App\Http\Controllers;

use App\Models\GoogleSheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreGoogleSheetRequest;
use App\Http\Requests\UpdateGoogleSheetRequest;

class GoogleSheetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sheet = GoogleSheet::first();
        return view('sheets.index', compact('sheet'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sheets.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGoogleSheetRequest $request)
    {
        if (GoogleSheet::exists()) {
            return back()->with('error', 'الإعداد موجود بالفعل، يمكنك فقط تعديله.');
        }

        // تم التحقق من صحة الطلب تلقائيًا
        $validated = $request->validated();

        $jsonContent = file_get_contents($request->file('json'));
        $encrypted = Crypt::encryptString($jsonContent);

        GoogleSheet::create([
            'service_account_json' => $encrypted,
            'spreadsheet_id' => $validated['spreadsheet_id'],
            'sheet_name' => $validated['sheet_name'],
        ]);

        return back()->with('success', 'تم حفظ إعدادات Google Sheets بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(GoogleSheet $googleSheet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $sheet = GoogleSheet::firstOrFail();
        return view('sheets.edit', compact('sheet'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGoogleSheetRequest $request)
    {
        $sheet = GoogleSheet::firstOrFail();
        $validated = $request->validated();

        if ($request->hasFile('json')) {
            $json = file_get_contents($request->file('json'));
            $sheet->service_account_json = Crypt::encryptString($json);
        }

        $sheet->spreadsheet_id = $validated['spreadsheet_id'];
        $sheet->sheet_name = $validated['sheet_name'];
        $sheet->save();

        return redirect()->route('google-sheets.index')->with('success', 'تم تحديث الإعداد بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GoogleSheet $googleSheet)
    {
        $googleSheet->delete();
        return redirect()->route('google-sheets.index')->with('success', 'تم حذف الإعداد بنجاح');
    }
}
