<?php
namespace App\Http\Controllers;

use App\Models\AdminInfo;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\AdminInfoRequest;
use App\Traits\PermissionMiddlewareTrait;

class AdminInfoController extends Controller
{
    use PermissionMiddlewareTrait;
    public function __construct()
    {

        $this->applyPermissionMiddleware('admin_info'); // أو 'order' أو 'category' حسب الحاجة
    }
    public function index()
    {
        $info = Cache::remember('info_admin', 3600, function () {
            return AdminInfo::first();
        });

        return view('info.index', compact('info'));
    }

    public function edit(AdminInfo $info)
    {
        return view('info.edit', compact('info'));
    }

    public function update(AdminInfoRequest $request)
    {
        // هنا نقوم بجلب المعلومات فقط دون إنشاء سجل جديد إذا لم يكن موجوداً
        $info = AdminInfo::first();

        $info->update($request->validated());

        Cache::forget('info_admin');
        return redirect()->route('info.index');
    }
}
