<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\PermissionMiddlewareTrait;
use Illuminate\Support\Facades\Notification;
use App\Http\Requests\SendNotificationRequest;
use App\Notifications\AdminCustomNotification;

class AdminNotificationController extends Controller
{
    use PermissionMiddlewareTrait;
    public function __construct()
    {

        $this->applyPermissionMiddleware('notification'); // أو 'order' أو 'category' حسب الحاجة
    }
    public function create()
    {
        $users = User::all(); // لجلب المستخدمين في حال أردت الإرسال لشخص معين
        return view('notifications.create', compact('users'));
    }

    public function send(SendNotificationRequest $request) // 2. استخدام الـ Request الجديد هنا
    {



        $notification = new AdminCustomNotification($request->title, $request->message);

        if ($request->recipients === 'all') {
            $users = User::all();
            Notification::send($users, $notification);
            $message = 'تم إرسال الإشعار لجميع المستخدمين بنجاح.';
        } else {
            // الطلب تم التحقق منه بالفعل، لذا نحن متأكدون من وجود user_id
            $user = User::find($request->user_id);
            $user->notify($notification);
            $message = "تم إرسال الإشعار للمستخدم: {$user->name} بنجاح.";
        }

        return back()->with('success', $message);
    }
}
