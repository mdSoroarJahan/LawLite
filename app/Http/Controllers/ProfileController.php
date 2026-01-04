<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Show the user's profile
     */
    public function show(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        return view('profile.show', compact('user'));
    }

    /**
     * Update the user's profile
     */
    public function update(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'language_preference' => 'nullable|string|in:en,bn',
            'profile_photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }
            $validated['profile_photo_path'] = $request->file('profile_photo')->store('profile-photos', 'public');
        }

        $user->update($validated);

        if ($user->role === 'lawyer') {
            $lawyerData = $request->validate([
                'bio' => 'nullable|string|max:1000',
                'expertise' => 'nullable|string|max:255',
                'hourly_rate' => 'nullable|numeric|min:0',
                'city' => 'nullable|string|max:255',
                'license_number' => 'nullable|string|max:255',
                'education' => 'nullable|string|max:1000',
            ]);

            if (isset($lawyerData['education'])) {
                $lawyerData['education'] = array_filter(array_map('trim', explode("\n", $lawyerData['education'])));
            }

            $user->lawyer()->updateOrCreate(
                ['user_id' => $user->id],
                $lawyerData
            );
        }

        return back()->with('success', 'Profile updated successfully.');
    }

    /**
     * Update the user's password
     */
    public function updatePassword(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('profile.show')->with('success', 'Password updated successfully!');
    }
}
