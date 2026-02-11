<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
 public function poll()
    {
        $user = Auth::user();

        $unreadCount = $user->unreadNotifications()->count();
        $notis = $user->notifications()->latest()->limit(8)->get();

        return response()->json([
            'count' => $unreadCount,
            'items' => $notis->map(function ($n) {
                return [
                    'id' => $n->id,
                    'read' => (bool) $n->read_at,
                    'title' => $n->data['title'] ?? 'Notification',
                    'subtitle' => $n->data['subtitle'] ?? null,
                    'icon' => $n->data['icon'] ?? '🔔',
                    'url' => $n->data['url'] ?? '#',
                    'time' => $n->created_at->diffForHumans(),
                ];
            }),
        ]);
    }

    public function markAllRead()
    {
        $user = Auth::user();
        $user->unreadNotifications->markAsRead();

        return response()->json(['ok' => true, 'count' => 0]);
    }

    public function clearAll()
    {
        $user = Auth::user();

        $deleted = $user->notifications()->delete();
        
        return response()->json([
            'ok' => true,
            'deleted' => $deleted
        ]);
    }
}
