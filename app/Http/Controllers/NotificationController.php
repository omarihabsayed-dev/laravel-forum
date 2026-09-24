<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function readNotification($id) {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        return redirect()->route('discussion.show', $notification->data['discussion']['slug']);
    }
}
