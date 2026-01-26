<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\AccountApproved;
use App\Notifications\AccountRejected;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function approve($id)
    {
        $user = User::findOrFail($id);

        // Save WHO approved it and WHEN
        $user->update([
            'is_approved' => true,
            'approved_at' => now(),
            'approved_by' => Auth::id(), // The currently logged-in admin
        ]);

        // Notification logic (Keep your existing try-catch here)
        $user->notify(new \App\Notifications\AccountApproved());

        return back()->with('success', 'User approved!');
    }

    public function reject($id)
    {
        $user = User::findOrFail($id);

        $user->notify(new \App\Notifications\AccountRejected());

        if ($user->id_image_path) {
            Storage::disk('public')->delete($user->id_image_path);
        }
        $user->delete();

        return back()->with('success', 'User rejected, notified, and removed.');
    }
    
    public function history()
    {
        $approvedUsers = User::where('is_approved', true)
                            ->where('role', '!=', 'admin') // Exclude other admins
                            ->whereNotNull('approved_at')  // Only show ones with logs
                            ->with('approver')             // Load the admin info
                            ->latest('approved_at')
                            ->get();

        return view('admin.users.history', compact('approvedUsers'));
    }

    public function index()
    {
        $pendingUsers = User::where('is_approved', false)->where('role', '!=', 'admin')->get();
        
        return view('admin.users.index', compact('pendingUsers'));
    }

}