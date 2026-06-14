<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()
                             ->notifications()
                             ->latest()
                             ->paginate(15);

        return view('etudiant.notifications', compact('notifications'));
    }

    public function marquerLue(int $id)
    {
        $notif = Notification::where('user_id', Auth::id())
                             ->findOrFail($id);
        $notif->update(['lu' => true]);

        return back()->with('success', 'Notification marquée comme lue.');
    }
}