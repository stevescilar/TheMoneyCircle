<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MemberNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $notifications = MemberNotification::where('member_id', $user->id)
            ->orderByDesc('created_at')
            ->limit(50)
            ->get()
            ->map(fn ($n) => [
                'id'            => $n->id,
                'type'          => $n->type,
                'title'         => $n->title,
                'message'       => $n->message,
                'action_target' => $n->action_target,
                'is_read'       => !is_null($n->read_at),
                'read_at'       => $n->read_at?->toIso8601String(),
                'created_at'    => $n->created_at->toIso8601String(),
                'time_ago'      => $n->created_at->diffForHumans(),
            ]);

        $unreadCount = MemberNotification::where('member_id', $user->id)->unread()->count();

        return response()->json([
            'notifications' => $notifications,
            'unread_count'  => $unreadCount,
        ]);
    }

    public function markRead(Request $request, MemberNotification $notification)
    {
        abort_unless($notification->member_id === $request->user()->id, 403);

        $notification->markAsRead();

        return response()->json([
            'message'      => 'Notification marked as read.',
            'notification' => $notification,
        ]);
    }

    public function markAllRead(Request $request)
    {
        $user = $request->user();

        MemberNotification::where('member_id', $user->id)
            ->unread()
            ->update(['read_at' => now()]);

        return response()->json([
            'message' => 'All notifications marked as read.',
        ]);
    }
}

