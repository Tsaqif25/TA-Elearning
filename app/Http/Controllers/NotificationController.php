<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth; 
use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
  public function index(){
    $notifications = Notification::where('user_id',Auth::id())
    ->orWhereNull('user_id')
    ->orderBy('created_at','desc')
    ->get();

    return view('notifications.index',compact('notifications'));
  }

  public function markAsRead($id)
  {
    $notif = Notification::findOrFail($id);
    $notif->update(['is_read' => true]);

    return back();
  }

  public function latest()
{
    $notifications = Notification::where(function ($query) {
        $query->where('user_id', auth()->id())
              ->orWhereNull('user_id');
    })
    ->latest()
    ->take(5)
    ->get();

    return view('notifications.dropdown', compact('notifications'));
}

}
