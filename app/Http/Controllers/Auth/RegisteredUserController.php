<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\NewUserRegistered;
use App\Notifications\SignUp;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string'],
            // Add ID validation
            'id_image' => ['required', 'image', 'max:2048'], // Max 2MB
        ]);

        // Handle File Upload
        $path = null;
        if ($request->hasFile('id_image')) {
            // Stores in storage/app/public/id_cards
            $path = $request->file('id_image')->store('id_cards', 'public');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'section' => $request->section,
            'department' => $request->department,
            'id_image_path' => $path,
            'is_approved' => false, // <--- User cannot login yet
        ]);

        // In RegisteredUserController.php
        $admins = User::where('role', 'admin')->orWhere('role', 'Admin')->get();
        
        // send notification to all admins about new registration
        Notification::send($admins, new \App\Notifications\NewUserRegistered($user));

        // Redirect to a "Wait for Approval" page
        return redirect()->route('approval.notice')->with('name', $user->name);
    }
}
