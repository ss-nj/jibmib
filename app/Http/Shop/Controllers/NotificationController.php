<?php

namespace App\Http\Shop\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Shop\Models\Notification;
use App\Support\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::guard('shop')->user()->notifications;
        return view('shop.notifications.index', compact('notifications'));
    }

    public function dismiss()
    {

        Auth::guard('shop')->user()->notifications()->update(['status'=>1]);

        return 1;
    }
}
