<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\User;
use App\Models\Role;
use App\Http\Requests\UpdateGeneralSettingsRequest;
use App\Http\Requests\UpdateNotificationSettingsRequest;
use App\Http\Requests\UpdateSecuritySettingsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    /**
     * Display general settings page.
     */
    public function general()
    {
        $settings = Setting::instance();

        return view('settings.general', [
            'settings' => $settings,
        ]);
    }

    /**
     * Update general settings.
     */
    public function updateGeneral(UpdateGeneralSettingsRequest $request)
    {
        $settings = Setting::instance();
        $settings->update($request->validated());

        return redirect()->route('settings.general')
            ->with('success', 'General settings updated successfully!');
    }

    /**
     * Display notification settings page.
     */
    public function notifications()
    {
        $settings = Setting::instance();

        return view('settings.notifications', [
            'settings' => $settings,
        ]);
    }

    /**
     * Update notification settings.
     */
    public function updateNotifications(UpdateNotificationSettingsRequest $request)
    {
        $settings = Setting::instance();
        $settings->update($request->validated());

        return redirect()->route('settings.notifications')
            ->with('success', 'Notification settings updated successfully!');
    }

    /**
     * Display security settings page.
     */
    public function security()
    {
        $user = auth()->user();

        return view('settings.security', [
            'user' => $user,
        ]);
    }

    /**
     * Update security settings.
     */
    public function updateSecurity(UpdateSecuritySettingsRequest $request)
    {
        $settings = Setting::instance();
        
        if ($request->has('enable_two_factor')) {
            $settings->update([
                'enable_two_factor' => $request->boolean('enable_two_factor'),
            ]);
        }

        if ($request->has('session_timeout')) {
            $settings->update([
                'session_timeout' => $request->integer('session_timeout'),
            ]);
        }

        return redirect()->route('settings.security')
            ->with('success', 'Security settings updated successfully!');
    }

    /**
     * Display user profile settings.
     */
    public function profile()
    {
        $user = auth()->user();

        return view('settings.profile', [
            'user' => $user,
        ]);
    }

    /**
     * Update user profile.
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . auth()->id(),
            'company' => 'nullable|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only('name', 'email', 'company');

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            $user = auth()->user();
            if ($user->profile_image && \Storage::disk('public')->exists($user->profile_image)) {
                \Storage::disk('public')->delete($user->profile_image);
            }
            $path = $request->file('profile_image')->store('profile', 'public');
            $data['profile_image'] = $path;
        }

        auth()->user()->update($data);

        return redirect()->route('settings.profile')
            ->with('success', 'Profile updated successfully!');
    }

    /**
     * Update user password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
        ]);

        auth()->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('settings.profile')
            ->with('success', 'Password updated successfully!');
    }

    /**
     * Display roles and permissions management.
     */
    public function roles()
    {
        $roles = Role::with('permissions')->get();

        return view('settings.roles', [
            'roles' => $roles,
        ]);
    }
}
