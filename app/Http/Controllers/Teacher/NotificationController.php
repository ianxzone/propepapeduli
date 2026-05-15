<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $query = Notification::latest();

        if ($user->role === 'teacher') {
            $query->where('target_class_id', $user->class_id);
        }

        $notifications = $query->paginate(20);

        // Mark all as read when visiting the index
        Notification::whereNull('read_at')
            ->where(function($q) use ($user) {
                if ($user->role === 'teacher') {
                    $q->where('target_class_id', $user->class_id);
                }
            })->update(['read_at' => now()]);

        return view('teacher.notifications.index', compact('notifications'));
    }

    public function markAsRead(Notification $notification)
    {
        $notification->update(['read_at' => now()]);
        return back();
    }
}
