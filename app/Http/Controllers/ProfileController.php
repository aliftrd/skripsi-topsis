<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return view('app.profile.index');
    }

    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique(User::class)->ignore(Auth::user()->email, 'email'),
            ],
            'password' => 'required|current_password',
        ]);

        Auth::user()->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        return back()->with('success', __('general.notifications.updated'));
    }

    public function updatePassword(Request $request)
    {
        return view('app.profile.update-password');
    }

    public function doUpdatePassword(Request $request)
    {
        $validated = $request->validate([
            'old_password' => 'required|current_password',
            'new_password' => 'required|min:8',
            'confirm_password' => 'required|confirmed:new_password'
        ]);

        Auth::user()->update([
            'password' => Hash::make($validated['new_password']),
        ]);

        return back()->with('success', __('general.notifications.updated'));
    }
}
